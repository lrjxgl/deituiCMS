<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class pay_logControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
 
		}
		
		public function onDefault(){
			$where=" isdelete=0 ";
			$url=APPADMIN."?m=pay_log&a=default";
			$limit=20;
			$start=get("per_page","i");
			$userid=get('userid','i');
			if($userid){
				$where.=" AND userid=".$userid;
			}
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("pay_log")->select($option,$rscount);
			if($data){
				foreach($data as $v){
					$uids[]=$v['userid'];
				}
				$us=M("user")->getUserByids($uids);
				foreach($data as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("pay_log/index.html");
		}
		
 
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("pay_log")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("pay_log/show.html");
		}
		
		public function onDelete(){
			$id=get_post("id","i");
			M("pay_log")->update(array("isdelete"=>1),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
	}

?>