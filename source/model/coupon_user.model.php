<?php
class coupon_userModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="coupon_user";
	}
}

?>