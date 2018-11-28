<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class weixin_replyControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
	 
		}
		
		public function onDefault(){
			$where=" 1=1 ";
			$url=APPADMIN."?m=weixin_reply&a=default";
			$limit=20;
			$start=get("per_page","i");
			$s_status=get('s_status','i');
			if($s_status){
				$where.=" AND status=".($s_status==1?1:0);
				$url.="&s_status=".$s_status;
			}
			$openid=get('openid','h');
			if($openid){
				$where.=" AND openid='".$openid."'";
				
			}
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("weixin_reply")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("weixin_reply/index.html");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("weixin_reply")->delete("id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>