<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class guestControl extends skymvc{
		public $userid;
		public function __construct(){
			parent::__construct();	
		}
		
		public function onInit(){
			$this->userid=M("login")->userid;
		}
		
		public function onDefault(){
			$where=" status=1 ";
			$url="/index.php?m=guest&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$type_list=M("guest")->type_list();
			$data=M("guest")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"type_list"=>$type_list
				)
			);
			$tpl=M("pagetpl")->get("guest","index");
			$this->smarty->display($tpl);
		 
		}
		
		 
		 
		public function onMy(){
			M("login")->checklogin();
			$where="  status=1 AND userid=".$this->userid;
			$url="/index.php?m=guest&a=my";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("guest")->select($option,$rscount);
			if($data){
				foreach($data as $k=>$v){
					$uids[]=$v['touserid'];
				}
				$us=M("user")->getUserByIds($uids);
				foreach($data as $k=>$v){
					if($v['touserid']){
						$v['tonickname']=$us[$v['touserid']];
					}else{
						$v['tonickname']="管理员";
					}
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("guest/my.html");
		}
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("guest")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("guest/show.html");
		}
		 
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("guest")->selectRow(array("where"=>"id={$id}"));
				if($data['userid']!=M("login")->userid){
					$this->goAll("您无权限修改");
				}
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("guest/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$checkcode=post('checkcode','j');
			if(isset($_POST['checkcode']) && $checkcode!=$_SESSION['checkcode']){
				$this->goall($this->lang['checkcode_error'],1);
			}
			$data=M("guest")->postData();
			if(isset($_POST['title'])){
				$data["title"]=post("title","h");
				if(empty($data["title"])){
					$this->goall("主题不能为空！",1);
				}
			}
			 
			$data["userid"]=M("login")->userid;
			 
			if(isset($_POST['email'])){
				if( !is_email(post('email'))){
					$this->goall("请正确输入邮箱",1);
				}
			}
			 
			if(isset($_POST['telephone'])){
				if(preg_match("/^\d{11}$/",post('telephone'))==false){
					$this->goall("请正确输入手机号码",1);
				}
			}
			 
			$data["dateline"]=time();
			
			if(isset($_POST['content'])){
				
				if(empty($data["content"])){
					$this->goall("内容不能为空！",1);
				}
			
			}
			 
			if($id){
				M("guest")->update($data,"id=".$id);
			}else{
				M("guest")->insert($data);
			}
			
			
			$this->goall("保存成功",0);
		}
		
		 
		public function onDelete(){
			$id=get_post('id',"i");
			$row=M("guest")->selectRow("id=".$id);
			if($row["userid"]!=$this->userid){
				$this->goAll("暂无权限",1);
			}
			M("guest")->delete("id=".$id);
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>