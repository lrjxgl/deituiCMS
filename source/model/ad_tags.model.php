<?php
class ad_tagsModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="ad_tags";
	}
	
	public function tagList($pid=0,$all=1){
		if(!$all){
			$where="     pid=".intval($pid)." ";
		}else{
			$where="  1=1 ";
		}
		$data=$this->select(array("where"=>$where,"order"=>" orderindex asc"));
		if($data){
			foreach($data as $k=>$v){
				$t_c[$v['tag_id']]=$v;
			}
			return $t_c;
		}
	}
}

?>