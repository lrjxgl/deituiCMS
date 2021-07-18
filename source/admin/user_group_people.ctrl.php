<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class user_group_peopleControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="status in(0,1,2)";
			$url="/admin.php?m=user_group_people&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("user_group_people")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("user_group_people/index.html");
		}
		public function onSave(){
			$gid=get_post("gid","i");
			$userid=post("userid","i");
			$row=M("user_group_people")->selectRow("gid=".$gid." AND userid=".$userid);
			if($row){
				$this->goAll("error",1);
			}
			$data=M("user_group_people")->postData();
			M("user_group_people")->insert($data);
			$this->goall("保存成功");
		}
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("user_group_people")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$gid=get_post("gid","i");
			$userid=get_post("userid","i");
			M("user_group_people")->delete("gid=".$gid." AND userid=".$userid);
			$this->goall("删除成功",0);
		}
		
		
	}

?>