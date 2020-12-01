<?php
class open_alipay_miniControl extends skymvc
{
	public $alipay;
    public function __construct()
    {
        parent::__construct();
    }
    public function upload_oss($files)
    {
        $this->loadClass("image");
        $this->loadClass("upload");
    
        $this->upload->uploaddir="attach/".$this->sitedir;
        set_time_limit(100);
        include_once(ROOT_PATH."api/ossapi/ossapi.php");
        if (!UPLOAD_OSS) {
            return false;
        }
        if (empty($files)) {
            return false;
        }
        $arr=array("",".100x100.jpg",".small.jpg",".middle.jpg");
        foreach ($arr as $a) {
            if (file_exists(ROOT_PATH.$files.$a)) {
                $to=str_replace("//", "/", $files.$a);
                $from=ROOT_PATH.$files.$a;
                $response = oss_upload_file(array("bucket"=>OSS_BUCKET,"to"=>$to,"from"=>$from));
                if (defined("UPLOAD_DEL") && UPLOAD_DEL) {
                    @unlink($from);
                }
            }
        }
    }
    public function onDefault()
    {
		
    }
    public function get()
    {
        $id=get_post('id', 'i');
        if ($id) {
            $where=" id=".$id;
        } else {
            $where="";
        }
        $this->alipay=M("open_alipay_mini")->selectRow(array("where"=>$where,"order"=>"id DESC"));
        return $this->alipay;
    }
	
	public function onLogin(){
		require_once ROOT_PATH.'api/alimini/AopCertClient.php';
		require_once ROOT_PATH.'api/alimini/AopCertification.php';
		require_once ROOT_PATH.'api/alimini/request/AlipaySystemOauthTokenRequest.php';
		require_once ROOT_PATH.'api/alimini/request/AlipayUserInfoShareRequest.php'; 
		$config=$this->get();
		
		$code=post("code","h");
		$aop = new AopCertClient ();
		$appCertPath = ROOT_PATH.$config["appcert_path"];
		$alipayCertPath = ROOT_PATH.$config["alicert_path"];
		$rootCertPath = ROOT_PATH.$config["rootcert_path"];
		$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
		$aop->appId = $config["appid"];
		$aop->rsaPrivateKey = $config["merchant_private_key"];
	 
		$aop->alipayrsaPublicKey = $aop->getPublicKey($alipayCertPath);
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='utf-8';
		$aop->format='json';
		$aop->isCheckAlipayPublicCert = true;//是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
		$aop->appCertSN = $aop->getCertSN($appCertPath);//调用getCertSN获取证书序列号
		$aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);//调用getRootCertSN获取支付宝根证书序列号
		
		$request = new AlipaySystemOauthTokenRequest ();
		$request->setGrantType("authorization_code");
		$request->setCode($code);
		//$request->setRefreshToken("201208134b203fe6c11548bcabd8da5bb087a83b");
		$result = $aop->execute ( $request); 
		
		$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
		$resultCode = $result->$responseNode->code;
		if(!empty($resultCode)&&$resultCode != 10000){
			
			$this->goAll("error",1);
		} else {
			
			$res=$result->alipay_system_oauth_token_response;
			 
			if(!isset($res->user_id)){
				 
				$this->goAll("授权出错，获取openid出错",1);
			}
			$openid=$res->user_id;
			$accessToken=$res->access_token;
			$json=array(
				"openid"=>$res->user_id,					 
			);
			$user_wxhead=post("user_head","h");
			$user_head="";
			$nickname=post("nickname","h");
			if(empty($nickname)){
				$nickname="默".time();
			}
			$gender=post("gender")=='F'?1:0;
			//开启注册流程
			if($json['openid']){
				$ouser=M("openlogin")->getRow("SELECT *  FROM ".table('openlogin')." WHERE openid='".$json['openid']."' AND xfrom='alipay_mini' ");				
				if($ouser){
					if(!$ouser['userid']){
						$this->openlogin($ouser);
						
					}else{
						$user=M("user")->selectRow("userid=".$ouser['userid']);
						$puser=M("user_password")->selectRow("userid=".$user['userid']);
						$auth=M("login")->setCode($puser);						 
						$authcode=$auth['authcode'];
						$rdata=array(
							"action"=>"login",
							"userid"=>$user['userid'],
							"authcode"=>$authcode,
							"authcodeLong"=>$auth['authcodeLong'],
							"user_head"=>$user_head,
							"nickname"=>$nickname,
							"gender"=>$gender,
							"openid"=>$json['openid']
						);
						$this->goAll("success",0,$rdata);
					}
					
				}else{
					if($user_wxhead && basename($user_wxhead)!='undefined'){
						$dir="attach/user_head/".date("Y/m/d");
						umkdir($dir);
						$user_head=$dir."/".base64_encode($nickname).time().".jpg";				
						file_put_contents($user_head,curl_get_contents($user_wxhead));				
						$this->loadClass("image",false,false);
						$img=new image();
						$img->makethumb($user_head.".100x100.jpg",$user_head,"100","100",1);
						$img->makethumb($user_head.".small.jpg",$user_head,"240");
						$img->makethumb($user_head.".middle.jpg",$user_head,"440");
					}
					//关联插件
					$data=array(
						"nickname"=>$nickname,					
						"xfrom"=>'alipay_mini',
						"openid"=>$json['openid'],
						"createtime"=>date("Y-m-d H:i:s")		
					);
					if($user_head){
						$data['user_head']=$user_head;
					}
					
					$this->upload_oss($user_head);
					$data['id']=M("openlogin")->insert($data);
					$ouser=$data;
					$_SESSION['ssopenlogin']=$data;
					$this->openlogin($ouser);								
				}
				
				
			}else{
				echo json_encode(array(
					"openid"=>"",
					"message"=>"登录出错"
				));
			}
			
		} 
		
	}
	
	public function openlogin($ouser){
		if($this->alipay['openlogin']){
			$openToken=Md5("openlogintoken".rand(1111,9999));
			cache()->set($openToken,$ouser['id'],120);
			$rdata=array(
				"action"=>"openlogin",
				"openid"=>$ouser['openid'],
				"oid"=>$ouser['id'],
				"openToken"=>$openToken,
			);
			$this->goAll("success",0,$rdata);
		}else{
			//生成账户
			$i=0;
			$nickname=$u=$ouser['nickname'];
			while(M("user")->getOne("SELECT userid FROM ".table('user')." WHERE  nickname='$u' or username='$u' "))
			{
				$i++;
				$u=$nickname.$i;
			}
			$data=array(
				"nickname"=>$u,
				"username"=>$u, 
				"createtime"=>date("Y-m-d H:i:s"),		
			);
			if($ouser['user_head']){
				$data['user_head']=$ouser['user_head'];
			}
			if(get_post('invite_userid')){
				$_COOKIE['invite_uid']=$data['invite_userid']=intval(post('invite_userid'));
			}elseif(isset($_COOKIE['invite_uid'])){
				$data['invite_userid']=intval($_COOKIE['invite_uid']);
			}
			$userid=M("user")->insert($data);
			//更新
			M("openlogin")->update(array(
				"userid"=>$userid
			),"id=".$ouser['id']);
			M("invite")->invite_reg($userid,$data['username']);
			$user=M("user")->getUser($userid);
			M('login')->set("ssuser",$user);
			//密码
			$salt=rand(1000,9000);
			$password=umd5(time().$salt);
			$puser=array(
				"userid"=>$userid,
				"password"=>$password,
				"salt"=>$salt
			);
			M("user_password")->insert($puser);
			
			$auth=M("login")->setCode($puser);
			$authcode=$auth['authcode'];
			setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
			
			$rdata=array(
				"action"=>"login",
				"userid"=>$userid,
				"authcode"=>$authcode,
				"authcodeLong"=>$auth['authcodeLong'],
				"user_head"=>$data['user_head'],
				"nickname"=>$data['nickname'],
				"gender"=>$data['gender'],
				"openid"=>$ouser['openid']
			);
			$this->goAll("success",0,$rdata);
			exit;
		}
	} 
}
