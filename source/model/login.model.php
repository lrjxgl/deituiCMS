<?php
class loginModel extends model{
	public $userid;
	 
	function __construct (){
		parent::__construct ();
		 
		$this->table="user";
		$this->userid=$this->getUserId();
	}
	
	public function set($k,$v){
		$_SESSION[$k]=$v;
	}
	
	public function get($k){
		return $_SESSION[$k];
	}
	
	public function getUser($userid=0,$fields="userid,nickname,username,user_head,gender,money,grade,gold"){
		$userid=$userid?$userid:(isset($_SESSION['ssuser']['userid'])?intval($_SESSION['ssuser']['userid']):0);
		if(!$userid) return false;
		$user=parent::selectRow(array("where"=>"userid=$userid","fields"=>$fields));
		$user['user_head']=images_site($user['user_head']);
		unset($user['salt']);
		unset($user['password']);
		return $user;
	}
	
	public function getUserId(){
		return (isset($_SESSION['ssuser']['userid'])?intval($_SESSION['ssuser']['userid']):0);
	}
	
	public function checklogin($setBack=false){
		 
		if(get_post('ajax')){
			if(empty($_SESSION['ssuser']['userid'])){
				if($setBack){
					$this->setBackurl();
				} 
				exit(json_encode(array("error"=>1000,"nologin"=>1,"message"=>"请先登录") ));
				 
			}
		}else{
			if(empty($_SESSION['ssuser']['userid'])){
				$this->setBackurl();
				header("Location: /index.php?m=login");
				exit;
			}
		}
	}
	
	/**
	* array(
	* 	"userid"=>$userid,
	*  "passowrd"=>$password
	* )
	* **/
	public function setCode($user,$el=false){
		$userid=$user["userid"];
		$salt=rand(1000,9999);
		$pwd=substr($user['password'],0,6);
		$p1=substr($userid.umd5($pwd.$salt),0,24);
		$p2=substr($userid.md5($pwd.$salt),0,24);
		$token="u.l.".$p1;
		$token_expire=3600*24*3;
		$refresh_token="u.r.".$p2;
		$refresh_token_expire=3600*24*31;
		cache()->set($token,$userid,$token_expire);
		cache()->set($refresh_token,$userid,$refresh_token_expire);
		$redata=array(
			"token"=>$token,
			"refresh_token"=>$refresh_token
		);
		return $redata;
	}
	public function getCode($code){
		$data=json_decode(jiemi($code),true);
		 
		if(empty($data)){
			return false;
		}
		$agent=substr(md5(substr($_SERVER['HTTP_USER_AGENT'],0,20)),0,4);
		if($agent!=$data['a']){
			//return false;
		}
		//判断是否过期
		/*
		if($data['e']<time()){
			if(isset($data['el'])){
				if($data['el']<time()){
					return false;
				}
			}else{
				return false;
			}
			
		}
		*/
		return $data;
		
	}  
	 
	public function CodeLogin(){
		$token=get_post("loginToken","h");
		if(empty($token)){
			$token=sql($_COOKIE["loginToken"]);
		}
		 
		if($token){
			$userid=cache()->get($token);
			
			if($userid){
				$user=M('user')->selectRow(array(
					"where"=>"userid='".$userid."' ",
					"fields"=>"userid,nickname,telephone,user_head,gold,money"
				));
				if(!empty($user)){
					$this->set("ssuser",$user);
					$this->userid=$user['userid'];
					return true;
				}
			}
		} 
		
	}
	
	public function getAdmin($id=0){
		$id=$id?$id:intval($_SESSION['ssadmin']['id']);
		if(!$id) return false;
		return parent::setTable('admin')->selectRow(array("where"=>"id=$id"));
	}
	
	public function checkAdminLogin($ajax=0){
		 
		C()->goAll("请先登录",1,0,APPADMIN."?m=admin_login");
		 
		 
	}
	public function setBackurl(){
		$_SESSION["backurl"]=HTTP_HOST.$_SERVER["REQUEST_URI"];
	}
	public function getBackurl(){
		if($url=get_post('backurl',"h")){
			return $url;
		}elseif(isset($_SESSION["backurl"])){
			return $_SESSION["backurl"];
		}else{
			return HTTP_HOST;
		}
	} 
	
	 
	
	
}

?>