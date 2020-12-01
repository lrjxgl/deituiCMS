<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class blacklist_postControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$nickname=get("nickname","h");
			$where="";
			if($nickname){
				$userid=M("user")->selectOne(array(
					"where"=>" nickname='".sql($nickname)."' ",
					"fields"=>"userid"
				));
				if($userid){
					$where=" userid=".$userid;
				}else{
					$where=" 1=2 ";
				}
				
			}
			
			$url=APPADMIN."?m=blacklist_post&a=default";
			$limit=48;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("blacklist_post")->select($option,$rscount);
			$list=array();
			if($data){
				foreach($data as $v){
					$uids[]=$v["userid"];
				}
				$us=M("user")->getUserByIds($uids,"userid,nickname,user_head");
				foreach($data as $v){
					$p=$us[$v["userid"]];
					$p["id"]=$v["id"];
					$list[]=$p;
				}
			}
			 
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$list,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("blacklist/index.html");
		}
		
	 
		public function onDelete(){
			$id=get_post('id',"i");
			M("blacklist_post")->delete("id=".$id);
			$this->goall("删除成功",0);
		}
		
		public function onAdd(){
			$userid=post("userid","i");
			$eday=get("eday","i");
			if(!$eday){
				$etime=time()+3600*24*365;
			}else{
				$etime=time()+3600*24*$eday;
			}
			
			$row=M("blacklist_post")->selectRow("userid=".$userid);
			if(!$row){
				M("blacklist_post")->insert(array(
					"userid"=>$userid,
					"dateline"=>time(),
					"etime"=>$etime
				));
			}else{
				M("blacklist_post")->update(array(
					"userid"=>$userid,
					"dateline"=>time(),
					"etime"=>$etime
				),"userid=".$userid);
			}
			$this->goAll("禁言成功");
		}
		
	}

?>