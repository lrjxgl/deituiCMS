<?php
class cityControl extends skymvc{
	
	public function onDefault(){
		$dist=M("city")->select(array(
			"where"=>" status=1 ",
			"limit"=>10000,
			"fields"=>"id,name"
		));
		$str="abcdefghijklmnopqrstuvwxyz";
		$list=array();
		for($i=0;$i<strlen($str);$i++){
			$list[strtoupper($str{$i})]=array();
		}
		 
		loadFun("pinyin");
		$recList=M("city")->select(array(
			"where"=>"status=1 AND isrecommend=1",
			"limit"=>8,
			"fields"=>"id,name"
		)); 
		foreach($dist as $v){
			$pinyin=pinyin($v["name"]);
			$zm=strtoupper($pinyin{0});
			$list[$zm]["child"][]=$v;
		}
		foreach($list as $k=>$v){
			if(empty($v["child"])){
				unset($list[$k]);
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list,
			"recList"=>$recList
		));
		$this->smarty->display("city/index.html");
	}
	
	public function onSearch(){
		$city=get("city","h");
		$list=M("city")->select(array(
			"where"=>"name like '%".$city."%'",
			"limit"=>24, 
			"fields"=>"id,name"
		));
		$this->goAll("success",0,array(
			"list"=>$list
		));
	}
	
}