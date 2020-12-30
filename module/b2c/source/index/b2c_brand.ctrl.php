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
			$url="module.php?m=b2c_brand&a=default";
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
		
		public function onList(){
			$where=" status in(0,1,2)";
			$url="module.php?m=b2c_brand&a=default";
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
		
		public function onShow(){
			$brandid=get_post("brandid","i");
			$data=M("mod_b2c_brand")->selectRow(array("where"=>"brandid=".$brandid));
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("b2c_brand/show.html");
		}
		
	}

?>