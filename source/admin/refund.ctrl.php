<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class refundControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" status in(0,1,2)";
			$url="/admin.php?m=refund&a=default";
			$limit=20;
			$start=get("per_page","i");
			$stime= get("stime",'h');
			if($stime){
				$stime=$stime." 00:00:01";
				$where.=" AND createtime>='{$stime}' ";
			}
			$etime=get('etime','h');
			if($etime){
				$etime=$etime." 00:00:01";
				$where.=" AND createtime<='{$etime}'";
			}
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("refund")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("refund/index.html");
		}
		
		
	}

?>