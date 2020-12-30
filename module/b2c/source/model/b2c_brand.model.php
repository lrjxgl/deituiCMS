<?php
class b2c_brandModel extends model{
	public $table="mod_b2c_brand";
	public function __construct(){
		parent::__construct();
	}
	
	public function Dselect($option=array(),&$rscount=false){
		$res=$this->select($option,$rscount);
		if($res){
			foreach($res as $k=>$v){
				$v["imgurl"]=images_site($v["imgurl"]);
				$res[$k]=$v;
			}
			return $res;
		}
	}
	
	public function getListByIds($ids,$fields="id,title,,description,imgurl"){
		$ids=array_unique($ids);
		$rss=$this->select(array(
			"where"=>" brandid in("._implode($ids).") ",
			"fields"=>$fields
		));
		if($rss){
			$data=array();
			foreach($rss as $rs){
				$rs["imgurl"]=images_site($rs["imgurl"]);
				$data[$rs["id"]]=$rs;
				 
			}
			return $data;
		}
	}
}

?>