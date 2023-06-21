<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class vipControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" status in(0,1,2)";
			$url="/admin.php?m=vip&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" orderindex ASC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("vip")->select($option,$rscount);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("vip/index.html");
		}
		
		public function onAdd(){
			$vipid=get_post("vipid","i");
			if($vipid){
				$data=M("vip")->selectRow(array("where"=>"vipid=".$vipid));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("vip/add.html");
		}
		
		public function onSave(){
			$vipid=get_post("vipid","i");
			$data=M("vip")->postData();
			if($vipid){
				M("vip")->update($data,"vipid=".$vipid);
			}else{
				M("vip")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$vipid=get_post('vipid',"i");
			$row=M("vip")->selectRow("vipid=".$vipid);
			if($row["status"]==1){
				$status=2;
			}else{
				$status=1;
			}
			 
			M("vip")->update(array("status"=>$status),"vipid=".$vipid);
			$this->goall("状态修改成功",0,$status);
		}
		
		public function onDelete(){
			$vipid=get_post('vipid',"i");
			M("vip")->update(array("status"=>11),"vipid=".$vipid);
			$this->goAll("删除成功");
			 
		}
		
		
	}

?>