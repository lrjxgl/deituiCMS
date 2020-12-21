<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class guestControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
 
		}
		
		public function onDefault(){
			$where="   status in(0,1,2)  ";
			$url=APPADMIN."?m=guest&a=default";
			$limit=20;
			$start=get("per_page","i");
			$type_id=get('type_id','i');
			if($type_id){
				$where.=" AND type_id=".$type_id;
			}
			$type=get("type","h");
			$url.="&type=".$type;
			switch($type){
				case "new":
					$where="status=0";
					break;
				case "pass":
					$where="status=1";
					break;
				case "forbid":
					$where="status=2";
					break;
				default:
					$_GET["type"]="all";  
					break;
			}
			
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("guest")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"type_list"=>M("guest")->type_list(),
				)
			);
			$this->smarty->display("guest/index.html");
		}
		
 
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("guest")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("guest/show.html");
		}
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("guest")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("guest/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$data=M("guest")->postData();
			$data["isreply"]=1;
			M("guest")->update($data,"id='$id'");
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$row=M("guest")->selectRow("id=".$id);
			if($row["status"]==1){
				$status=0;
			}else{
				$status=1;
			}
			
			M("guest")->update(array("status"=>$status),"id=$id");
			$this->goAll("状态修改成功",0,$status);
			 
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("guest")->update(array("status"=>8),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>