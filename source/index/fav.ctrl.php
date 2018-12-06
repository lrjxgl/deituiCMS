<?php
class favControl extends skymvc
{
	public $userInfo;
	public function __construct(){
		parent::__construct();
		 
		
	}
	
	public function onInit(){
		M("login")->checklogin();
	}
	
	public function onDefault(){
		$this->smarty->display("fav/index.html");
	}
	public function onMy(){
		$tablename=get("tablename","h");
		$this->smarty->goAssign(array(
			"tablename"=>$tablename
		));
		$this->smarty->display("fav/my.html");
	}
	
	public function onMyList(){
		$tablename=get("tablename",'h');
		 
		$userid=M("login")->userid;
		$fields=M($tablename)->getFields();
		$idField=$fields[0]['Field'];
		switch($tablename){
			case "article":
				$sql="select a.* 
					from ".table('fav')." as f 
					left join ".table('article')." as a  
					on f.objectid=a.id 
					where f.userid=".$userid." AND f.tablename='article' AND a.status=2 
				";
				break;
			default:
				$sql="select a.* 
					from ".table('fav')." as f 
					left join ".table($tablename)." as a  
					on f.objectid=a.{$idField} 
					where f.userid=".$userid." AND f.tablename='{$tablename}' AND a.status=2 
				";
				break;
			 
				
		}
		$list=M($tablename)->getAll($sql);
		if($list){
			foreach($list as $k=>$v){
				$v['imgurl']=images_site($v['imgurl']);
				
				$list[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list
		));
	}
	
	public function onToggle(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		$objectid=get_post("objectid","i");
		$tablename=get_post("tablename","h");
		$row=M("fav")->selectRow("userid=".$userid." AND objectid=".$objectid." AND tablename='".$tablename."' ");
		//获取表结构
		$fields=M($tablename)->getFields();
		$idField=$fields[0]['Field'];
		if($row){
			M("fav")->delete("id=".$row['id']);
			$action="delete";
			M($tablename)->changenum("fav_num",-1,$idField."=".$objectid);
		}else{
			M("fav")->insert(array(
				"objectid"=>$objectid,
				"userid"=>$userid,
				"tablename"=>$tablename
			));
			$action="add";
			M($tablename)->changenum("fav_num",1,$idField."=".$objectid);
		}
		$this->goAll("success",0,$action);
	}
	
	 
	
	 
	
}
?>