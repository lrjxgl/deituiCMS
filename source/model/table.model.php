<?php
class tableModel extends model{
	
	public $table="table";
	function __construct(){
		parent::__construct();
	}
	public function fieldtypeList(){
		return array(
			"text"=>"文本",
			"textarea"=>"多行文本",
			"select"=>"列表",
			"img"=>"图片",
			"html"=>"富文本"	,
			"radio"=>"单选框",
			"map"=>"地图"
		);
	}
	
	 
	
}
