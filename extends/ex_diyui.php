<?php
function diyUi($m,$a){
	$row=M("pagetpl")->selectRow("m='".sql($m)."' AND a='".sql($a)."' ");
	if(empty($row) || empty($row["diydata"])){
		return false;
	}
	 
	$arr=explode("\r\n",$row["diydata"]);
	foreach($arr as $v){
		if(empty($v)) continue;
		$ee=explode("|",$v);
		$tpl=$ee[0];
		switch($ee[1]){
			case "ad":
				$res=M("ad")->listByNo(sql($ee[2]));
				break;
			default:
				$res=[];
				break;
		}
		
		 
		$arr=[];
		if(!empty($res)){
			foreach($res as $rs){
				$arr[]=array(
					"img"=>$rs["imgurl"],
					"link"=>$rs["link1"]
				);
			}
		}
		require "uicompent/".$tpl.".php";
	}
	
	 
}
