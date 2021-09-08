<?php
class commentControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$tablename=get_post("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		} 
		$tableComment=$tablename."_comment";
		 
		$start=get("per_page","i");
		$limit=24;
		$url="/admin.php?m=comment";
		$where=" status in(0,1,2) ";
		$option=array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>"id ASC"
		);
		$rscount=true;
		$data=M($tableComment)->select($option,$rscount);
		if($data){
			foreach($data as $v){
				$uids[]=$v['userid'];
			}
			$us=M("user")->getUserByIds($uids);
			foreach($data as $k=>$v){
				$v['nickname']=$us[$v['userid']]['nickname'];
				$v['user_head']=images_site($us[$v['userid']]['user_head']);
				$v['timeago']=timeago(strtotime($v['createtime']));
				$data[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"data"=>$data
		));
		
		$this->smarty->display("comment/index.html");
	}
	
	public function onDelete(){
		$id=get("id","i");
		$tablename=get_post("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		} 
		$tableComment=$tablename."_comment";
		$row=M($tableComment)->selectRow("id=".$id);
		M($tableComment)->update(array("status"=>11),"id=".$id);
		M($tablename)->changenum("comment_num",-1,"id=".$row["objectid"]);
		$this->goAll("delete success",0,);
		
	}
}
