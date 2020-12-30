<?php
class b2c_flashControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$type=get("type","h");
		$where=" status=1 AND otype='isflash' ";
		$url="/module.php?m=b2c_flash";
		$limit=20;
		$start=get("per_page","i");
		 
		switch($type){
			case "finish":
				$where.=" AND etime<".time();				
				break;
			case "unbegin":
				$where.=" AND stime>".time();
				break;
				
			case "doing":
				$where.=" AND stime<".time()." AND etime>".time();
				break;
		}
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$rscount=true;
		$data=M("mod_b2c_product")->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$v["imgurl"]=images_site($v["imgurl"]);
				$data[$k]=$v;
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
				"url"=>$url
			)
		);
		$this->smarty->display("b2c_flash/index.html");
	}
	
	
}