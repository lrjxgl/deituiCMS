<?php
class followControl extends skymvc{
	public $userid;
	public function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		M("login")->checkLogin();
		$this->userid=M("login")->userid;
	}
	
	public function onDefault(){
		$userid=$this->userid;
		$ta="我的";
		if(get('userid','i') && $userid!=get('userid','i')){
			$userid=get('userid','i');
			$user=M("user")->selectRow("userid=".$userid);
			$ta="Ta的";
		}else{
			$user=M("login")->getUser();
		}
		$_GET['type']=$type=max(1,get('type'));
		$where=" userid=".$userid;
		$limit=20;
		$option=array(
			"where"=>$where,
			"limit"=>$limit
		);
		$rscount=true;
		$data=M("follow")->select($option,$rscount);
		
		if($data){
			foreach($data as $k=>$v){
				$uids[]=$v['t_userid'];
			}
			$us=M("user")->getUserByIds($uids,"userid,nickname,user_head,follow_num,followed_num");
			$fuids=M("follow")->selectCols(array(
				"fields"=>"t_userid",
				"where"=>" userid=".$userid." AND t_userid in("._implode($uids).")"
			));
			if(!$fuids) $fuids=array($userid);  
			foreach($data as $k=>$v){
				if($fuids && in_array($v['t_userid'],$fuids)){
					$isfollow=1;
				}else{
					$isfollow=0;
				}
				$v= $us[$v['t_userid']];
				$v["isfollow"]=$isfollow;
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$per_page=$start+$limit;
		$per_page=$per_page>=$rscount?0:$per_page;
		$this->smarty->goassign(array(
			"list"=>$data,
			"pagelist"=>$pagelist,
			"per_page"=>$per_page,
			"user"=>$user,
			"ta"=>$ta,
			"type"=>$type
		));
		$this->smarty->display("follow/index.html");
		
	}
	
	
	public function onfollowed(){
		$userid=$this->userid;
		$ta="我的";
		if(get('userid','i') && $userid!=get('userid','i')){
			$userid=get('userid','i');
			$user=M("user")->selectRow("userid=".$userid);
			$ta="Ta的";
		}else{
			$user=M("login")->getUser();
		}
		$_GET['type']=$type=max(1,get('type'));
		$where=" userid=".$userid;
		$limit=20;
		$option=array(
			"where"=>$where,
			"limit"=>$limit
		);
		$rscount=true;
		$data=M("followed")->select($option,$rscount);
		
		if($data){
			foreach($data as $k=>$v){
				$uids[]=$v['t_userid'];
			}
			
			$us=M("user")->getUserByIds($uids,"userid,nickname,user_head,follow_num,followed_num");
			$fuids=M("follow")->selectCols(array(
				"fields"=>"t_userid",
				"where"=>" userid=".$userid." AND t_userid in("._implode($uids).")"
			));
			if(!$fuids) $fuids=array($userid); 
			foreach($data as $k=>$v){
				if($fuids && in_array($v['t_userid'],$fuids)){
					$isfollow=1;
				}else{
					$isfollow=0;
				}
				$v= $us[$v['t_userid']];
				$v["isfollow"]=$isfollow;
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$per_page=$start+$limit;
		$per_page=$per_page>=$rscount?0:$per_page;
		$this->smarty->goassign(array(
			"list"=>$data,
			"pagelist"=>$pagelist,
			"per_page"=>$per_page,
			"user"=>$user,
			"ta"=>$ta,
			"type"=>$type
		));
		$this->smarty->display("follow/followed.html");
		
	}
	
	
	
	public function onfollowBtn(){
		$t_userid=get('t_userid','i');
		$userid=M("login")->userid;
		
		if(M("login")->userid && $t_userid){
			
			$user=M("user")->getUser($t_userid);
			$row=M("follow")->selectRow("userid=".$userid." AND t_userid=".$t_userid."");
			if($row){
				$user['followed']=1;
			}
			 
			$this->smarty->goAssign("user",$user);
		}
		$data=$this->smarty->fetch("follow/jsbtn.html");
		echo strtojs($data);
		exit;
	}
	
	public function onToggle(){
		$t_userid=get_post('t_userid','i');
		$row=M("follow")->selectRow(array("where"=>"t_userid=".$t_userid." AND userid=".$this->userid."   "));
		if($row){
			$this->onUnFollow();
		}else{
			$this->onFollow();
		}
	}
	
	public function onFollow(){
		$t_userid=get_post('t_userid','i');
		if($this->userid == $t_userid){
			exit(json_encode(array("error"=>1,"message"=>"不能关注自己哦")));
		}
		//判断是否关注了
		$row=M("follow")->selectRow(array("where"=>"t_userid=".$t_userid." AND userid=".$this->userid."   "));
		$status=1;
		if(isset($row['status'])  ){
			exit(json_encode(array("error"=>1,"message"=>"你已经关注他了")));
		}else{
			//判断是否被关注 主角我
			$row=M("followed")->selectRow(array("where"=>" t_userid=".$t_userid." AND userid=".$this->userid."  "));
			if(isset($row['status'])){//被关注
				//插入关注表 双向关注
				$data=array(
					"userid"=>$this->userid,
					"t_userid"=>$t_userid,
					"status"=>2,
					"dateline"=>time(),
					
				);
				$data['id']=M("follow")->insert($data);
				 
				
				/******************被关注表************/
				//更新被关注人
				M("follow")->update(array("status"=>2),"  userid=".$t_userid." AND t_userid=".$this->userid."  ");
				// 更新自己
				M("followed")->update(array("status"=>2)," t_userid=".$t_userid." AND userid=".$this->userid."  ");
				
				//插入 被关注的人
				$data=array(
					"t_userid"=>$this->userid,
					"userid"=>$t_userid,
					"status"=>2,
					"dateline"=>time(),
					
				);
				$status=2;
				$data['id']=M("followed")->insert($data);
			}else{
				//插入关注表
				$data=array(
					"userid"=>$this->userid,
					"t_userid"=>$t_userid,
					"status"=>1,
					"dateline"=>time(),
					
				);
				$data['id']=M("follow")->insert($data);
				//插入被关注表
				$data=array(
					"t_userid"=>$this->userid,
					"userid"=>$t_userid,
					"status"=>1,
					"dateline"=>time(),
					
				);
				$data['id']=M("followed")->insert($data);
				
			}
			M("user")->changenum("follow_num",1,"userid=".$this->userid);
			M("user")->changenum("followed_num",1,"userid=".$t_userid);
			//拉取新鲜事
			if(M("module")->isInstall("sblog")){
				$news=M("mod_sblog_blog")->select(array(
					"where"=>" userid=".$t_userid." AND status in(0,1) ",
					"limit"=>50,
					"order"=>"id DESC",
					"fields"=>"id,userid,createtime"
				));
				if($news){
					foreach($news as $v){
						M("mod_sblog_feeds")->insert(array(
							"userid"=>$this->userid,
							"fuserid"=>$v['userid'],
							"dateline"=>strtotime($v['dateline']),
							"blogid"=>$v['id']
						));
					}
				}
			}
			exit(json_encode(array("error"=>0,"message"=>"关注成功","status"=>$status,"follow"=>1)));
		}
	}
	
	
	public function onUnfollow(){
		$t_userid=get_post('t_userid','i');
		$row=M("follow")->selectRow(array("where"=>"t_userid=".$t_userid." AND userid=".$this->userid."  "));
		if(empty($row)){
			exit(json_encode(array("error"=>1,"message"=>"你还未关注他哦")));
		}else{
			//删除关注
			M("follow")->delete("id=".$row['id']);
			if($row['status']==2){//双向关注 更新为关注
				M("followed")->update(array("status"=>1)," t_userid=".$t_userid." AND  userid=".$this->userid."  ");
				M("followed")->delete(" userid=".$t_userid." AND t_userid=".$this->userid."  ");
				
				M("follow")->update(array("status"=>1)," userid=".$t_userid." AND t_userid=".$this->userid."  ");
				
			}else{				
				//删除被关注 单向关注 直接删除
				M("followed")->delete(" userid=".$t_userid." AND t_userid=".$this->userid."  ");
			}
			M("user")->changenum("follow_num",-1,"userid=".$this->userid);
			M("user")->changenum("followed_num",-1,"userid=".$t_userid);
			//删除新鲜事
			if(M("module")->isInstall("sblog")){
				M("mod_sblog_feeds")->delete("userid=".$this->userid." AND fuserid=".$t_userid);				
			}
			exit(json_encode(array("error"=>0,"message"=>"取消关注成功","status"=>0,"follow"=>0)));
		}
	}
	
}

?>