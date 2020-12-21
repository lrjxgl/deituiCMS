<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class invite_account_logControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$userid=M("login")->userid;
			$where="userid=".$userid;
			$url="/index.php?m=invite_account_log&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$list=M("invite_account_log")->select($option,$rscount);
			if($list){
				foreach($list as $k=>$v){
					$v["timeago"]=timeago($v["dateline"]);
					$list[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"list"=>$list,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("invite_account_log/index.html");
		}
		
		
	}

?>