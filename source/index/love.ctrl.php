<?php
class loveControl extends skymvc
{
	public $userInfo;
	public function __construct(){
		parent::__construct();		
	}
	
	public function onInit(){
		M("login")->checklogin();
		$this->userInfo=M("login")->getUser();
	}
	
	public function onDefault(){
		
	}
	
	public function onLove_btn(){
		$id=get('id','i');
		$tablename=get('tablename','h');
		$t_userid=get('t_userid','i');
	 
		if(!M("login")->userid){
			 $islove=0;
		}else{
			
			$islove=M("love")->selectRow(" objectid=".$id." AND tablename='".$tablename."'  ");
			
		}
		$this->smarty->assign(array(
				"islove"=>$islove,
				"addurl"=>"/index.php?m=love&a=add&ajax=1&objectid=".$id."&t_userid=".$t_userid."&tablename=".$tablename."&type_id=1",
				"removeurl"=>"/index.php?m=love&a=delete&ajax=1&objectid=".$id."&t_userid=".$t_userid."&tablename=".$tablename."&type_id=1",
			));
		$data=$this->smarty->fetch("love/jsbtn.html");
		echo strtojs($data);
		exit;
	}
	
	/**
	*添加喜欢组件 
	*<a href="{$appindex}?m=love&a=add&objectid={$data.id}&type_id=1&model_id={const.ARTICLE_MODEL_ID}">喜欢</a>
	*/
	public function onadd(){
		$where['tablename']=$data['tablename']=get_post('tablename','h');
		$where['objectid']=$data["objectid"]=get_post("objectid","i");
		$where['userid']=$data["userid"]=$this->userInfo['userid'];
		$data["t_userid"]=get_post("t_userid","i");
		$data["dateline"]=time();
		if($row=M("love")->selectRow(array("where"=>$where))){
			exit(json_encode(array("error"=>1,"message"=>$this->lang['love_is_existed'])));
		}else{
			M("love")->insert($data);
			 
			M($data['tablename'])->changenum("love_num",1,"id=".$data['objectid']);
				 
			exit(json_encode(array("error"=>0,"message"=>"success")));
		}
	}
	/**
	*检测是否喜欢组件
	*/
	public function onCheck(){
		$where['objectid']=get('objectid','i');
		$where['userid']=$this->userInfo['userid'];
		$where['tablename']=$data['tablename']=get_post('tablename','h');
		$data=M("love")->selectRow(array("where"=>$where));
		if(!empty($data)){
			exit(json_encode(array("status"=>1)));
		}else{
			exit(json_encode(array("status"=>0)));
		}
	}
	
	public function onToggle(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		$objectid=get_post("objectid","i");
		$tablename=get_post("tablename","h");
		$row=M("love")->selectRow("userid=".$userid." AND objectid=".$objectid." AND tablename='".$tablename."' ");
		if($row){
			M("love")->delete("id=".$row['id']);
			$action="delete";
			M($tablename)->changenum("love_num",-1,"id=".$objectid);
		}else{
			M("love")->insert(array(
				"objectid"=>$objectid,
				"userid"=>$userid,
				"tablename"=>$tablename
			));
			$action="add";
			M($tablename)->changenum("love_num",1,"id=".$objectid);
		}
		$this->goAll("success",0,$action);
	}
	
	/**
	*删除喜欢组件 
	*/
	public function onDelete(){
		$where['tablename']=$data['tablename']=get_post('tablename','h');
		$where['objectid']=get('objectid','i');
		$where['userid']=M("login")->userid;
		$data=M("love")->selectRow(array("where"=>$where));
		if($data){			
			M("love")->delete($where);
			M($where['tablename'])->changenum("love_num",-1,"id=".$data['objectid']);
			exit(json_encode(array("error"=>0,"message"=>"sucess")));
		}else{
			exit(json_encode(array("error"=>1,"message"=>$this->lang['delete_fail'])));
		}
		
	}
	
	
	public function onmyLove(){
		$userid=$this->userInfo['userid'];
		$tablename=max(1,get('tablename','i'));
		$option=array(
			"where"=>" userid=".$userid." AND tablename='".$tablename."' ",
		);
		$rscount=true;
		$data=M("love")->select($userid,$option,$rscount);
		 
		if($data){
			foreach($data as $k=>$v){
				$a=m("tablename")->selectRow(array("id"=>$v['objectid']));
				$v['title']=$a['title'];
				$data[$k]=$v;
			}
		}
		$this->smarty->assign(array(
			"data"=>$data,
		));
		$this->smarty->display("love/my.html");
		
	}
	
	 
	
}
?>