<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class forum_commentControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" status in(0,1,2)";
			$url="/moduleadmin.php?m=forum_comment&a=default";
			$sarr=array("id");
			foreach($_GET as $k=>$v){
				if($_GET[$k] && in_array($k,$sarr)){
					$where.=" AND $k='".get($k,'x')."' ";
					$url.="&$k=".urlencode(get($k));
				}
			} 
			$title=get('title','h');
			if($title){
				$where.=" AND content like '%".$title."%'";
				$url.="&title=".urlencode($title);
			}
			$nickname=get("nickname","h");
			if($nickname){
				$userid=M("user")->selectOne(array(
					"where"=>"nickname='".$nickname."'",
					"fields"=>"userid"
				));
				if($userid){
					$where.=" AND userid=".$userid;
				}else{
					$where.=" AND 1=2 ";
				}
				$url.="&nickname=".urlencode($nickname);
				
			}
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_forum_comment")->select($option,$rscount);
			if($data){
				$uids=array();
				foreach($data as $k=>$v){
					$uids[]=$v["userid"];
				}
				$us=M("user")->getUserByIds($uids);
				foreach($data as $k=>$v){
					$v["nickname"]=$us[$v["userid"]]["nickname"];
					$data[$k]=$v;
				}
			}
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("forum_comment/index.html");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$row=M("mod_forum_comment")->selectRow("id=".$id);
			$status=1;
			if($row["status"]==1){
				$status=2;
			}
			M("mod_forum_comment")->update(array(
				"status"=>$status
			),"id=".$id);
			$this->goAll("success",0,$status);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("mod_forum_comment")->update(array("status"=>11),"id=$id");
			$this->goAll("删除成功");
			 
		}
		
		
	}

?>