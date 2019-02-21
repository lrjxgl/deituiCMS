<?php
class loginModel extends model{
	public $userid;
	public $base;
	function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
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
	
	public function checklogin($ajax=0){
		if(get_post('ajax')) $ajax=1;
		if($ajax){
			if(empty($_SESSION['ssuser']['userid'])){
				closeDb();
				exit(json_encode(array("error"=>1000,"nologin"=>1,"message"=>"请先登录") ));
				 
			}
		}else{
			if(empty($_SESSION['ssuser']['userid'])){
				closeDb();
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
		$pwd=substr($user['password'],0,6);
		$agent=substr(md5(substr($_SERVER['HTTP_USER_AGENT'],0,20)),0,4);
		$data=array(
			"u"=>$user['userid'],
			"p"=>$pwd,
			"a"=>$agent,
			"e"=>time()+3600*24*2,
		);
		
		$authcode=jiami(json_encode($data));
		$data['el']=time()+3600*24*300;
		$authCodeLong=jiami(json_encode($data));
		$redata=array(
			"authcode"=>$authcode,
			"authcodeLong"=>$authCodeLong
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
		 
		if(get_post('authcode')){
			$authcode=get_post('authcode');			
		}else{
			$authcode=$_COOKIE['authcode'];
		}	 
		if($authcode=='' or !$authcode) return false;
		$arr=$this->getCode($authcode); 
		
		$userid=intval($arr['u']);
		$key="login_codelogin_".$userid;
		$islogin=false;
		 
		if($c=cache()->get($key)){
			if($authcode==$c['authcode']){
				$this->userid=$c['user']['userid'];
				$this->set("ssuser",$c['user']);
				$islogin=true;
			}else{
				cache()->set($key,"");
			}
		}
		if(!$islogin){
			$user=M('user')->selectRow(array(
				"where"=>"userid='".$userid."' ",
				"fields"=>"userid,nickname,telephone,user_head,gold,money"
			));
			if(empty($user)){
				return false;
			}
			$puser=M("user_password")->selectRow("userid=".$userid);
			if( $arr['p']!=substr($puser['password'],0,6)){			
				setcookie("authcode","",time()-3999,"/",DOMAIN);		
			}else{
				if(isset($arr['el'])){
					$auth=$this->setCode($puser,true);
					setcookie("authcode",$auth['authcode'],time()+3600000,"/",DOMAIN);
				}				
				$this->userid=$user['userid']; 
				$this->set("ssuser",$user);
				$cacheData=array(
					"authcode"=>$authcode,
					"user"=>$user
				);
				cache()->set($key,$cacheData,3600);		
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
	
}
?>