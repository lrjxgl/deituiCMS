<?php
class navbarModel extends model{
	public $base=NULL;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="navbar";	
	}
	public function navlist($gid,$pid=0){
		return $this->select(array("where"=>array("group_id"=>$gid,"pid"=>$pid,"status"=>1),"order"=>"orderindex asc"));
	}
	
	public function getTarget(){
		return array(
			"_blank"=>"新窗口",
			"main-frame"=>"右窗口",
			"menu-frame"=>"做窗口",
			"_self"=>"当前窗口",
		);
		
	}
	
	/*导航条分组*/
	public function getGroup(){
		return array(
			1=>"后台顶部", 
			2=>"后台左边", 
			3=>"pc头部", 
			4=>"uniApp", 
			5=>"pc底部", 
	 
			7=>"用户中心",
			8=>"wap导航",
			9=>"app主导航",
			11=>"微信小程序",
		);
	}
}
?>