<?php
class open_aliappControl extends skymvc{
	public $wx; 
	public function __construct(){
		parent::__construct();
		
	}
	public function upload_oss($files){
			$this->loadClass("image");
			$this->loadClass("upload");
	
			$this->upload->uploaddir="attach/".$this->sitedir; 
			set_time_limit(100);
			include_once(ROOT_PATH."api/ossapi/ossapi.php");
			if(!UPLOAD_OSS) return false;
			if(empty($files)) return false;
			$arr=array("",".100x100.jpg",".small.jpg",".middle.jpg");
			foreach($arr as $a){		
				if(file_exists(ROOT_PATH.$files.$a)){
					$to=str_replace("//","/",$files.$a);
					$from=ROOT_PATH.$files.$a;
					$response = oss_upload_file(array("bucket"=>OSS_BUCKET,"to"=>$to,"from"=>$from));
					if(defined("UPLOAD_DEL") && UPLOAD_DEL){
						@unlink($from);
					}
				}
			}
		}
	public function onDefault(){
		
	}
	public function getWeixin(){
			$wid=get_post('wid','i');
			if($wid){
			$where=" id=".$wid;
			}else{
			$where="";
			}
			$this->wx=$wx=M("open_aliapp")->selectRow(array("where"=>$where,"order"=>"id DESC"));
			return $wx;
	}
	public function onCode2Session(){
		$wx=$this->getWeiXin();
		$code=get("code","h");
		$res=curl_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=".$wx['appid']."&secret=".$wx['appkey']."&js_code=".$code."&grant_type=authorization_code");
		 
		$data=json_decode($res,true);
		if(isset($data['openid'])){
			$this->goAll("success",0,array(
				"openid"=>$data['openid']
			));
		}else{
			$this->goAll("error",1);
		}
	}
	
	public function onLogin(){
		$code=get_post('code','h');
		$nickname=get_post('nickname','h');
		$user_wxhead=get_post('user_head','h');
		$gender=get_post('gender','i');
		$wx=$this->getWeiXin();
		$res=curl_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=".$wx['appid']."&secret=".$wx['appkey']."&js_code=".$code."&grant_type=authorization_code");
		$json=json_decode($res,true);
		if($json['openid']){
			$ouser=M("openlogin")->getRow("SELECT *  FROM ".table('openlogin')." WHERE openid='".$json['openid']."' AND xfrom='wxapp' ");
						
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
				
				$dir="attach/user_head/".date("Y/m/d");
				umkdir($dir);
				$user_head=$dir."/".base64_encode($nickname).time().".jpg";				
				file_put_contents($user_head,curl_get_contents($user_wxhead));				
				$this->loadClass("image",false,false);
				$img=new image();
				$img->makethumb($user_head.".100x100.jpg",$user_head,"100","100",1);
				$img->makethumb($user_head.".small.jpg",$user_head,"240");
				$img->makethumb($user_head.".middle.jpg",$user_head,"440");
				//关联插件
				$data=array(
					"nickname"=>$nickname,					
					"xfrom"=>'wxapp',
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
	
	public function openlogin($ouser){
		if($this->wx['openlogin']){
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
?>