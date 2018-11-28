<?php
class user_groupControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
		$this->smarty->display("admin/usergroup/index.html");
	}
	
	public function onAdd(){
		$this->smarty->display("admin/usergroup/add.html");
	}
	
	public function onSave(){
		
	}
	
	 
	
}

?>