<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class blacklistControl extends skymvc{
		
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
			
			$url="/admin.php?m=blacklist&a=default";
			$limit=48;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("blacklist")->select($option,$rscount);
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
			M("blacklist")->delete("id=".$id);
			$this->goall("删除成功",0);
		}
		
		public function onAdd(){
			$userid=post("userid","i");
			$row=M("blacklist")->selectRow("userid=".$userid);
			if(!$row){
				M("blacklist")->insert(array(
					"userid"=>$userid,
					"dateline"=>time()
				));
			}
			$this->goAll("拉黑成功");
		}
		
	}

?>