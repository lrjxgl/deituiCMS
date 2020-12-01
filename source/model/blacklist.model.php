<?php
class blacklistModel extends model{
	public $table="blacklist";
	public function __construct(){
		parent::__construct();
	}
	public function check($userid){
		$row=$this->selectRow("userid='".$userid."'");
		if($row){
			C()->goAll("无发帖权限",1);
		}
	}
}
?>