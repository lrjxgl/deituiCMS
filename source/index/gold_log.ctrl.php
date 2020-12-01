<?php
class gold_logControl extends skymvc{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		M("login")->checkLogin();
	}
	
	public function onDefault(){
		$where=" isdelete=0 AND userid=".M("login")->userid;
		$start=get('per_page','i');
		$limit=20;
		$url="/index.php?m=gold_log";
		$option=array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
		);
		$rscount=true;
		$data=M("gold_log")->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$v['timeago']=timeago($v['dateline']);
				
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$per_page=$start+$limit;
		$per_page=$rscount>$per_page?$per_page:0;
		$this->smarty->goassign(array(
			"list"=>$data,
			"per_page"=>$per_page,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist
			
		));
		
		$this->smarty->display("gold_log/index.html");
	}
	
}
?>