<?php
	class user_blackControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onInit(){
			M("login")->checkLogin();
		}
		public function onDefault(){
			
			$userid=M("login")->userid;
			$data=M("user_black")->select(array(
				"where"=>"userid=".$userid
			));
			if($data){
				foreach($data as $v){
					$uids[]=$v['buserid'];
				}
				$us=M("user")->getUserByIds($uids);
			}
			$this->smarty->goAssign(array(
				"data"=>$us
			));
			$this->smarty->display("user_black/index.html");
		}
		
		public function onSave(){
			$userid=M("login")->userid;
			$buserid=get('buserid','i');
			$row=M("user_black")->selectRow("userid=".$userid." AND buserid=".$buserid);
			if($userid==$buserid){
				$this->goAll("不能拉黑自己",1);
			}
			if($row){
				$this->goAll("你已经拉黑了",1);
			}else{
				M("user_black")->insert(array(
					"userid"=>$userid,
					"buserid"=>$buserid
				));
			}
			$this->goAll("拉黑成功");
		}
		
		public function onDelete(){
			$userid=M("login")->userid;
			$buserid=get('buserid','i');
			M("user_black")->delete("userid=".$userid." AND buserid=".$buserid);
			$this->goAll("删除成功");
		}
	}
	
?>