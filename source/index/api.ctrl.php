<?php
class apiControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$tpl=get("tpl",'h');
		$this->smarty->display("api/".$tpl.".html");
	}
	
}
?>