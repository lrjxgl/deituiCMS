<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class sms_logControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="status in(0,1,2)";
			$type=get("type","i");
			if($type==1){
				$where=" status=1 ";
			}elseif($type==2){
				$where=" status=0 ";
			}
			$url="/admin.php?m=sms_log&type=".$type;
			$telephone=get("telephone","h");
			if($telephone){
				$where.=" AND telephone='".$telephone."' ";
				$url.="&telephone=".$telephone;
			}
			
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("sms_log")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"type"=>$type,
					"telephone"=>$telephone
				)
			);
			$this->smarty->display("sms_log/index.html");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("sms_log")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("sms_log")->update(array("status"=>11),"id=$id");
			$this->goall("删除成功",0);
		}
		
		
	}

?>