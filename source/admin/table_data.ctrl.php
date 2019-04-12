<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class table_dataControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$tableid=get("tableid","i");
			$table=M("table")->selectRow("tableid=".$tableid);
			$where="status in(0,1,2) AND tableid=".$tableid;
			$url="/admin.php?m=table_data&tableid=".$tableid;
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("table_data")->select($option,$rscount);
			$fields=M("table_fields")->select(array(
				"where"=>" tableid=".$tableid." AND islist=1 ",
				"order"=>" orderindex ASC"
			));
			if($data){
				foreach($data as $k=>$v){
					$fdata=str2arr($v["content"]);
					$v["data"]=$this->parse($fdata,$fields);
					unset($v["content"]);
					$data[$k]=$v;
				}
			}
			 
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
					"fieldtypeList"=>$fieldtypeList,
					"table"=>$table
				)
			);
			$this->smarty->display("table_data/index.html");
		}
		public function onAdd(){
			$tableid=get("tableid","i");
			$table=M("table")->selectRow("tableid=".$tableid);
			$fieldsList=M("table_fields")->select(array(
				"where"=>"tableid=".$tableid
			));
			$id=get("id","i");
			$rs=M("table_data")->selectRow("id=".$id);
			$fdata=str2arr($rs["content"]);
			$fieldsList=$this->parse($fdata,$fieldsList);
			$this->smarty->goAssign(array(
				"table"=>$table,
				 "data"=>$rs,
				"fieldsList"=>$fieldsList
			));
			$this->smarty->display("table_data/add.html");
		}
		
		public function onSave(){
			$tableid=post("tableid","i");
			$id=get_post("id","i");
			$rss=$_POST["tablefield"];
			if(!empty($rss)){
				foreach($rss as $k=>$v){
					$rss[$k]=stripslashes($v);
				}
				$content=arr2str($rss);
			}
			if($id){
				M("table_data")->update(array(
					"tableid"=>$tableid,
					"content"=>$content
				),"id=".$id);
			}else{
				M("table_data")->insert(array(
					"tableid"=>$tableid,
					"content"=>$content
				));
			}
			
			$this->goAll("保存成功");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("table_data")->update(array("status"=>11),"id=$id");
			$this->goall("删除成功",0);
		}
		
		public function parse($data,$rss){
			
			if($rss){
				foreach($rss as $k=>$rs){
					if($rs["fieldtype"]=='img'){
						$rs["value"]=images_site($data[$rs["fieldname"]]);
					}else{
						$rs["value"]=$data[$rs["fieldname"]];
					}
					
					$rss[$k]=$rs;
				}
				return $rss;
			}
		}
	}	
?>		