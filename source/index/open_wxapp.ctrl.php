<?php
class open_wxappControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
		
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
			$wx=M("open_wxapp")->selectRow(array("where"=>$where,"order"=>"id DESC"));
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
					$data=array(
						"username"=>$nickname,						 
						"user_head"=>$user_head,
						"nickname"=>$nickname,
						"gender"=>$gender,
						
						"createtime"=>date("Y-m-d H:i:s"),
						"invite_userid"=>$invite_userid
					);
					$userid=M("user")->insert($data);
					M("invite")->invite_reg($userid,$data['username']);	
					$salt=rand(1000,9000);
					$password=umd5(time().$salt);
					M("user_password")->insert(array(
						"userid"=>$userid,
						"password"=>$password,
						"salt"=>$salt
					));
					M("openlogin")->update(array(
						"userid"=>$userid
					),"id=".$ouser['id']);
					$puser=array(
						"userid"=>$userid,
						"password"=>$password
					);
					$auth=M("login")->setCode($puser);
					$authcode=$auth['authcode'];
					cache()->set("authcode",$authcode,3600*24*30);
					$rdata=array(
						"action"=>"login",
						"userid"=>$userid,
						"authcode"=>$authcode,
						"authcodeLong"=>$auth['authcodeLong'],
						"user_head"=>$user_head,
						"nickname"=>$nickname,
						"gender"=>$gender,
						"openid"=>$json['openid']
					);
					$this->goAll("success",0,$rdata);
					exit;
				}else{
					$user=M("user")->selectRow("userid=".$ouser['userid']);
					$puser=M("user_password")->selectRow("userid=".$user['userid']);
					$auth=M("login")->setCode($puser);
			 
					$authcode=$auth['authcode'];
					cache()->set("authcode",$authcode,3600*24*30);
				 
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
				//生成账户
				$i=0;
				$u=$nickname;
				while(M("user")->getOne("SELECT userid FROM ".table('user')." WHERE  username='$u' or nickname='$u' "))
				{
					$i++;
					$u=$nickname.$i;
				}
				$username=$nickname=$u;
				//判断小程序登录方式
				$goLogin=1;
				$invite_userid=get_post("invite_userid");
				if($goLogin){
					$data=array(
						"username"=>$username,						 
						"user_head"=>$user_head,
						"nickname"=>$nickname,
						"gender"=>$gender,
						 
						"createtime"=>date("Y-m-d H:i:s"),
						"invite_userid"=>$invite_userid
					);
					$userid=M("user")->insert($data);
					M("invite")->invite_reg($userid,$data['username']);	
					$salt=rand(1000,9000);
					$password=umd5(time().$salt);
					M("user_password")->insert(array(
						"userid"=>$userid,
						"password"=>$password,
						"salt"=>$salt
					));
					//插入三方
					$odata=array(
						"userid"=>$userid,
						"nickname"=>$nickname,					
						"xfrom"=>'wxapp',
						"openid"=>$json['openid'],
						"createtime"=>date("Y-m-d H:i:s"),
						"user_head"=>$user_head,
					);
					M("openlogin")->insert($odata);
					//三方完成
					$auth=M("login")->setCode($puser);
					$authcode=$auth['authcode'];
					cache()->set("authcode",$authcode,3600*24*30);

					$rdata=array(
						"action"=>"login",
						"userid"=>$userid,
						"authcode"=>$authcode,
						"authcodeLong"=>$auth['authcodeLong'],
						"user_head"=>$user_head,
						"nickname"=>$nickname,
						"gender"=>$gender,
						"openid"=>$openid
					);
					$this->goAll("success",0,$rdata);
					
				}
				
				
			}
			
			
		}else{
			echo json_encode(array(
				"openid"=>"",
				"message"=>"登录出错"
			));
		}
		
	}
	
	 
	
	
}
?>