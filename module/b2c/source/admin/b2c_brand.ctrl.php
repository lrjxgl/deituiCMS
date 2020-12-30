<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class b2c_brandControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" status in(0,1,2)";
			$url="moduleadmin.php?m=b2c_brand&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" brandid DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_b2c_brand")->select($option,$rscount);
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
			$this->smarty->display("b2c_brand/index.html");
		}
		
		public function onAdd(){
			$brandid=get_post("brandid","i");
			if($brandid){
				$data=M("mod_b2c_brand")->selectRow(array("where"=>"brandid=".$brandid));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("b2c_brand/add.html");
		}
		
		public function onSave(){
			$brandid=get_post("brandid","i");
			$data=M("mod_b2c_brand")->postData();
			if($brandid){
				M("mod_b2c_brand")->update($data,"brandid='$brandid'");
			}else{
				M("mod_b2c_brand")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$brandid=get_post('brandid',"i");
			$status=get_post("status","i");
			M("mod_b2c_brand")->update(array("status"=>$status),"brandid=$brandid");
			$this->goall("状态修改成功");
		}
		
		public function onDelete(){
			$brandid=get_post('brandid',"i");
			M("mod_b2c_brand")->update(array("status"=>11),"brandid=$brandid");
			$this->goAll("删除成功");
			 
		}
		
		
	}

?>