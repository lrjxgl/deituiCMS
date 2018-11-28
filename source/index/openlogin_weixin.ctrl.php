<?php
class openlogin_weixinControl extends skymvc{
	
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
		define("REDIRECT_URI","http://".$_SERVER['HTTP_HOST']."/index.php?m=openlogin_weixin&a=callback&backurl=".urlencode($backurl)."&wid=".$this->wx['id']);
	}
	public function upload_oss($files){
		$this->loadClass("image");
		$this->loadClass("upload");

		$this->upload->uploaddir="attach/".$this->sitedir; 
	 	/*
		if(empty($_SESSION['ssuser']) && empty($_SESSION['ssadmin']) && empty($_SESSION['ssshopadmin'])){
			$this->goall("die access",1);
		}
		session_write_close();
		*/
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
		/*if(isset($data['access_token'])){
			$c=file_get_contents("https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".APPID."&grant_type=refresh_token&refresh_token=".$data['refresh_token']);
			$data=json_decode($c,true);
		*/	 
			if(isset($data['access_token'])){
				if(!empty($data['openid'])){
					$arr=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$data['access_token']."&openid=".$data['openid']."&lang=zh_CN");
					$arr=json_decode($arr,true);
					
					$nickname=$arr['nickname'];
					if(empty($nickname))
					{
						$this->goall('微信接口错误',1,0,'/index.php?m=index');
					}
					if($ouser=M("openlogin")->getRow("SELECT *  FROM ".table('openlogin')." WHERE openid='".$data['openid']."' AND xfrom='weixin' "))
					{
						if($ouser['userid']){
							$user=M("user")->selectRow(array(
								"where"=>"userid=".$ouser['userid'],
								"fields"=>"userid,nickname,user_head,password"
							));
							M('login')->set("ssuser",$user);
					 		$authcode=jiami($user['userid']."|".umd5(substr($user['password'],0,12)));
							setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);													
							header("Location: /index.php");
							exit;
						}else{
							$_SESSION['ssopenlogin']=$ouser;
							header("Location: /index.php?m=openlogin&a=bind&xfrom=weixin");
							exit;
						}
						 
						//$this->goall('登陆成功',1,0,'/index.php');
					}else
					{
						//生成账户
						 
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
							"nickname"=>$nickname,					
							"xfrom"=>'weixin',
							"openid"=>$data['openid'],
							"createtime"=>date("Y-m-d H:i:s")		
						);
						if($user_head){
							$data['user_head']=$user_head;
						}
						 
						$this->upload_oss($user_head);
						$data['id']=M("openlogin")->insert($data);
						$_SESSION['ssopenlogin']=$data; 
						header("Location: /index.php?m=openlogin&a=bind&xfrom=weixin");
						exit;
						//$this->goall('注册登陆成功',0,0,'/index.php');
					}
				}
				
			}else{
					exit($c);
			}
		/*}else{
					exit($c);
		}*/
	
	
}

}
?>