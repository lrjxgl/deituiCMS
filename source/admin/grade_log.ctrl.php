<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class grade_logControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" isdelete=0 ";
			$url=APPADMIN."?m=grade_log&a=default";
			$limit=20;
			$start=get("per_page","i");
			$userid=get('userid','i');
			if($userid){
				$where.=" AND userid=".$userid;
			}
			$stime= get("stime",'h');
			if($stime){
				$stime=strtotime($stime." 00:00:01");
				$where.=" AND dateline>='{$stime}' ";
			}
			$etime=get('etime','h');
			if($etime){
				$etime=strtotime($etime." 00:00:01");
				$where.=" AND dateline<='{$etime}'";
			}
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("grade_log")->select($option,$rscount);
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
			$this->smarty->display("grade_log/index.html");
		}
		
 
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("grade_log")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("grade_log/show.html");
		}
		
		public function onDelete(){
			$id=get_post("id","i");
			M("grade_log")->update(array("isdelete"=>1),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	public function onMan(){
		
		$this->smarty->display("grade_log/man.html");
	}
	
	public function onsaveman(){
		$userid=post('userid','h');
		$user=M("user")->selectRow("userid='".$userid."' ");
		$money=post('money','r');
		if(empty($user)){
			$this->goall("用户不存在",1);
		}
		 
		M("user")->addMoney(array(
			"grade"=>$money,
			"content"=>"网站给你人工充值了".$money."个金币,",
			"type_id"=>3,
			"ispay"=>2,
			"userid"=>$user['userid']
		));

		$this->goall("金币充值成功");
	}
	}

?>