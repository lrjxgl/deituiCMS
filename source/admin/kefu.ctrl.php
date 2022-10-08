<?php
	class kefuControl extends skymvc{
		public function __construct(){
			parent::__construct();
		}
		public function onDefault(){
			 
			$url="/admin.php?m=kefu";
			$limit=24;
			$start=get("per_page","i");
			$rscount=true;
			$where=" 1 ";
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" isreply ASC ,id DESC",
				"where"=>$where
			);
			$list=M("kefu_msgindex")->select($option,$rscount);
			if($list){
				foreach($list as $v){
					$uids[]=$v["userid"];
				}
				$us=M("user")->getUserByIds($uids);
				foreach($list as $k=>$v){
					$v["nickname"]=$us[$v["userid"]]["nickname"];
					$v['timeago']=timeago(strtotime($v["createtime"]));
					$list[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goAssign(array(
				"list"=>$list,
				"pagelist"=>$pagelist
			));
			$this->smarty->display("kefu/index.html");
		}
		public function onUser(){
			$userid=get("userid","i");
			$user=M("user")->getUser($userid);
			$this->smarty->goAssign(array(
				"userid"=>$userid,
				"user"=>$user
			));
			$this->smarty->display("kefu/user.html");
		}
		public function onData(){
			$userid=get("userid","i"); 
			$where="status=1 AND userid=".$userid;
			$start=get("per_page","i");
			$rscount=true;
			$limit=24;
			$list=M("kefu_msg")->select(array(
				"where"=>$where,
				"order"=>" id DESC",
				"limit"=>$limit,
				"start"=>$start
			));
			if(!empty($list)){
				foreach($list as $k=>$v){
					$ids[]=$v["id"];
				}
				array_multisort($list,$ids,SORT_DESC);
			}
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goAssign(array(
				"list"=>$list,
				"per_page"=>$per_page,
				"rscount"=>$rscount
			));
		}
		public function onSave(){
			 
			$userid=get_post("userid","i");
			$content=post("content","h");
			M("kefu_msg")->insert(array(
				"userid"=>$userid,
				"content"=>$content,
				"status"=>1,
				"createtime"=>date("Y-m-d H:i:s"),
				"tablename"=>"kefu"
			));
			$row=M("kefu_msgindex")->selectRow("userid=".$userid);
			if($row){
				M("kefu_msgindex")->update(array(
					"isread"=>1, 
					"content"=>$content,
					"createtime"=>date("Y-m-d H:i:s")
				),"id=".$row["id"]);
			}else{
				M("kefu_msgindex")->insert(array(
					"userid"=>$userid,
					"content"=>$content,
					"isread"=>1,
					"createtime"=>date("Y-m-d H:i:s")
				));
			}
			//网站通知
			M("site_msg")->remove("kefu");
			 
			$this->goAll("保存成功");
		}
	}
?>