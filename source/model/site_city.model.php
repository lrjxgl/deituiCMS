<?php
class site_cityModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="site_city";
	}
	
	public function sc_id(){
		/*if(get('sc_id')){
			$sc_id=get('sc_id','i');
			setcookie("ck_sc_id",$sc_id,time()+36000000,"/",DOMAIN);
		}else{
			$sc_id=intval($_COOKIE['ck_sc_id']);
		}
		*/
		$sc_id=get('sc_id','i');
		return $sc_id;
	}
	
	public function siteList($status=0){
		$where="1 ";
		$status && $where=" status=".$status;
		$data=$this->select(array(
			"where"=>$where,
			"order"=>"orderindex ASC"
			
		));
		if($data){
			foreach($data as $v){
				$newdata[$v['sc_id']]=$v['title'];
			}
			return $newdata;
		}
	}
	
	public function children($pid,$status=0){
		$where=" siteid=".SITEID." AND pid=".$pid."";
		if($status){
			$where.=" AND status=".$status;
		}
		$data=$this->select(array(
			"where"=>$where,
			"order"=>"orderindex ASC"
			
		));
		if($data){
			foreach($data as $k=>$v){
				$w="pid=".$v['sc_id']."";
				if($status){
					$w.=" AND status=".$status;
				}
				$v['child']=$this->select(array(
						"where"=>$w,
						"order"=>"orderindex ASC"
						
				));
				$data[$k]=$v;
			}
		}
		return $data;
		
	}
	
	public function id_title($option=array("where"=>" 1=1 ")){
		$data=$this->select($option);
		foreach($data as $v){
			$ndata[$v['sc_id']]=$v['title'];
			
		}
		return $ndata;
	}
	
	public function id_list($option=array("where"=>" 1=1 ")){
		$data=$this->select($option);
		foreach($data as $v){
			$ndata[$v['sc_id']]=$v;
			
		}
		return $ndata;
	}
	
	
	public function	getListByIds($ids){
		if(empty($ids)) return false;
		$data=$this->select(array(
			"where"=>"sc_id in("._implode($ids).")"
		));
		foreach($data as $v){
			$ndata[$v['sc_id']]=$v['title'];
			
		}
		return $ndata;
	}
	public function id_family($sc_id=0){
		$sc_id=intval($sc_id);
		$ids[]=$sc_id;
		$ids1=$this->selectCols(array("where"=>" pid=".$sc_id." ","fields"=>"sc_id"));
		if($ids1){
			$ids=array_merge($ids,$ids1);
			$ids2=$this->selectCols(array("where"=>" pid in("._implode($ids1).") ","fields"=>"sc_id"));
			if($ids2){
				$ids=array_merge($ids,$ids2);
				$ids3=$this->selectCols(array("where"=>" pid in("._implode($ids2).") ","fields"=>"sc_id"));
				if($ids3){
					$ids=array_merge($ids,$ids3);
				}
			}
		}
		return $ids;
		
	}
}

?>