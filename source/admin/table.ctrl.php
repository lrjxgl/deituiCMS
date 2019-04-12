<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class tableControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="status in(0,1,2)";
			$url="/admin.php?m=table&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" tableid DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("table")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("table/index.html");
		}
		
		public function onAdd(){
			$tableid=get_post("tableid","i");
			if($tableid){
				$data=M("table")->selectRow(array("where"=>"tableid=".$tableid));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("table/add.html");
		}
		
		public function onSave(){
			$tableid=get_post("tableid","i");
			$data=M("table")->postData();
			$row=M("table")->selectRow("tablename='".$data["tablename"]."'");
			if($tableid){
				if($row["tableid"]!=$tableid){
					$this->goAll("表{$data['tablename']}已经存在",1);
				}
				M("table")->update($data,"tableid='$tableid'");
			}else{
				if($row){
					$this->goAll("表{$data['tablename']}已经存在",1);
				}
				M("table")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$tableid=get_post('tableid',"i");
			$status=get_post("status","i");
			M("table")->update(array("status"=>$status),"tableid=$tableid");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$tableid=get_post('tableid',"i");
			M("table")->update(array("status"=>11),"tableid=$tableid");
			$this->goall("删除成功",0);
		}
		
		public function onForm(){
			$tableid=get("tableid","i");
			$table=M("table")->selectRow("tableid=".$tableid);
			$fieldsList=M("table_fields")->select(array(
				"where"=>"tableid=".$tableid
			));
			$this->smarty->goAssign(array(
				"table"=>$table,
				"fieldsList"=>$fieldsList
			));
			$this->smarty->display("table/form.html");
		}
		
		public function onFormSave(){
			$tableid=post("tableid","i");
			$rss=$_POST["tablefield"];
			if(!empty($rss)){
				foreach($rss as $k=>$v){
					$rss[$k]=htmlspecialchars($v);
				}
				$content=arr2str($rss);
			}
			M("table_data")->insert(array(
				"tableid"=>$tableid,
				"content"=>$content
			));
			$this->goAll("保存成功");
		}
		
		
	}

?>