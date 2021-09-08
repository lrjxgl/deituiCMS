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
		$key="logadmin".md5($username);
		$num=cache()->get($key);
		if($num>=5){
			$this->goall("密码输错5次，请10分钟后再来",1);
		} 
		$data=M("admin")->selectRow(array("where"=>array("username"=>$username)));
		if(umd5($password.$data['salt'])==$data['password']){
			unset($data['password']);
			$_SESSION['ssadmin']=$data;			
			cache()->del($key);
			$authcode=md5(time());
			cache()->set("adminAuth-".$authcode,$data,3600*24); 
			$this->goall("登录成功",0,$authcode,APPADMIN."?m=iframe");
		}else{
			$num=intval($num)+1;
			cache()->set($key,$num,600);
			$this->goall("密码出错,还能再输".(5-$num)."次",1);
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