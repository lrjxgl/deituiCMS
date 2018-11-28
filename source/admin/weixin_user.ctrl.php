<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class weixin_userControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		 
		}
		
		public function onDefault(){
			$where="";
			$url=APPADMIN."?m=weixin_user&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("weixin_user")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("weixin_user/index.html");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("weixin_user")->delete("id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>