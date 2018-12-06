<?php
class loveControl extends skymvc
{
	public $userInfo;
	public function __construct(){
		parent::__construct();		
	}
	
	public function onInit(){
		M("login")->checklogin();
		$this->userInfo=M("login")->getUser();
	}
	
	public function onDefault(){
		
	}
	public function onMy(){
		$tablename=get("tablename","h");
		$this->smarty->goAssign(array(
			"tablename"=>$tablename
		));
		$this->smarty->display("love/my.html");
	}
	
	public function onMyList(){
		$tablename=get("tablename",'h');
		if(!in_array($tablename,array("article"))){
			$this->goAll("参数出错",1);
		} 
		$userid=M("login")->userid;
	
		switch($tablename){
			case "article":
				$sql="select a.* 
					from ".table('love')." as f 
					left join ".table('article')." as a  
					on f.objectid=a.id 
					where f.userid=".$userid." AND f.tablename='article' AND a.status=2 
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
		$row=M("love")->selectRow("userid=".$userid." AND objectid=".$objectid." AND tablename='".$tablename."' ");
		$fields=M($tablename)->getFields();
		$idField=$fields[0]['Field'];
		if($row){
			M("love")->delete("id=".$row['id']);
			$action="delete";
			M($tablename)->changenum("love_num",-1,"{$idField}=".$objectid);
		}else{
			M("love")->insert(array(
				"objectid"=>$objectid,
				"userid"=>$userid,
				"tablename"=>$tablename
			));
			$action="add";
			M($tablename)->changenum("love_num",1,"{$idField}=".$objectid);
		}
		$this->goAll("success",0,$action);
	}
	
	 
	
	 
	
	 
	
}
?>