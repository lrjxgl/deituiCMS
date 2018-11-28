<?php
class navbarControl extends skymvc{
	
	function __construct(){
		parent::__construct();
 
		
	}

	
	public function onDefault(){
		$rscount=true;
		$where['pid']=0;
		$group_id=get_post('group_id','i');
		$group_id=$group_id?$group_id:2;
	 
		$where['group_id']=$group_id;
		$option=array(
			"where"=>$where,
			"order"=>" orderindex ASC",
		);
		$data=M("navbar")->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$v['child']=M("navbar")->select(array("where"=>array("pid"=>$v['id']),"order"=>" orderindex ASC"));
				$data[$k]=$v;
			}
		}
		$this->smarty->assign(
			array(
				"navlist"=>$data,
				"rscount"=>$rscount,
				"group_id"=>$group_id,
				"group_list"=>M("navbar")->getGroup(),
			)
		);
		$this->smarty->display("navbar/index.html");
	}
	
	public function onAdd(){
		$id=get_post('id','i');
		$pid=get_post('pid','i');
		if($id){
			$data=M("navbar")->selectRow(array("where"=>array("id"=>$id)));
			$pid=$data['pid'];
		}
		if($pid){
			$parent=M("navbar")->selectRow(array("where"=>array("id"=>$pid)));
		}
		$this->smarty->assign(
			array(
				"nav"=>$data,
				"group_list"=>M("navbar")->getGroup(),
				"parent"=>$parent,
			)
		);
		$this->smarty->display("navbar/add.html");
	}
	
	public function onSave(){
		$id=get_post('id','i');
		$data['pid']=$pid=post('pid','i');
		if($pid){
			$parent=M("navbar")->selectRow(array("where"=>array("id"=>$pid)));
			$data['group_id']=$parent['group_id'];
		}else{
			$data['group_id']=post('group_id');
		}
		$data['title']=post('title','h');
		$data['orderindex']=post('orderindex');
		$data['link_url']=post('link_url','h');
		$data['target']=post('target','h');
		$data['m']=post('m','h');
		$data['a']=post('a','h');
		$data['icon']=post("icon",'h');
		$data['logo']=post('logo','h');
		if($id){
			M("navbar")->update($data,array("id"=>$id));
		}else{
			M("navbar")->insert($data);
		}
		$this->goall("保存成功");
	}
	
	public function onDelete(){
		$id=get_post('id','i');
		$data=M("navbar")->selectRow(array("where"=>array("pid"=>$id)));
		if($data){
			exit(array("error"=>1,"message"=>$lang['delete_wrong_child']));
		} 
		M("navbar")->delete(array("id"=>$id));
		exit(json_encode(array("error"=>0,"message"=>$lang['delete_success'])));
	}
	
	public function onOrder(){
		$ids=post('id','i');
		$orderindexs=post('orderindex','i');
		foreach($ids as $k=>$id){
			M("navbar")->update(array("orderindex"=>intval($orderindexs[$k])),array("id"=>intval($id)));
		}
		$this->goall("保存成功");
	}
	
	public function onStatus(){
		$id=get('id','i');
		$status=get('status','i');
		M("navbar")->update(array("status"=>$status),array("id"=>$id));
		echo json_encode(array("error"=>0,"message"=>$this->lang['save_success']));	 
	}
	
}
?>