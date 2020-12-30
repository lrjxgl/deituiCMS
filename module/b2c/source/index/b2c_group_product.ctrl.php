<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class b2c_group_productControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$gid=get("gid","i");
			$gkey=get("gkey","h");
			if($gkey){
				$group=M("mod_b2c_group")->selectRow("gkey='".$gkey."'");
				$gid=$group["gid"];
			}else{
				$group=M("mod_b2c_group")->selectRow("gid=".$gid);
			}
			if(!$gid){
				$this->goAll("参数出错了");
			}
			$where=" gid=".$gid;
			$url="/module.php?m=b2c_group_product&gid=".$gid;
			$limit=24;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" orderindex ASC,gpid DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_b2c_group_product")->select($option,$rscount);
			if($data){
				foreach($data as $v){
					$proids[]=$v["productid"];
				}
				$pros=MM("b2c","b2c_product")->getListByIds($proids);
				foreach($data as $k=>$v){
					$v=$pros[$v["productid"]];
					
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
					"group"=>$group,
					"url"=>$url
				)
			);
			$this->smarty->display("b2c_group_product/index.html");
		}
		
		 
		
		
	}

?>