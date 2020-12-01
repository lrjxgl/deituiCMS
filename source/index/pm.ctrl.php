<?php
/*
*聊天私信
*/
class pmControl extends skymvc{
	
	function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		M("login")->checklogin();
	}
	
	public function onDefault(){
		$userid=M("login")->userid;
		$user=M("login")->getUser();
		$pagesize=20;
		$start=get('per_page','i');
		$where['userid']=$userid;
		$option=array(
			"where"=>$where,
			"order"=>"dateline DESC",
			"start"=>$start,
			"limit"=>$pagesize				
		); 
		$rscount=true;
		$msglist=M("pm_index")->select($option,$rscount);
		if($msglist){
			foreach($msglist as $k=>$v){
				$d=M("pm")->selectRow(array("where"=>"userid=".$v['userid']." AND t_userid=".$v['t_userid']." ","order"=>" id DESC"));
				$v['content']=$d['content'];
				$v['timeago']=timeago($v['dateline']);
				$v["isme"]=$v["type_id"]==2?1:0;
				$u=M("user")->selectRow(array("where"=>" userid=".$v['t_userid']));
				$v['t_nickname']=$u['nickname'];
				$v['t_user_head']=images_site($u['user_head']);
				$v["user_head"]=$user["user_head"];
				$v["nickname"]=$user["nickname"];
				$msglist[$k]=$v;
			}
		}
 
		$this->smarty->goAssign(array(
			"msglist"=>$msglist,
			"pagelist"=>$pagelist,
			"rscount"=>$rscount
		));
		$this->smarty->display("pm/index.html");
	}
	public function onGetNewIndex(){
		$userid=M("login")->userid;
		$num=M("pm_index")->selectOne(array(
			"where"=>" userid=".$userid." AND status=0 ",
			"fields"=>" count(*) as ct "
		));
		echo json_encode(array(
			"error"=>0,
			"message"=>"success",
			"num"=>$num
		));
	}
	/**
	*改变状态
	*/
	public function onStatus(){
		$id=intval($_GET['id']);
		M("pm")->update(array(
			"status"=>1
		)," id='$id' AND touserid='$userid' ");
		 
		$this->gourl();
	}
	
	/**
	*删除全部私信
	*/
	public function onDelete_index(){
		$id=get('id','i');
		$userid=M("login")->userid;
		$rs=M("pm_index")->selectRow(array("where"=>array("id"=>$id)));
	 
		if($rs['userid']!=$userid ) exit(json_encode(array("error"=>1,"message"=>'你无删除权限')));
		//删除索引
		M("pm_index")->delete(array("id"=>$id)); 
		//删除总表
		M("pm")->delete("userid=".$rs['userid']." AND t_userid=".$rs['t_userid']." ");
		exit(json_encode(array("error"=>0,"message"=>"删除成功")));
	}
	/*删除私信*/
	public function onDelete_pm(){
		$id=get('id','i');
		$userid=M("login")->userid;
		$data=M("pm")->selectRow(array("id=$id"));
		if(empty($data)){
			exit(json_encode(array("error"=>1,"message"=>"私信不存在")));
		}
		$rs=M("pm_index")->selectRow(array("where"=>array("userid"=>$userid,"t_userid"=>$data['t_userid'])));
		//删除索引
		if($rs['pm_num']<=1){
			M("pm_index")->delete(array("id"=>$id)); 
		}else{
			M("pm_index")->changenum("pm_num",-1,"id=$id");
		}
		//删除总表
		M("pm")->delete("id=$id ");

		exit(json_encode(array("error"=>0,"message"=>"删除成功")));
	}
	
	public function onSend(){
		$userid=M("login")->userid;
		$userid=get('userid','i');
		$user=M("user")->selectRow("userid=".$userid);
		if($userid==M("login")->userid){
			echo json_encode(array("error"=>1,"message"=>"不能给自己发私信"));
			exit;
		}
		$this->smarty->goassign(array("user"=>$user));
		$this->smarty->display("pm/pm_send_.html");
	}
	
	public function onSendSave(){
		$userid=M("login")->userid;
		$t_userid=post("t_userid","i");
		if($userid==$t_userid){
			$this->goAll("不能给自己发私信",1);
		}
		$content=post('content','h');
		if(empty($content)){
			$this->goAll("内容不能为空",1);
		}
		$dateline=time();
		//发私信的人
		$f_data['userid']=$userid;
		$f_data['type_id']=2;
		$f_data['t_userid']=$t_userid;
		$f_data['dateline']=$dateline;
		$f_data['content']=$content;
		$newid=M("pm")->insert($f_data);						
		/*私信索引表*/
		$pi_data=array(
			"userid"=>$userid,
			"t_userid"=>$t_userid,
			"dateline"=>time(),
			"type_id"=>2,
			"status"=>2
		);	
		if($d=M("pm_index")->selectRow(array("where"=>" userid=$userid AND t_userid={$t_userid}" ))){						 
			$pi_data["pm_num"]=$d['pm_num']+1;
			
			M("pm_index")->update($pi_data,array("id"=>$d['id']));
		}else{
			$pi_data["pm_num"]=1;
			
			M("pm_index")->insert($pi_data);
			
		}
		//收私信的人处理
		$t_data['userid']=$t_userid;
		$t_data['type_id']=1;
		$t_data['t_userid']=$userid;
		$t_data['dateline']=$dateline;
		$t_data['content']=$content;	
		$newid=M("pm")->insert($t_data);
		$t_data['id']=$newid;
		/*私信索引表*/
		$pi_data=array(
			"userid"=>$t_userid,
			"type_id"=>1,
			"t_userid"=>$userid,
			"dateline"=>time()
		);						
		if($d=M("pm_index")->selectRow(array("where"=>" userid=".$t_userid." AND  t_userid=".$userid."  ") )){
			$pi_data["pm_num"]=$d['pm_num']+1;
			M("pm_index")->update($pi_data,array("id"=>$d['id']));
		}else{
			$pi_data["pm_num"]=1;
			M("pm_index")->insert($pi_data);							
		}
		

		$this->goall("私信发送成功");
	}
	public function onDetail(){
		$t_userid=get('t_userid','i');
		$userid=M("login")->userid;
		$t_user=M("user")->getUser($t_userid,"nickname,userid,user_head");
		$user=M("login")->getUser();
		//更新状态
		$data['status']=2;//已读
		M("pm_index")->update(array(
			"status"=>2
		),"userid=$userid AND  t_userid={$t_userid} ");
		M("pm")->update($data,"userid=$userid AND  t_userid={$t_userid} ");
		$pagesize=20;
		$start=get('per_page','i');
		$rscount=true;		
		$option=array(
			"where"=>array(
				"userid"=>$userid,
				"t_userid"=>$t_userid,
			),
			"start"=>$start,
			"limit"=>$pagesize,
			"order"=>"id DESC",
		);
		$pmlist=M("pm")->select($option,$rscount);
		if($pmlist){			
			foreach($pmlist as $k=>$v){
				$v["isme"]=$v["type_id"]==2?1:0;
				$v['t_nickname']=$t_user['nickname'];
				$v['t_user_head']=$t_user['user_head'];
				$v['nickname']="我";
				$v['user_head']=$user['user_head'];
				$v['timeago']=timeago($v['dateline']);
				$times[$k]=$v["id"];
				$pmlist[$k]=$v;
			}
			array_multisort ( $times ,  SORT_ASC ,  $pmlist );
		}
		$pagelist=$this->pagelist($rscount,$pagesize,"index.php?m=pm&a=detail&t_userid={$t_userid}");
		$per_page=$start+$pagesize;
		$per_page=$per_page>$rscount?0:$per_page;
		$this->smarty->goassign(
			array(
				"pmlist"=>$pmlist,
				"t_nickname"=>$t_user['nickname'],
				"pagelist"=>$pagelist,
				"rscount"=>$rscount,
				"per_page"=>$per_page
			)
		);
		
		$this->smarty->display("pm/detail.html");
		
	}
	
	public function onGetNew(){
		$t_userid=get('t_userid','i');
		$userid=M("login")->userid;
		$num=M("pm")->selectOne(array(
			"where"=>"status=1 AND userid=".$userid." AND  t_userid=".$t_userid,
			"fields"=>"count(*) as ct"
		));
		echo json_encode(array(
			"error"=>0,
			"message"=>"success",
			"data"=>$num
		));
	}
	
}

?>