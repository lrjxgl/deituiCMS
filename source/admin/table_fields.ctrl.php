<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class table_fieldsControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="status in(0,1,2)";
			$url="/admin.php?m=table_fields&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" orderindex ASC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("table_fields")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$fieldtypeList=M("table")->fieldTypeList();
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"fieldtypeList"=>$fieldtypeList
				)
			);
			$this->smarty->display("table_fields/index.html");
		}
		public function onTable(){
			$tableid=get("tableid","i");
			$table=M("table")->selectRow("tableid=".$tableid);
			$this->smarty->goAssign(array(
				"table"=>$table
			));
			$this->smarty->display("table_fields/table.html");
		}
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("table_fields")->selectRow(array("where"=>"id=".$id));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("table_fields/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$data=M("table_fields")->postData();
			if($id){
				M("table_fields")->update($data,"id='$id'");
			}else{
				M("table_fields")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("table_fields")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("table_fields")->update(array("status"=>11),"id=$id");
			$this->goall("删除成功",0);
		}
		
		
	}

?>