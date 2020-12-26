<?php
class task{
	public function __construct(){
		parent::__construct();
	}
	public function go(){
		$que=new queue("file");
		$res=$que->rpop();
		$do=1;
		 
	}
}