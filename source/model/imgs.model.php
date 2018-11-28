<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class imgsModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="imgs";
	}
	
	public function get($tablename,$object_id=0,$fields="*"){
		return $this->select(array("where"=>" tablename='".sql($tablename)."' AND object_id=".intval($object_id)." ","order"=>"orderindex asc","fields"=>$fields));
	}
}

?>