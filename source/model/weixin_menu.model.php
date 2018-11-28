<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class weixin_menuModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="weixin_menu";
	}
	
	public function w_type_list(){
		return array(
			"click"=>"点击",
			"view"=>"网址",
		);
	}
	
	public function id_title($op){
		$d=$this->select($op);
		if($d){
			foreach($d as $v){
				$data[$v['id']]=$v['title'];
			}
			return $data;
		}
		return false;
	}
	
}

?>