<?php
class forum_groupControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$data=MM("forum","forum_group")->Dselect(array(
			"where"=>" status=1 ",
			"fields"=>"gid,title,imgurl,view_num,topic_num,comment_num,description"
		));
		$this->smarty->goAssign(array(
			"list"=>$data
		));
		$this->smarty->display("forum_group/index.html");
	}
	
	public function onCatlist(){
		$gid=get_post("gid","i");
		$catlist=M("mod_forum_category")->select(array(
			"where"=>" gid=".$gid." AND status=1 "
		));
		$this->goAll("success",0,$catlist);
	}
	
}