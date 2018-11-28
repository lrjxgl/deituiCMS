<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class admin_grade_logControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" isdelete=0 ";
			$url=APPADMIN."?m=admin_grade_log&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("grade_log")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("grade_log/index.html");
		}
		
		public function onList(){
			$where="";
			$url=APPADMIN."?m=admin_grade_log&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("grade_log")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("grade_log/index.html");
		}
		
		public function onDelete(){
			$id=get_post("id","i");
			M("grade_log")->update(array("isdelete"=>1),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>