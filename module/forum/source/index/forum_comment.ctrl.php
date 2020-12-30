<?php 
class forum_commentControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		
	}
	
	public function onMy(){
		
		$this->smarty->display("forum_comment/my.html");
	}
	
}