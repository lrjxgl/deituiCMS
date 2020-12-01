<?php
class blacklist_postModel extends model{
	public $table="blacklist_post";
	public function __construct(){
		parent::__construct();
	}
	public function check($userid){
		$row=$this->selectRow("userid='".$userid."' AND etime>".time()." ");
		if($row){
			C()->goAll("无发布权限",1);
		}
	}
}
?>