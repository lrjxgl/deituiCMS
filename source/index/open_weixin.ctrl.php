<?php
class open_weixinControl extends skymvc{
	public $wx;
	public $REDIRECT_URI;
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
		 
		$this->REDIRECT_URI=HTTP_HOST."/index.php?m=open_weixin&a=callback&wid=".$this->wx['id'];
		
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
		echo "hello";
	}
	
public function onGeturl()
{
	$backurl=get('backurl','x');
	 if($backurl==""){
		 $backurl="/";
	 }
	$_SESSION["backurl"]=$backurl; 
	$url=" https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->wx['appid']."&redirect_uri=".urlencode($this->REDIRECT_URI)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
	header("Location: $url");
	exit();
}

public function oncallback()
{
	$backurl=$_SESSION["backurl"];
	 
	if(preg_match("/login/i",$backurl)){
		$backurl="/index.php";
	}
	 
	$c=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->wx['appid']."&secret=".$this->wx['appkey']."&code=".$_GET['code']."&grant_type=authorization_code");
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
			$ouser=M("openlogin")->getRow("SELECT *  FROM ".table('openlogin')." WHERE openid='".$data['openid']."' AND xfrom='weixin' ");
			if($ouser)
			{
				if($ouser['userid']){
					$user=M("user")->selectRow(array(
						"where"=>"userid=".$ouser['userid'],
						"fields"=>"userid,nickname,user_head"
					));
					M('login')->set("ssuser",$user);
					$puser=M("user_password")->selectRow("userid=".$ouser['userid']);
					$auth=M("login")->setCode($puser);
					$authcode=$auth['authcode'];
					setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);													
					header("Location:".$backurl);
					exit;
				}else{
					$_SESSION['ssopenlogin']=$ouser;
					$this->openlogin($ouser);
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
				$ouser=$data;
				$_SESSION['ssopenlogin']=$data;
				$this->openlogin($ouser);
				 
				
				//$this->goall('注册登陆成功',0,0,'/index.php');
			}
		}
		
	}else{
			exit($c);
	}
	
}
public function openlogin($ouser){
	if($this->wx['openlogin']){
		//三方绑定
		header("Location: /index.php?m=openlogin&a=bind&xfrom=weixin");
		exit;
	}else{
		//直接登录
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
		//绑定消息通知
		M("apppush")->insert(array(
			"userid"=>$userid,
			"appname"=>$ouser["xfrom"],
			"openid"=>$ouser["openid"],
			"dateline"=>time(),
		));
		$this->goall('注册登陆成功',0,0,$_SESSION["backurl"]);
	} 
}
	
	
 

}
?>