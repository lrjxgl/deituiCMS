<?php
class navbarModel extends model{
	public $base=NULL;
	public function __construct (){
		parent::__construct ();
		 
		$this->table="navbar";	
	}
	public function navlist($gid,$pid=0){
		$option=array(
			"where"=>array("group_id"=>$gid,"pid"=>$pid,"status"=>1),
			"order"=>"orderindex asc"
		);
		$res=$this->select($option);
		if($res){
			foreach($res as $k=>$rs){
				$rs["logo"]=images_site($rs["logo"]);
				$res[$k]=$rs;
			}
		}
		return $res;
		
	}
	
	public function getTarget(){
		return array(
			"_blank"=>"新窗口",
			"main-frame"=>"右窗口",
			"menu-frame"=>"做窗口",
			"_self"=>"当前窗口",
		);
		
	}
	
	/*导航条分组*/
	public function getGroup(){
		return array(
			1=>"后台顶部", 
			2=>"后台左边", 
			4=>"wap", 
			14=>"uniApp", 	 
			7=>"wap用户",
			17=>"uniApp用户",
			
		 
			
		);
	}
	/***根据组获取所有导航**/
	public function getListByGroup($gid){
		$res=$this->select(array(
			"where"=>" group_id=".$gid." AND status=1 ",
			"order"=>" orderindex ASC"
		));
		if($res){
			$data=array();
			$child=array();
			foreach($res as $rs){
				if($rs["pid"]==0){
					$data[]=$rs;
				}else{
					$child[$rs["pid"]][]=$rs;
				}
			}
			foreach($data as $k=>$v){
				$v["child"]=$child[$v["id"]];
				$data[$k]=$v;
			}
			return $data;
		}
	}
}
?>