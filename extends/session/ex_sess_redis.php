<?php
	
function sess_read($id){
	$res= cache_redis_get("_sess_".$id);
	$res=$res?$res:"";
	return $res;		
}

function sess_write($id,$data){
	//session缓存两天
	cache_redis_set("_sess_".$id,$data,$expire=172800);
}

function sess_destroy($id){
	cache_redis_del("_sess_".$id);
	 
}
function sess_gc($t){
	
}
?>