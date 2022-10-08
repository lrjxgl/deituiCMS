<?php
class noticeControl extends skymvc{
	public $userid;
	public function __construct(){
		parent::__construct();	 
	}
	
	public function onInit(){
		$this->userid=M("login")->userid;
		M("login")->checkLogin();
	}
	/**获取所有未读消息***/
	public function onGetAllNum(){
		//通知
		$noticeNum=M("notice")->selectOne(array(
			"where"=>"userid=".$this->userid." AND status=0",
			"order"=>"id DESC",
			"fields"=>" count(*) as ct"
		));
		//客服
		$msgNum=0;
		if(M("module")->isInstall("kefu")){
			$msgNum=M("mod_kefu_msg_index")->selectOne(array(
				"where"=>"userid=".$this->userid." AND isread=0",
				"order"=>"id DESC",
				"fields"=>" count(*) as ct"
			));
		}
		
		$num=$noticeNum+$msgNum;
		$data=array(
			"noticeNum"=>intval($noticeNum),
			"msgNum"=>intval($msgNum),
			"num"=>$num
		);
		echo json_encode(array("error"=>0,"data"=>$data));
	}
	
	public function onReadKefu(){
		M("mod_kefu_msg_index")->update(array(
			"isread"=>1
			
		),"userid=".$this->userid." AND isread=0");
		$this->goAll("success");
	}
	public function onReadNotice(){
		$where=" userid=".$this->userid." AND status=0 ";
		$id=get("id","i");
		if($id){
			$where.=" AND id=".$id;
		}
		M("notice")->update(array(
			"status"=>1
		),$where);
		$this->goAll("success");
	}
	
	public function onDefault(){
		$url="/index.php?m=notice";
		$where=" userid=".$this->userid."  ";
		$start=get('per_page','i');
		$limit=10;
		$option=array(
			"where"=>$where,
			"order"=>"status asc,id DESC",
			"start"=>$start,
			"limit"=>$limit
		);
		$rscount=true;
		$data=M("notice")->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$ids[]=$v['id'];
				$v['status_name']=$v['status']==0?"未读":"已读";
				$v['timeago']=timeago($v['dateline']);
				$v['linkdata']=str2arr($v['linkurl']);
				$v['linkurl']=parseStrLink($v['linkurl']);
				
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->goassign(array(
			"data"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist
		));
		
		$this->smarty->display("notice/index.html");
	}
	
	public function onDelete(){
		$id=get('id','i');
		M("notice")->delete("id=".$id);
		$this->goAll("通知删除成功");
		 
	}
	
	public function onstatus(){
		$id=get('id','i');
		M("notice")->update(array("status"=>1),"id=".$id);
	}
	
}

?>