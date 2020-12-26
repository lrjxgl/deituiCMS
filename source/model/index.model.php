<?php
class indexModel extends model
{
	 
	function __construct ()
	{
		parent::__construct ();
		 
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