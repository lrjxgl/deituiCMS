<?php
class friendControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		M("login")->checkLogin();
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$sql=" select u.userid,u.nickname,u.user_head,u.info,u.gender 
				from ".table("friend")." as f 
				left join  ".table("user")." as u
				on f.touserid=u.userid
				where f.userid=".$userid."
		";
		$rscount=M("friend")->getOne("select count(*) from ".table("friend")." where userid=".$userid);
		$list=M("friend")->getAll($sql);
		if($list){
			foreach($list as $k=>$v){
				$v["user_head"]=images_site($v["user_head"]);
				$list[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list,
			"rscount"=>$rscount
		));
		$this->smarty->display("friend/index.html");	
	}
	
	public function onZm(){
		$userid=M("login")->userid;
		$sql=" select u.userid,u.nickname,u.user_head,u.info,u.gender 
				from ".table("friend")." as f 
				left join  ".table("user")." as u
				on f.touserid=u.userid
				where f.userid=".$userid."
		";
		$rscount=M("friend")->getOne("select count(*) from ".table("friend")." where userid=".$userid);
		$list=M("friend")->getAll($sql);
		if($list){
			foreach($list as $k=>$v){
				$v["user_head"]=images_site($v["user_head"]);
				$list[$k]=$v;
			}
		}
		$str="abcdefghijklmnopqrstuvwxyz";
		$slist=array();
		for($i=0;$i<strlen($str);$i++){
			$slist[strtoupper($str{$i})]=array();
		}
		$slist["#"]=array(); 
		loadFun("pinyin");
		foreach($list as $v){
			$pinyin=pinyin($v["nickname"]);
			$zm=strtoupper($pinyin{0});
			if(!isset($slist[$zm])){
				$slist["#"]["child"][]=$v;
			}else{
				$slist[$zm]["child"][]=$v;
			}
			
		}
		foreach($slist as $k=>$v){
			if(empty($v["child"])){
				unset($slist[$k]);
			}
		}
		$this->goAll("success",0,array(
			"list"=>$slist,

		));
	}
	
	public function onAdd(){
		$userid=M("login")->userid;
		$touserid=get("touserid","i");
		if($userid==$touserid){
			$this->goAll("不能添加自己",1);
		}
		$row=M("friend")->selectRow("userid=".$userid." AND touserid=".$touserid);
		if(!$row){
			M("friend")->insert(array(
				"userid"=>$userid,
				"touserid"=>$touserid,
				"dateline"=>time()
			));
			$this->goAll("添加成功");
		}else{
			$this->goAll("你们已经是朋友了");
		}
		
	}
	public function onCancel(){
		$userid=M("login")->userid;
		$touserid=get("touserid","i");
		if($userid==$touserid){
			$this->goAll("不能删除自己",1);
		}
		$row=M("friend")->selectRow("userid=".$touserid);
		if($row){
			M("friend")->delete("id=".$row["id"]);
		}
		$this->goAll("删除成功");
	}
	
}
