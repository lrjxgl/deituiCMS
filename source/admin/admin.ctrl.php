<?php
class adminControl extends skymvc{
	 
	public function __construct(){
		parent::__construct();
	  
	 
	}
	
	public function onDefault(){
		$grouplist=M("admin_group")->grouplist();
 		$where="1=1";
		$data=M("admin")->select(array("where"=>$where));
		$this->smarty->assign(
			array(
				"adminlist"=>$data,
				"grouplist"=>$grouplist
			)
		);
		$this->smarty->display("admin/index.html");
	}
	
	public function onAdd(){
		$id=get_post('id','i');
		$grouplist=M("admin_group")->select(array("where"=>"1=1"));
		if($id){
			$data=M("admin")->selectRow(array("where"=>array("id"=>$id)));				
			$this->smarty->assign("data",$data);
		}
		$this->smarty->assign(
			array(
				"grouplist"=>$grouplist,
			)
		);
		$this->smarty->display("admin/add.html");
	}
	
	
	
	public function onSave(){
		$username=post('username','h');
		$password=post('password','h');
		 
		$password2=post('password2','h');
		if($password!=$password2){
			$this->goall("两次输入密码不一致",1);
		}
		 
		
		if(M("admin")->selectRow(array("where"=>array('username'=>$username)))){
			$this->goall("管理员已经存在",1);
		}
		$data['username']=$username;
	 
		$data['salt']=$salt=rand(1000,9999);
		$data['password']=umd5($password.$salt);
		$data['group_id']=post('group_id');
	 
		M("admin")->insert($data);
		$this->goall("保存成功");
	}
	
	public function onEdit(){
		$id=get_post('id','i');
		$data=M("admin")->selectRow(array("where"=>array("id"=>$id)));
		if(empty($data)) $this->goall($this->lang['admin_no_exist'],1,0,APPADMIN."?m=admin");
		if(get('op')=='db'){
			$password=post('password');
			$password2=post('password2');
			$group_id=post('group_id','i');
			if($password){
				if($password!=$password2){
					$this->goall("两次输入密码不一致",1);					
				}
				$newdata['password']=umd5($password.$data['salt']);
			}
			$newdata['group_id']=$group_id;
			 
			M("admin")->update($newdata,array("id"=>$id));
			$this->goall("保存成功");
		}
		
		$grouplist=M("admin_group")->select(array("where"=>" 1=1 "));
		$this->smarty->assign(
			array(
				"grouplist"=>$grouplist,
				"data"=>$data,
			)
		);
		
		$this->smarty->display("admin/edi.html");
	}
	
	public function onDel(){
		$id=get('id','i');
		M("admin")->delete(array("id"=>$id));
		echo json_encode(array("error"=>0,"message"=>$this->lang['delete_success']));
	}
	
	 
	
	 
	
}

?>