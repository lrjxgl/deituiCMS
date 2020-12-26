<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class favModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="fav";
	}
	
	public function getListByUser($userid,$tablename='shop'){
		$where=" userid=".$userid;
		if($tablename){
			$where.=" AND tablename='".$tablename."' ";
		}
		$data=$this->select(array(
			"where"=>$where
		));
		if($data){
			foreach($data as $k=>$v){
				$v=$this->getByTable($v['tablename'],$v['object_id']);
				if(empty($v)){
					unset($data[$k]);;
				}else{
					$data[$k]=$v;
				}
				
			}
		}
		
		return $data;
	}
	
	public function getByTable($tablename,$id){
		switch($tablename){
			case "shop":
					$row=M($tablename)->selectRow(array(
						"where"=>" status=2 AND shopid=".$id,
						"fields"=>"shopid,shopname,logo,catid"
						 
					));
					if(empty($row)) return false;
					return array(
						"shopid"=>$row['shopid'],
						"tablename"=>$tablename,
						"shopname"=>$row['shopname'],
						"logo"=>images_site($row['logo']),
						"url"=>"/index.php?m=shop&shopid=".$id,
						"catid"=>$row['catid']
					);
				break;
		}
		
	}
}

?>