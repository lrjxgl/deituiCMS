<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class forum_categoryControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		public function onInit(){
			 
		}
		public function onDefault(){
			$gid=get('gid','i');
			$group=MM("forum","forum_group")->selectRow("  gid=".$gid);
			if(empty($group)){
				$this->goAll("请选择板块",1);
			}
			$where="   status in(0,1,2) AND gid=".$gid;
			$url="/admin.php?m=forum_category&gid=".$gid;
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" catid DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_forum_category")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"group"=>$group,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"per_page"=>$per_page,
				)
			);
			$this->smarty->display("forum_category/index.html");
		}
		
		public function onSave(){
			$catid=get_post('catid','i');
			$data=M("mod_forum_category")->postData();
			$data['status']=1;
			if($catid){
				$row=M("mod_forum_category")->selectRow("catid=".$catid);
				 
				M("mod_forum_category")->update($data,"catid=".$catid);
			}else{
				 
				M("mod_forum_category")->insert($data);
			}
			$this->goAll("保存成功");
		}
		
		public function onStatus(){
			$catid=get_post('catid',"i");
			$status=get_post("status","i");
			 
			M("mod_forum_category")->update(array("status"=>$status),"catid=$catid");
			$this->goall("状态修改成功");
		}
		
		public function onDelete(){
			$catid=get_post('catid',"i");
			 
			M("mod_forum_category")->update(array("status"=>11),"catid=$catid");
			$this->goAll("删除成功");
			 
		}
		
		
	}

?>