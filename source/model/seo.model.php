<?php
class seoModel extends model{
	public $base;
	function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="seo";	
	}
	
	public function get($m,$a="default",$object_id=0){
		$m=$m?$m:"index";
		$where['m']=$m;
		$a=$a?$a:"default";
		$where['a']=$a;
		$where['object_id']=$object_id;
		$option=array(
			"where"=>$where,
			"start"=>0,
			"limit"=>1,
			"fileds"=>"title,keywords,description",
		);
		
		return $seo=$this->selectRow($option);
		 
	}
}
?>