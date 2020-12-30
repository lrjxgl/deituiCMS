<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class forum_tags_indexControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$tagid=get("tagid","i");
			$group=M("mod_forum_tags")->selectRow("tagid=".$tagid);
			$where=" tagid=".$tagid;
			$url="/moduleadmin.php?m=forum_tags_index&tagid=".$tagid;
			$limit=24;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" orderindex ASC,id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_forum_tags_index")->select($option,$rscount);
			if($data){
				foreach($data as $v){
					$proids[]=$v["objectid"];
				}
				$pros=MM("forum","forum")->getListByIds($proids);
				foreach($data as $k=>$v){
					$p=$pros[$v["objectid"]];
					$p["id"]=$v["id"];
					$p["orderindex"]=$v["orderindex"];
					$p["objectid"]=$v["objectid"];
					$data[$k]=$p;
				}
			}
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"group"=>$group,
					"url"=>$url
				)
			);
			$this->smarty->display("forum_tags_index/index.html");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("mod_forum_tags_index")->delete("id=$id");
			$this->goAll("删除成功");
			 
		}
		public function onOrderIndex(){
			$id=get_post('id',"i");
			$orderindex=get_post("orderindex","i");
			M("mod_forum_tags_index")->update(array(
				"orderindex"=>$orderindex
			),"id=$id");
			$this->goAll("排序成功");
		}
		
		
	}

?>