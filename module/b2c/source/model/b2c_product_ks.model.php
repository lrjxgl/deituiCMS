<?php
class b2c_product_ksModel extends model{
	
	public $table="mod_b2c_product_ks";
	public function __construct(){
		parent::__construct();
	}
	public function getListByIds($ids,$fields="*"){
		$ids=array_unique($ids);
		$rss=$this->select(array(
			"where"=>" id in("._implode($ids).") "
		));
		if($rss){
			$data=array();
			foreach($rss as $rs){
				$data[$rs["id"]]=$rs;
			}
			return $data;
		}
	}
	
	public function getListByTitle($productid){
		$kslist=$this->select(array(
			"where"=>" productid=".$productid
		));
		if($kslist){
			$tits[]="";
			foreach($kslist as $k=>$v){
				if(in_array($v['title'],$tits)){
					unset($kslist[$k]);
				}else{
				 	$tits[]=$v['title'];
				}
			}
		}
		 
		return $kslist;
	}
	
}