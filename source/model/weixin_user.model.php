<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class weixin_userModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="weixin_user";
	}
}

?>