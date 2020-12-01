<?php
class user_passwordModel extends model{
	public $table="user_password";
	public function __construct(){
		parent::__construct();
	}
	public function get($userid){
		return $this->selectRow("userid=".$userid);
	}
}