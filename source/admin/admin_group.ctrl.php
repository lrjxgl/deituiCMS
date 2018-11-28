<?php
class admin_groupControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	 
	}
	
	public function onDefault(){
		$zulist=M("admin_group")->select(array("order"=>" id DESC","where"=>"1=1"));
		$this->smarty->assign("zulist",$zulist);
		$this->smarty->display("admin_group/index.html");
		
	}
	
	public function onAdd(){
		if(file_exists(ROOT_PATH."config/permission.php")){
			include ROOT_PATH."config/permission.php";
		}else{
			file_put_contents(ROOT_PATH."config/permission.php",'<?php
			?>');
		}
		$permission=$config;
		$id=intval(get('id','i'));
		if($id){
			$zu=M("admin_group")->selectRow(array("where"=>array('id'=>$id)));
			$zups=unserialize($zu['content']);
			$this->smarty->assign("zu",$zu);
		}
		if($permission){
			foreach($permission as $key=>$val)
			{
				$tmparr=array();
				$chk="";
				$str.="<tr>";
				$str.="<td align='right'>".$key."：</td>";
				$str.="<td>";
				if($zups[$key])
				{
					
					foreach($zups[$key] as $t)
					{
						$tmparr=array_merge($tmparr,array($t)) ;
					}
					
				}
				foreach($val as $k=>$v){
					
					$chk="";
					if($tmparr){	
						if(in_array($v['access'],$tmparr))
						{
							$chk=" checked='checked' ";
						}
					}
					
					$str.= " <input type='checkbox' name='ps[".$key."][]' class='percheck' value='".$v['access']."' ".$chk." > ".$v['title']; 
				}
				$str.="</td>";
				$str.= "</tr>";
			}
		}
		$this->smarty->assign("str",$str);
		$this->smarty->display("admin_group/add.html");
	}
	
	
	public function onSave(){
		
		$id=get_post('id','i');			
		$p=array();
		$title=post('title','h');
		if(empty($title))
		{
			$this->goall($this->lang['admin_group_unempty'],1);
		}
		$ps=post('ps','h');
		if($ps)
		{
			foreach($ps as $key=>$arr)
			{				
				foreach($arr as $k=>$v)
				{
					$p[$key][]=$v;
				}
				
			}
		}
		$data['title']=$title;
		$data['content']=serialize($p);
		
		if($id){
			M("admin_group")->update($data,array("id"=>$id));
		}else{
			 
			M("admin_group")->insert($data);
		}
		$this->goall($this->lang['edit_success']);
		
	}
	
	
	public function onDelete(){
		$id=get('id','i');
		if($id<10){
			echo json_encode(array("error"=>1,"message"=>"默认管理组不可删除"));
		}else{
		M("admin_group")->delete(array("id"=>$id));
			echo json_encode(array("error"=>0,"message"=>$this->lang['delete_success']));
		}
	}
	
}

?>