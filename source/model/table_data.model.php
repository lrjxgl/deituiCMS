<?php
class table_dataModel extends model{
	public $table="table_data";
	public function __construct(){
		parent::__construct();
	}
	 
	public function Dselect($tableid,$option=array(),&$rscount=false){
		$tableid=intval($tableid);
		$data=$this->select($option,$rscount);
		$fields=M("table_fields")->select(array(
			"where"=>" tableid=".$tableid." AND islist=1 AND status=0 ",
			"order"=>" orderindex ASC"
		));
		if(empty($fields)){
			return false;
		}
		if($data){
			foreach($data as $k=>$v){
				$fdata=str2arr($v["content"]);
				$v["data"]=$this->parse($fdata,$fields);
				unset($v["content"]);
				$data[$k]=$v;
			}
		}
		return $data;
	}
	public function parse($data,$fields){
		
		if($fields){
			$newfields=array();
			foreach($fields as $k=>$rs){
				if($rs["fieldtype"]=='img'){
					$rs["value"]=images_site($data[$rs["fieldname"]]);
				}elseif($rs["fieldtype"]=="select"){
						 
						if(!empty($rs["optionlist"])){
							$rs["opsList"]=explode("\r\n",$rs["optionlist"]);
						}else{
							$rs["opsList"]=array();
						}
						$rs["value"]=$data[$rs["fieldname"]];
				}else{
					$rs["value"]=$data[$rs["fieldname"]];
				}
				
				$newfields[$rs["fieldname"]]=$rs;
			}
			return $newfields;
		}
	}
	
	public function save($objectid=0){
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
	}
	public function getListByTable($tablename,$limit=1){
		 
		 $tableid=M("table")->selectOne(array(
			"where"=>" tablename='".sql($tablename)."' ",
			"fields"=>"tableid"
		));
		if($tableid){
			return $this->getList($tableid,$limit);
		}
	}
	public function getList($tableid,$limit=1){
		$tableid=intval($tableid);
		$limit=intval($limit);
		$where="status in(0,1,2)  AND tableid=".$tableid;
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$res=$this->Dselect($tableid,$option);
		 
		return $res;
	}
	public function get($tableid,$id=0){
		if($tableid>0){
			$tableid=intval($tableid);
		}else{
			$table=M("table")->selectRow("tablename='".$tableid."' ");
			if(!$table) return false;
			$tableid=$table["tableid"];
		}
		
		$id=intval($id);
		
		if(!$id){
			$where="status in(0,1,2)  AND tableid=".$tableid;
			$row=$this->selectRow($where);
			
			if($row){
				$id=$row["id"];
			}else{
				return false;
			}
			
		}
	 
		$rs=M("table_data")->selectRow("id=".$id);
	 
		$fieldsList=M("table_fields")->select(array(
			"where"=>" status=0 AND tableid=".$tableid,
			"order"=>"orderindex asc"
		));
		$fdata=str2arr($rs["content"]);
		 
		$fieldsList=$this->parse($fdata,$fieldsList);
	 
		return $fieldsList;
	}
	
	public function getData($tableid,$id=0){
		$rs=$this->get($tableid,$id);
		$data=[];
		if(!empty($rs)){
			foreach($rs as $k=>$v){
				$data[$k]=$v["value"];
			}
		}
		
		return $data;
		/*
		if($tableid>0){
			$tableid=intval($tableid);
		}else{
			$table=M("table")->selectRow("tablename='".$tableid."' ");
			if(!$table) return false;
			$tableid=$table["tableid"];
		}
		$id=intval($id);
		
		if(!$id){
			$where="status in(0,1,2)  AND tableid=".$tableid;
			$row=$this->selectRow($where);
			
			if($row){
				$id=$row["id"];
			}else{
				return false;
			}
			
		}
	 
		$rs=M("table_data")->selectRow("id=".$id);
		return $fdata=str2arr($rs["content"]);
		*/
	}
	
	public function saveTable($tableid,$id=0){
		 
		if(!$tableid) return 0;
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
			$id=M("table_data")->insert(array(
				"tableid"=>$tableid,
				"content"=>$content
			));
		}
		return $id;
	}
}