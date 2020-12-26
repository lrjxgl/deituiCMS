<?php
 
class test_cacheControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		//$_SESSION["hh"]="abc";
		//$_SESSION["a"]="abc";
		echo $_SESSION["hh"];
		/*
		cache()->setType("mysql")->set("ax","axaa");
		 
		echo cache()->setType("mysql")->get("ax");
		*/
	}
	
}