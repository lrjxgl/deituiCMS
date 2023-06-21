<?php
class favControl extends skymvc
{
	public $userInfo;
	public function __construct(){
		parent::__construct();	
	}
	public function onInit(){
		//检验table是否合法
		$tablename=get_post("tablename","h");
		if(!empty($tablename)){
			if(preg_match("/[^\w]+/",$tablename)){
				exit("出错了");
			}
		}
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
		$start=get_post('per_page','i');
		$limit=24;
		switch($tablename){
			case "article":
				$sql="select a.* 
					from ".table('fav')." as f 
					left join ".table('article')." as a  
					on f.objectid=a.id 
					where f.userid=".$userid." AND f.tablename='article'  
				";
				break;
			default:
				$sql="select a.* 
					from ".table('fav')." as f 
					left join ".table($tablename)." as a  
					on f.objectid=a.{$idField} 
					where f.userid=".$userid." AND f.tablename='{$tablename}'  
				";
				break;
			 
				
		}
		$sql.=" order by f.id DESC limit $start,$limit ";
		$rscount=M("fav")->selectOne(array(
			"where"=>" userid=".$userid." AND tablename='{$tablename}'",
			"fields"=>" count(*) "
		)); 
		$list=M($tablename)->getAll($sql);
		if($list){
			foreach($list as $k=>$v){
				$v['imgurl']=images_site($v['imgurl']);
				
				$list[$k]=$v;
			}
		}
		$per_page=$start+$limit;
		$per_page=$per_page<$rscount?$per_page:0;
		$this->smarty->goAssign(array(
			"list"=>$list,
			"per_page"=>$per_page
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
			$this->goAll("取消收藏成功",0,$action);
		}else{
			M("fav")->insert(array(
				"objectid"=>$objectid,
				"userid"=>$userid,
				"tablename"=>$tablename
			));
			$action="add";
			M($tablename)->changenum("fav_num",1,$idField."=".$objectid);
			$this->goAll("收藏成功",0,$action);
		}
		
	}
	
	public function onisFav(){
		$userid=M("login")->userid;
		$isfav=0;
		if($userid){
			$objectid=get_post("objectid","i");
			$tablename=get_post("tablename","h");
			$row=M("fav")->selectRow("userid=".$userid." AND objectid=".$objectid." AND tablename='".$tablename."' ");
			
			if($row){
				$isfav=1;
			}
		}
		
		$this->goAll("success",0,$isfav);
	} 
	
	 
	
}
?>