<?php
class forum_feedsControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$start=get("per_page","i");
		$limit=6;
		$type=get("type","h");
		$order=" id DESC";
		$userid=M("login")->userid;
		$rscount=true;
		$blogids=M("mod_forum_feeds")->selectCols(array(
			"where"=>" userid=".$userid,
			"fields"=>"objectid",
			"order"=>" id DESC",
			"start"=>$start,
			"limit"=>$limit
		),$rscount);
		if(!$blogids){
			$blogids=[0]; 
		} 
		$ops=array(
			"where"=>" status=1 AND  id in("._implode($blogids).") ",
			"order"=>"  id DESC"
		);
		
		$list=MM("forum","forum")->Dselect($ops);
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$per_page=$start+$limit;
		$per_page=$per_page<$rscount?$per_page:0;
		 
		$this->smarty->goAssign(array(
			"list"=>$list,
			"per_page"=>$per_page,		
			"rscount"=>$rscount,
			"pagelist"=>$pagelist,
			 
		));
		$this->smarty->display("forum_feeds/index.html");
	}
	
}