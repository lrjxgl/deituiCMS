<?php
class forum_favControl extends skymvc
{
	public $userInfo;
	public function __construct(){
		parent::__construct();
		 
		
	}
	
	public function onInit(){
		M("login")->checklogin();
	}
	
	public function onDefault(){
		$this->smarty->display("fav/index.html");
	}
	public function onMy(){
		$tablename=get("tablename","h");
		$this->smarty->goAssign(array(
			"tablename"=>$tablename
		));
		$this->smarty->display("fav/my.html");
	}
	
	public function onMyList(){
		$tablename="mod_forum";
		 
		$userid=M("login")->userid;
		$start=get_post('per_page','i');
		$limit=24;
		$sql="select a.*,f.objectid 
			from ".table('fav')." as f 
			left join ".table($tablename)." as a  
			on f.objectid=a.id  
			where f.userid=".$userid." AND f.tablename='{$tablename}' AND a.status in(0,1)   
			order by f.id DESC
			limit $start,$limit 
		";
		 
		$rscount=M("fav")->selectOne(array(
			"where"=>" userid=".$userid." AND tablename='{$tablename}' ",
			"fields"=>" count(*) "
		)); 
		$list=M($tablename)->getAll($sql);
		if($list){
			foreach($list as $v){
				$uids[]=$v['userid'];
				$gids[]=$v['gid'];
			}
			$gs=MM("forum","forum_group")->getListByIds($gids,"gid,title");
			$us=M("user")->getUserByIds($uids);
			foreach($list as $k=>$v){
				$v['nickname']=$us[$v['userid']]['nickname'];
				$v['user_head']=images_site($us[$v['userid']]['user_head']);
				$v['timeago']=timeago($v['dateline']);
				$v['group_title']=$gs[$v['gid']]['title'];
				$v['imgurl']=images_site($v['imgurl']);
				if($v['imgsdata']){
					$imgs=explode(",",$v['imgsdata']);
					$imgslist=array();
					foreach($imgs as $img){
						$imgslist[]=images_site($img);
					}
					$v['imgslist']=$imgslist;
				}
				if($v["id"]==null){
					M("fav")->delete("userid=".$userid." AND tablename='{$tablename}' AND objectid=".$v["objectid"]);
				}
				$list[$k]=$v;
			}
		}
		$per_page=$start+$limit;
		$per_page=$per_page<$rscount?$per_page:0;
		$this->smarty->goAssign(array(
			"list"=>$list,
			"per_page"=>$per_page
		));
	}
	
	public function onToggle(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		$objectid=get_post("objectid","i");
		$tablename=get_post("tablename","h");
		$row=M("fav")->selectRow("userid=".$userid." AND objectid=".$objectid." AND tablename='".$tablename."' ");
		//获取表结构
		$fields=M($tablename)->getFields();
		$idField=$fields[0]['Field'];
		if($row){
			M("fav")->delete("id=".$row['id']);
			$action="delete";
			M($tablename)->changenum("fav_num",-1,$idField."=".$objectid);
		}else{
			M("fav")->insert(array(
				"objectid"=>$objectid,
				"userid"=>$userid,
				"tablename"=>$tablename
			));
			$action="add";
			M($tablename)->changenum("fav_num",1,$idField."=".$objectid);
		}
		$this->goAll("success",0,$action);
	}
	
	 
	
	 
	
}
?>