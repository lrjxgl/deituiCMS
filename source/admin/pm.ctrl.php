<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class pmControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		 
		}
		
		public function onDefault(){
			$where="";
			$url=APPADMIN."?m=pm&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("pm")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			if($data){
				foreach($data as $k=>$v){
					$uids[]=$v['userid'];
					$uids[]=$v['t_userid'];
				}
				$user=M("user")->getUserByIds($uids);
  
				foreach($data as $k=>$v){
					$v['nickname']=$user[$v['userid']]['nickname'];
					$v['t_nickname']=$user[$v['t_userid']]['nickname'];
					$data[$k]=$v;
				}
			}
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("pm/index.html");
		}
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("pm")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("pm/show.html");
		}
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("pm")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("pm/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$data["userid"]=post("userid","i");
			$data["type_id"]=post("type_id","i");
			$data["t_userid"]=post("t_userid","i");
			$data["dateline"]=post("dateline","i");
			$data["status"]=post("status","i");
			$data["content"]=post("content","h");
			

			if($id){
				M("pm")->update($data,"id='$id'");
			}else{
				M("pm")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("pm")->update(array("status"=>$status),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"状态修改成功")));
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("pm")->delete("id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>