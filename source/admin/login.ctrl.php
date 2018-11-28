<?php
class loginControl extends skymvc{
	
	function __construct(){
		parent::__construct();
	}
	
	public function onInit(){
		$data=M("admin")->selectRow();
		if(empty($data)){
			M("admin")->insert(array(
				"username"=>"admin",
				"password"=>umd5("admin1234"),
				"salt"=>"1234"
				 
			));
		}
	}
	
	public function onDefault(){
		$this->smarty->display("login/index.html");
	}
	
	public function onLogin_save(){
		$username=post('username','h');
		$password=post('password','h');
		 
		$data=M("admin")->selectRow(array("where"=>array("username"=>$username)));
		if(umd5($password.$data['salt'])==$data['password']){
			unset($data['password']);
			$_SESSION['ssadmin']=$data;			
			
			$authcode=md5(time());
			cache()->set("adminAuth-".$authcode,$data,3600*24); 
			$this->goall("登录成功",0,$authcode,APPADMIN."?m=iframe");
		}else{
			$this->goall("密码出错",1);
		}
	}
	
	public function onLogout(){
		$_SESSION['ssadmin']="";
		unset($_SESSION['ssadmin']);
		$this->goall("退出成功",0,0,APPADMIN."?m=login");
	}
	
	public function onRefresh(){
		$data=M("admin")->selectRow(array("where"=>array("username"=>$_SESSION['ssadmin']['username'])));
		$_SESSION['ssadmin']=$data;	
	}
}

?>