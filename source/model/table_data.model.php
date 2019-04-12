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
			"where"=>" tableid=".$tableid." AND islist=1 ",
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
			foreach($fields as $k=>$rs){
				if($rs["fieldtype"]=='img'){
					$rs["value"]=images_site($data[$rs["fieldname"]]);
				}else{
					$rs["value"]=$data[$rs["fieldname"]];
				}
				
				$fields[$k]=$rs;
			}
			return $fields;
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
	
}