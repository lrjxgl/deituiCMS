<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class commentModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="comment";
	}
	
	/*评论列表*/
	public function commentlist($option,&$rscount=false){
		$data=M("comment")->select($option,$rscount);
		if($data){
			foreach($data as $v){
				$uids[]=$v['userid'];
			}
			$us=M("user")->getUserByIds($uids);
			foreach($data as $k=>$v){
				$u=$us[$v['userid']];
				$v['nickname']=$u['nickname'];
				$v['user_head']=images_site($u['user_head']);
				$v['author']=$u;
				$v['timeago']=timeago($v['dateline']);
				$data[$k]=$v;
			}
		}
		return $data;
	}
}

?>