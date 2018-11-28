<?php 
class permissionControl extends skymvc{
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$data=M("permission")->select(array("order"=>"id desc"));
		$this->smarty->assign(
			array(
				"data"=>$data,
			)
		);
		$this->smarty->display("permission/index.html");
	}
	
	public function onAdd(){
		
		$id=get_post('id','i');
		if($id){
			$this->smarty->assign("data",M("permission")->selectRow(array("where"=>array('id'=>$id))));
		}
		$this->smarty->display("permission/add.html");
	}
	
	public function onSave(){
		$id=get_post('id','i');
		$data['m']=post('m','h');
		$data['access']=post('access','h');
		$data['title']=post('title','h');
		if($id){
			M("permission")->update($data,array("id"=>$id));
			$this->goall("修改成功");
		}else{
			M("permission")->insert($data);
			$this->goall("保存成功"); 
		}
	}
	
	public function onDelete(){
		$id=get('id','i');
		M("permission")->delete(array("id"=>$id));
		$this->goall("删除成功"); 
	}
	
	public function onSaveConfig(){
		set_time_limit(0);
		$data=M("permission")->select(array(
		"where"=>"1=1",
		"order"=>"title asc"
		));
		
		if($data){
			foreach($data as $k=>$v){
				$permission[$v['m']][]=array("title"=>$v['title'],"access"=>$v['access']);
			}
		}
		$str="<?php";
		if($permission){
			foreach($permission as $k=>$v){
				$str.="\r\n\$config['$k']=array(\r\n";
				
				foreach($v as $d){
				$str.="      array('title'=>'{$d['title']}','access'=>'{$d['access']}'),\r\n";
				}
				
				$str.="\r\n);\r\n";
			}
		}
		$str.="?>";
		file_put_contents(ROOT_PATH."config/permission.php",$str);
		$this->goall("权限配置生成成功"); 
	}
	
	public function onGetPermission(){
		$dir=ROOT_PATH."source/admin";
		$dh=opendir($dir);
		while($file=readdir($dh)){
			if($file!="." && $file!=".."){
				$temp=$dir."/".$file;
				$data=file_get_contents($temp);
				preg_match_all("/function on(\w+)\(/i",$data,$arr);
				if(isset($arr[1])){
					$m=substr($file,0,strpos($file,"."));
					$access="";
					foreach($arr[1] as $k=>$v){
						if($k==0){
							$access .=$v;
						}else{
							$access .=",".$v;
						}
						
					}
					if(!M("permission")->selectRow(array('where'=>"m='".$m."'"))){
						M("permission")->insert(array(
							'm'=>$m,
							'access'=>strtolower($access), 
							'title'=>$file,
							
						));
					}
				}
			}
		}
		
		$this->goall("权限生成成功");
	}
	
}
?>