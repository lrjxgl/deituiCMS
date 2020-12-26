<?php
/*
*mysql队列
CREATE TABLE `sky_queue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderindex` int(10) unsigned NOT NULL DEFAULT '0',
  `k` varchar(32) NOT NULL DEFAULT '',
  `content` text,
  PRIMARY KEY (`id`),
  KEY `k_dateline` (`k`,`orderindex`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;


**/
class mysqlQueue{
	
	public static function lpush($k,$v){
		M("queue")->changenum("orderindex",1,"k='".$k."' ");
		M("queue")->insert(array(
			"content"=>arr2str($v),
			"k"=>$k,
			"orderindex"=>0
		));
	}
	public static function rpop($k){
		$row=M("queue")->selectRow(array(
			"order"=>"orderindex DESC",
			"limit"=>1,
			"where"=>"k='".$k."' "
		));
		if(empty($row)){
			return false;
		}
		M("queue")->delete("id=".$row["id"]);
		return str2arr($row["content"]);
		 
	}
	public static function rpush($k,$v){
		M("queue")->insert(array(
			"content"=>arr2str($v),
			"k"=>$k,
			"orderindex"=>time()
		));
	}
	
	public static function getList($k){
		$list=M("queue")->select(array(
			"order"=>"orderindex DESC",
			"where"=>"k='".$k."' "
		));
		$nlist=[];
		if($list){
			foreach($list as $k=>$v){
				$nlist[]=str2arr($v["content"]);
				 
			}
		}
		return $nlist;
	}
}
 