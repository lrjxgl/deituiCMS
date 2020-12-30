<?php
class userModel extends model{
	 
	public $invite_step=0;
	public function __construct(){
		parent::__construct();
		 
		$this->table="user";
	}
	public function Dselect($option,&$rscount=false){
		$list=$this->select($option,$rscount);
		if($list){
			foreach($list as $k=>$v){
				if(isset($v["user_head"])){
					$v["user_head"]=images_site($v["user_head"]);
				}
				$list[$k]=$v;
			}
		}
		return $list;
	}
	public function is_auth_list(){
		return array(
			1=>"已认证",
			2=>"未通过认证",
			3=>"等待认证",
		);
	}
	
	public function getUser($userid,$fields="userid,nickname,telephone,user_head,gender"){
		$data= $this->selectRow(array(
			"where"=>"userid=".$userid,
			"fields"=>$fields
		));
		if($data){
			$data['user_head']=images_site($data['user_head']);
		}
		return $data;
	}
	
	public function getUserByIds($uids,$fields=""){
		$uids=array_unique($uids);
		if(!empty($uids)){
			$option['where']=" userid in(".implode(",",$uids).")";
			$fields && $option['fields']=$fields;
			$data=parent::select($option);
			if($data){
				$userlist=array();
				foreach($data as $k=>$v){
					unset($v['password']);
					unset($v['salt']);
					$v['user_head']=images_site($v['user_head']);
					$userlist[$v['userid']]=$v;
				}
				return $userlist;
			}
		}
		return false;
	}
	
	/**
		收入支出处理
		$option=array(
			"userid"=>1,
			"money"=>$money,
			"content"=>"您获得了[money]元",
			"siteid"=>SITEID
		) 	
	**/
	
	public function addMoney($option){
		$userid=$option['userid'];
		$row=$this->selectRow("userid=".$userid);
		if(empty($row)) return false;
		$data=array();
		if(isset($option['money'])){
			$data['money']=$row['money']+$option['money'];
			
		}
		
		if(isset($option['gold'])){
			$data['gold']=$row['gold']+$option['gold'];		
		}
		
		if(isset($option['grade'])){
			$data['grade']=$row['grade']+$option['grade'];
			
		}
		
	 
		 
		$this->update($data,"userid=".$row['userid']);
		 
		$logdata=array(
				"dateline"=>time(),
				"userid"=>$userid,
				"type_id"=>1,
			 		 
		);
		
		
		 
		
		if(isset($option['money']) && $option['money']!=0){
			 
			$logdata['money']=$option['money'];
			$logdata['content']=str_replace("[money]",$option['money'],$option['content'])." 原来".$row['money']."元，现在".$data['money']."元";
			M("pay_log")->insert($logdata);
		}
		
		if(isset($option['gold']) && $option['gold']!=0 ){
			 
			$logdata['money']=$option['gold'];
			$logdata['content']=str_replace("[money]",$option['gold'],$option['content'])." 原来".$row['gold']."个，现在".$data['gold']."个";
			M("gold_log")->insert($logdata);
		}
		
		if(isset($option['grade']) && $option['grade']!=0){
			unset($logdata['money']); 
			$logdata['grade']=$option['grade'];
			$logdata['content']=str_replace("[money]",$option['grade'],$option['content'])." 原来".$row['grade']."分，现在".$data['grade']."分";
			M("grade_log")->insert($logdata);
		}
		
	}
	
	
	/*获取所有的下线*/
	public function getChildIds($userid){
		 
		$t_d=self::select(array("where"=>" invite_userid=".$userid." ","fields"=>"userid,nickname"));
	 
		if($t_d){
			foreach($t_d as $k=>$v){			
				$t_d[$k]['child']=$this->getChildIds($v['userid']);
			}
		}
		return $t_d;
	}
	
	/*获取所有的上线*/
	public function getParentsIds($userid,$maxStep=1){
		$uids[]=$userid;
		if($this->invite_step>=$maxStep){
			return false;
		}
		$this->invite_step++;
		$t_d=self::selectRow(array("where"=>" userid=".$userid." ","fields"=>"userid,invite_userid"));
		if($t_d['invite_userid']){
			$uids[]=$t_d['invite_userid'];
			$id=$this->getParentsIds($t_d['invite_userid'],$maxStep);
			if(is_array($id)){
				$uids=array_merge($uids,$id);
			}
			
		}
		$uids=array_unique($uids);
		return $uids;
	}
	
	
}
?>