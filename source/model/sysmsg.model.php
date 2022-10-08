<?php
class sysmsgModel extends model{
	public $table="sysmsg";
	public function getListByIds($ids,$fields="*"){
		$ids=array_unique($ids);
		if(empty($ids)) return [];
		$res=$this->select(array(
			"where"=>" id in("._implode($ids).") ",
			"fields"=>$fields
		));
		$list=[];
		foreach($res as $rs){
			 
			$list[$rs["id"]]=$rs;
		}
		return $list;
	}
}