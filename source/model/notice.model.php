<?php
class noticeModel extends model{
	 
	function __construct (){
		parent::__construct ();
		 
		$this->table="notice";	
	}
	
	public function sendNotice($data){
		$data['id']=$this->insert($data);
		return $data['id'];
	}
	
	public function deleteNotice($userid,$id){
		$data=$this->selectRow(array("where"=>"id=$id"));
		if($data['userid']==$userid){
			$this->delete("id=$id");
		}
	}
	
	public function add($option){
		
		if(is_array($option['content'])){
			$content=$option['content']['content'];
			$con=$option['content'];
		}else{
			$content=$option['content'];
		}
		if(isset($option['title'])){
			$title=$option['title'];
		}else{
			$title="通知";
		}
		$userid=$option['userid'];
		$linkurl=$option['linkurl'];
		//发送通知
		$msg=array(
			"dateline"=>time(),
			"status"=>0,
			"userid"=>$userid,
			"content"=>sql($content),
			"linkurl"=>arr2str($linkurl),
			"title"=>$title
		);
		$this->insert($msg);
		//发送推送信息
		
		$pushlist=M("apppush")->select(array(
			"where"=>"  userid=".$userid
		));
		if($pushlist){
			$content=array(
				"content"=>removelink($content),
				
			); 
			if($option['orderno']){
				$content['orderno']=$option['orderno'];
			}
			foreach($pushlist as $v){
				$pdata=array(
					"pid"=>$v['id'],
					"typeid"=>1,
					"dateline"=>time(),
					"content"=>arr2str($option['content']),
					"template_id"=>$option['template_id'],
					"url"=>parseStrLink(arr2str($linkurl))
				);
				M("apppush_plan")->insert($pdata);
			}
		}
		
		//End 推送信息		
	}
}

?>