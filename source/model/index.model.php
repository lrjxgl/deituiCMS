<?php
class indexModel extends model
{
	public $base;
	function __construct(&$base)
	{
		parent::__construct($base);
		$this->base=$base;
	}

	function test()
	{
		$arr=array(
		"我是谁",
		"我是一只飞翔的鸟",
		"我盘旋在无际的天边",
		"观赏着美丽的大地"
		);
		return $arr;
	}
	
}

?>