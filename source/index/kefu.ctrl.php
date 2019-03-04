<?php
	class kefuControl extends skymvc{
		public function __construct(){
			parent::__construct();
		}
		public function onDefault(){
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
			$this->smarty->goAssign(array(
				"list"=>$list
			));
		}
		public function onSave(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			$content=post("content","h");
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
			$this->goAll("保存成功");
		}
	}
?>