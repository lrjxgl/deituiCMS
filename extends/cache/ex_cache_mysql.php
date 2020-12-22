<?php
function cache_mysql_set($k,$v,$expire){	 
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

function cache_mysql_get($k){
	$row=M('dbcache')->selectRow("k='".$k."'");
	 
	if($row && $row['expire']>time()){
		return json_decode(urldecode($row['v']),true); 
	}
	
	return false;
}

function cache_mysql_delete($k){
	$row=M('dbcache')->delete("k='".$k."'");

}
?>