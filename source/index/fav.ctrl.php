<?php
class favControl extends skymvc
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
		$tablename=get("tablename",'h');
		if(!in_array($tablename,array("article"))){
			$this->goAll("参数出错",1);
		} 
		$userid=M("login")->userid;
	 
		switch($tablename){
			case "article":
				$sql="select a.* 
					from ".table('fav')." as f 
					left join ".table('article')." as a  
					on f.object_id=a.id 
					where f.userid=".$userid." AND f.tablename='article' AND a.status=2 
				";
				break;
			 
				
		}
		$list=M($tablename)->getAll($sql);
		if($list){
			foreach($list as $k=>$v){
				$v['imgurl']=images_site($v['imgurl']);
				
				$list[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list
		));
	}
	
	public function onToggle(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		$object_id=get_post("object_id","i");
		$tablename=get_post("tablename","h");
		$row=M("fav")->selectRow("userid=".$userid." AND object_id=".$object_id." AND tablename='".$tablename."' ");
		if($row){
			M("fav")->delete("id=".$row['id']);
			$action="delete";
			M($tablename)->changenum("fav_num",-1,"id=".$object_id);
		}else{
			M("fav")->insert(array(
				"object_id"=>$object_id,
				"userid"=>$userid,
				"tablename"=>$tablename
			));
			$action="add";
			M($tablename)->changenum("fav_num",1,"id=".$object_id);
		}
		$this->goAll("success",0,$action);
	}
	
	public function  onfav_btn(){
		
		$id=get('id','i');
		$tablename=get('tablename','h');
		$t_userid=get('t_userid','i');
 
		if(!M("login")->userid){
			$isfav=0;
		}else{
			$isfav=M("fav")->selectRow(" object_id=".$id." AND tablename='".$tablename."'   ");
		}
		$this->smarty->assign(array(
			"isfav"=>$isfav,
			"addurl"=>"/index.php?m=fav&a=add&object_id=".$id."&t_userid=".$t_userid."&tablename=".$tablename."",
			"removeurl"=>"/index.php?m=fav&a=delete&object_id=".$id."&t_userid=".$t_userid."&tablename=".$tablename."",
		));
		$data=$this->smarty->fetch("fav/jsbtn.html");
		echo strtojs($data);
		exit;
	}
	
	/**
	*添加收藏组件 
	*<a href="{$appindex}?m=fav&a=add&object_id={$data.id}&type_id=1&model_id={const.ARTICLE_MODEL_ID}">喜欢</a>
	*/
	public function onadd(){
		
		$where['object_id']=$data["object_id"]=get_post("object_id","i");
		$where['userid']=$data["userid"]=M("login")->userid;
		$data["t_userid"]=get_post("t_userid","i");
		$data["dateline"]=time();
		$where['tablename']=$data["tablename"]=get_post('tablename');
		if($row=M("fav")->selectRow(array("where"=>$where))){
			exit(json_encode(array("error"=>1,"message"=>"已收藏")));
		}else{
			M("fav")->insert($data);
			if($where['tablename']=='shop'){
				M($data["tablename"])->changenum("fav_num",1,"shopid=".$data['object_id']);
			}else{
				M($data["tablename"])->changenum("fav_num",1,"id=".$data['object_id']);
			}
			exit(json_encode(array("error"=>0,"message"=>"收藏成功")));
		}
	}
	/**
	*检测是否喜欢组件
	*/
	public function onCheck(){
		$where['object_id']=get('object_id','i');
		$where['tablename']=get_post('tablename');
		$where['userid']=M("login")->userid;
		$data=M("fav")->selectRow(array("where"=>$where));
		if(!empty($data)){
			exit(json_encode(array("status"=>1)));
		}else{
			exit(json_encode(array("status"=>0)));
		}
	}
	
	/**
	*删除喜欢组件 
	*/
	public function onDelete(){
		$where['object_id']=get('object_id','i');
		$where['tablename']=get_post('tablename');
		$where['userid']=M("login")->userid;
		$data=M("fav")->selectRow(array("where"=>$where));
		if($data){			
			M("fav")->delete($where);
			if($where['tablename']=='shop'){
				M($where['tablename'])->changenum("fav_num",-1,"shopid=".$data['object_id']);
			}else{
				M($where['tablename'])->changenum("fav_num",-1,"id=".$data['object_id']);
			
			}
			exit(json_encode(array("error"=>0,"message"=>"取消成功")));
		}else{
			exit(json_encode(array("error"=>1,"message"=>"取消失败")));
		}
		
	}
	
	
	public function onmyfav(){
		$userid=$this->userInfo['userid'];
		$model_id=max(1,get('model_id','i'));
		$option=array(
			"where"=>" userid=".$userid." AND model_id=".$model_id." ",
		);
		$rscount=true;
		$data=M("fav")->select($userid,$option,$rscount);
		 
		if($data){
			foreach($data as $k=>$v){
				$a=M("article")->selectRow(array("id"=>$v['object_id']));
				$v['title']=$a['title'];
				$data[$k]=$v;
			}
		}
		$this->smarty->assign(array(
			"data"=>$data,
		));
		$this->smarty->display("fav/my.html");
		
	}
	
	 
	
}
?>