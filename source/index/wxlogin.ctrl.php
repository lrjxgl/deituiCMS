<?php
class wxloginControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onInit(){
		if($_SESSION['ssuser']){
			header("Location: /index.php");
			exit;
		}
		$wid=get_post('wid','i');
		if($wid){
			$where=" id=".$wid;
		}else{
			$where="";
		}
		$this->wx=M("weixin")->selectRow(array("where"=>$where,"order"=>"id DESC"));
		$backurl=get_post('backurl','h');
		if(!$backurl){
			$backurl=$_SERVER['HTTP_REFERER'];
		}
		if(preg_match("/login/i",$backurl)){
			$backurl="/index.php";
		}
		define("WXTOKEN",$this->wx['token']);
		define("APPID",$this->wx['appid']);
		define("APPSECRET",$this->wx['appkey']);
		define("REDIRECT_URI","http://".$_SERVER['HTTP_HOST']."/index.php?m=wxlogin&a=callback&backurl=".urlencode($backurl)."&wid=".$this->wx['id']);
	}
	public function upload_oss($files){
		$this->loadClass("image");
		$this->loadClass("upload");

		$this->upload->uploaddir="attach/".$this->sitedir; 
	 
		if(empty($_SESSION['ssuser']) && empty($_SESSION['ssadmin']) && empty($_SESSION['ssshopadmin'])){
			$this->goall("die access",1);
		}
		session_write_close();
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
		echo "hello";
	}
	
public function onGeturl()
{
	$backurl=get('backurl','x'); 
	setcookie("ckwxback",$backurl,time()+3600*24*14,"/",DOMAIN);
	$url=" https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".urlencode(REDIRECT_URI)."&backurl=".urlencode($backurl)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
	header("Location: $url");
	exit();
}

public function oncallback()
{
	$backurl=base64_decode($_COOKIE['ckwxback']);
	if(!$backurl){
		$backurl=$_SERVER['HTTP_REFERER'];
	}
	if(preg_match("/login/i",$backurl)){
		$backurl="/index.php";
	}
	
	$c=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$_GET['code']."&grant_type=authorization_code");
	$data=json_decode($c,true);
	if(isset($data['access_token'])){
		if(!empty($data['openid'])){
			$arr=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$data['access_token']."&openid=".$data['openid']."&lang=zh_CN");
			$arr=json_decode($arr,true);
			
			$nickname=$arr['nickname'];
			if(empty($nickname))
			{
				$this->goall('微信接口错误',1,0,'/index.php?m=index');
			}
			$user=M("user")->getRow("SELECT *  FROM ".table('user')." WHERE openid='".$data['openid']."' AND xfrom='weixin' ")
			if($user)
			{
				M('login')->set("ssuser",$user);
				$authcode=jiami($user['userid']."|".umd5(substr($user['password'],0,12)));
				setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
				
				
				header("Location: ".$backurl);
				exit('wwwwww');
				//$this->goall('登陆成功',1,0,'/index.php');
			}else
			{
				//生成账户
				$i=0;
				$u=$nickname;
				while(M("user")->getOne("SELECT userid FROM ".table('user')." WHERE  nickname='$u' "))
				{
					$i++;
					$u=$nickname.$i;
				}
				
				$dir="attach/user_head/".date("Y/m/d");
				umkdir($dir);
				if($arr['headimgurl']){
					$user_head=$dir."/".md5($u).time().".jpg";
					
					file_put_contents($user_head,curl_get_contents($arr['headimgurl']));
					
					$this->loadClass("image",false,false);
					$img=new image();
					$img->makethumb($user_head.".100x100.jpg",$user_head,"100","100",1);
					$img->makethumb($user_head.".small.jpg",$user_head,"240");
					$img->makethumb($user_head.".middle.jpg",$user_head,"440");
				}
				//关联插件
				$data=array(
					"nickname"=>$u,
					"username"=>$u, 
					"xfrom"=>'weixin',
					"openid"=>$data['openid'],
					"createtime"=>date("Y-m-d H:i:s"),
					"lastfeed"=>time(),
					
				);
				if($user_head){
					$data['user_head']=$user_head;
				}
				if(get_post('invite_userid')){
					$_COOKIE['invite_uid']=$data['invite_userid']=intval(post('invite_userid'));
				}elseif(isset($_COOKIE['invite_uid'])){
					$data['invite_userid']=intval($_COOKIE['invite_uid']);
				}
				$userid=M("user")->insert($data);
				M("invite")->invite_reg($userid,$data['username']);
				$user=M("user")->getRow("SELECT * FROM ".table('user')." WHERE userid='$userid' ");
				M('login')->set("ssuser",$user);
				$authcode=jiami($user['userid']."|".umd5(substr($user['password'],0,12)));
				setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
				
				
				$this->upload_oss($user_head); 
				header("Location: ".$backurl);
				//$this->goall('注册登陆成功',0,0,'/index.php');
			}
		}
		
	}else{
			exit($c);
	}
	
	
}

public function onApp(){
		$access_token=get_post('access_token','h');
		$openid=get_post('openid','h');
		$data=curl_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid);
		$data=json_decode($data,true);
		if(isset($data['openid'])){
			$nickname=$data['nickname'];
						if(empty($nickname))
						{
							$this->goall('微信接口错误',1,0,'/index.php?m=index');
						}
						if($user=M("user")->getRow("SELECT *  FROM ".table('user')." WHERE openid='".$data['openid']."' AND xfrom='weixin' "))
						{
							M('login')->set("ssuser",$user);
							
							$authcode=jiami($user['userid']."|".umd5($user['password']));
							setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
							 /**微信推送*/
							 $_POST['openid']=$data['openid'];
							 $_POST['token']=$data['access_token'];
							 M("apppush")->add("userid",$user);
							 /**End 微信推送**/
							 $redata=array(
								"authcode"=>$authcode
							);
							$this->goall('登陆成功',0,$redata,'/index.php');
						}else
						{
							//生成账户
							$i=0;
							$u=$nickname;
							while(M("user")->getOne("SELECT userid FROM ".table('user')." WHERE  nickname='$u' "))
							{
								$i++;
								$u=$nickname.$i;
							}
							$dir="attach/user_head/".date("Y/m/d");
							umkdir($dir);
							if($arr['headimgurl']){
								$user_head=$dir."/".base64_encode($u).time().".jpg";
								//扔到图片处理计划
								M("cron_img")->insert(array(
									"dateline"=>time(),
									"imgurl"=>$user_head,
									"fromimg"=>$arr['headimgurl'],
									"thumbinfo"=>"100,small,middle"
								));
								
							}
							//关联插件
							$data=array(
								"nickname"=>$u,
								"username"=>$u, 
								"xfrom"=>'weixin',
								"openid"=>$data['openid'],
								"dateline"=>time(),
								"lastfeed"=>time(),
								"openedit"=>1
								
							);
							if($user_head){
								$data['user_head']=$user_head;
							}
							 
							 
							if(isset($_COOKIE['invite_uid'])){
								$data['invite_userid']=intval($_COOKIE['invite_uid']);
							}
							$userid=M("user")->insert($data);
							$this->loadControl("inviteapi");
							$this->inviteapiControl->invite_reg($userid);
							$user=M("user")->getRow("SELECT * FROM ".table('user')." WHERE userid='$userid' "); 
							 M('login')->set("ssuser",$user);
							 $authcode=jiami($user['userid']."|".umd5($user['password']));
							 /**微信推送*/
							 $_POST['openid']=$data['openid'];
							 $_POST['token']=$data['access_token'];
							 M("apppush")->add("userid",$user);
							 /**End 微信推送**/
							setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
							$redata=array(
								"authcode"=>$authcode
							);
							$this->goall('登陆成功',0,$redata,'/index.php');
						}
		}else{
			$this->goAll("登录出错",1);
		}
	}

}
?>