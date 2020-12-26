<?php
class modelModel extends model{
	 
	public function __construct (){ 
		parent::__construct (); 
		$this->table="model"; 
	}
	
	
	public function getlist($option=array()){
		$data=$this->select($option);
		foreach($data as $v){
			$arr[$v['id']]=$v['title'];	
		}
		return $arr;
	}
	
	
	/*模型对应的表*/
	public function model_table($model_id=0){	
		$arr=$this->select();
		foreach($arr as $v){
			$data[$v['id']]=$v['tablename'];	
		}
		if($model_id){
			return $data[$model_id];
		}else{
			return $data;
		}
	}
	
}
?>