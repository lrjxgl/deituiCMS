<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class user_groupControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="status in(0,1,2)";
			$url="/admin.php?m=user_group&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" gid DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("user_group")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("user_group/index.html");
		}
		
		public function onAdd(){
			$gid=get_post("gid","i");
			if($gid){
				$data=M("user_group")->selectRow(array("where"=>"gid=".$gid));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("user_group/add.html");
		}
		
		public function onPeople(){
			$gid=get_post("gid","i");
			$group=M("user_group")->selectRow(array("where"=>"gid=".$gid));
			$limit=20;
			$start=get("per_page","i");
			$where=" gid=".$gid;
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$pps=M("user_group_people")->select($option,$rscount);
			$list=[];
			if($pps){
				foreach($pps as $p){
					$uids[]=$p["userid"];
				}
				$list=M("user")->getUserByIds($uids);
			}
			$this->smarty->goassign(array(
				"group"=>$group,
				"list"=>$list
			));
			$this->smarty->display("user_group/people.html");
		}
		
		public function ongetuser(){
			$nickname=get("nickname","h");
			$user=M("user")->selectRow("nickname='".$nickname."' ");
			if($user){
				$this->goAll("success",0,$user);
			}else{
				$this->goAll("error",1);
			}
		}
		
		public function onSave(){
			$gid=get_post("gid","i");
			$data=M("user_group")->postData();
			if($gid){
				M("user_group")->update($data,"gid='$gid'");
			}else{
				M("user_group")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$gid=get_post('gid',"i");
			$status=get_post("status","i");
			M("user_group")->update(array("status"=>$status),"gid=$gid");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$gid=get_post('gid',"i");
			M("user_group")->update(array("status"=>11),"gid=$gid");
			$this->goall("删除成功",0);
		}
		
		
	}

?>