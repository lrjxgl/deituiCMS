<?php
	class kefuControl extends skymvc{
		public function __construct(){
			parent::__construct();
		}
		public function onDefault(){
			M("login")->checkLogin();
			$this->smarty->display("kefu/index.html");
		}
		
		public function onData(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			$where="status=1 AND userid=".$userid;
			$list=M("kefu_msg")->select(array(
				"where"=>$where,
				"order"=>" id DESC",
				"limit"=>100
			));
			if(!empty($list)){
				$ids=[];
				foreach($list as $v){
					$ids[]=$v["id"];
				}
				array_multisort($list,$ids,SORT_ASC);
			}
			$this->smarty->goAssign(array(
				"list"=>$list
			));
		}
		public function onSave(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			$content=post("content","h");
			if(empty($content)){
				$this->goAll("内容不能为空",1);
			}
			M("kefu_msg")->insert(array(
				"userid"=>$userid,
				"content"=>$content,
				"status"=>1,
				"createtime"=>date("Y-m-d H:i:s"),
				"tablename"=>"user"
			));
			$row=M("kefu_msgindex")->selectRow("userid=".$userid);
			if($row){
				M("kefu_msgindex")->update(array(
					 
					"content"=>$content,
					"createtime"=>date("Y-m-d H:i:s")
				),"id=".$row["id"]);
			}else{
				M("kefu_msgindex")->insert(array(
					"userid"=>$userid,
					"content"=>$content,
					"createtime"=>date("Y-m-d H:i:s")
				));
			}
			//通知网站
			M("site_msg")->add([
				"tablename"=>"kefu",
				"content"=>"有人在客服中心咨询了"
			]);
			$this->goAll("保存成功");
		}
	}
?>