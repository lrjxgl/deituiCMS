<?php
class cityModel extends model{
	public $table="city";
	public function getCityid(){
		if(!empty(get_post("cityid"))){
			return get_post("cityid","i");
		}elseif(isset($_SESSION["ss_cityid"])){
			return $_SESSION["ss_cityid"];
		}elseif(isset($_COOKIE["ck_cityid"])){
			return intval($_COOKIE["ck_cityid"]);
		}else{
			return 0;
		}
	}
}