<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class forum_groupControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		public function onInit(){
			 
		}
		public function onDefault(){
			$where=" 1 ";
			$url="/admin.php?m=forum_group";
			$limit=24;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" orderindex ASC",
				"where"=>$where
			);
			$rscount=true;
			$data=MM("forum","forum_group")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"per_page"=>$per_page,
				)
			);
			$this->smarty->display("forum_group/index.html");
		}
		
		public function onAdd(){
			$gid=get_post("gid","i");
			if($gid){
				$data=MM("forum","forum_group")->selectRow(array("where"=>"gid={$gid}"));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data,
				 
			));
			$this->smarty->display("forum_group/add.html");
		}
		
		public function onCatlist(){
			$gid=get_post("gid","i");
			$catlist=M("mod_forum_category")->select(array(
				"where"=>" gid=".$gid." AND status=1 "
			));
			$this->goAll("success",0,$catlist);
		}
		
		public function onSave(){
			
			$gid=get_post("gid","i");

			$data=MM("forum","forum_group")->postData();
			if(empty($data['title'])){
				$this->goAll("名称不能为空",1);
			}
			if($gid){
				MM("forum","forum_group")->update($data,"gid='$gid'");
			}else{
				 
				MM("forum","forum_group")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$gid=get_post('gid',"i");
			$row=M("mod_forum_group")->selectRow("gid=".$gid);
			$status=1;
			if($row["status"]==1){
				$status=2;
			}
			M("mod_forum_group")->update(array(
				"status"=>$status
			),"gid=".$gid);
			$this->goAll("success",0,$status);
		}
		
		public function onRecommend(){
			$gid=get_post('gid',"i");
			$row=M("mod_forum_group")->selectRow("gid=".$gid);
			$status=1;
			if($row["isrecommend"]==1){
				$status=0;
			}
			M("mod_forum_group")->update(array(
				"isrecommend"=>$status
			),"gid=".$gid);
			$this->goAll("success",0,$status);
		}
		
		
		public function onDelete(){
			$gid=get_post('gid',"i");
			MM("forum","forum_group")->update(array("status"=>11),"gid=$gid");
			$this->goAll("删除成功");
			 
		}
		
		
	}

?>