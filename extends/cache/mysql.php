<?php
class mysqlCache{
	public static function set($k,$v,$expire){	 
		$row=M('dbcache')->selectRow("k='".$k."'");
		$data=array(
			"k"=>$k,
			"v"=>urlencode(json_encode($v)), 
			"expire"=>time()+$expire
		);
		if(empty($row)){
			M('dbcache')->insert($data);
		}else{
			M('dbcache')->update($data,"id=".$row['id']);
		}
	}
	
	public static function get($k){
		$row=M('dbcache')->selectRow("k='".$k."'");
		 
		if($row && $row['expire']>time()){
			return json_decode(urldecode($row['v']),true); 
		}
		
		return false;
	}
	public static function del($k){
		$row=M('dbcache')->delete("k='".$k."'");
	}
}	 
?>