<?php
class districtModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="district";
	}
	/*获取区域 k=>v 形式*/
	public function dist_list($option,&$rscount=false,$cache=false,$cache_time=0){
		$data=$this->select($option,$rscount,$cache,$cache_time);
		if($data){
			foreach($data as $k=>$v){
				$ndata[$v['id']]=$v['name'];
			}
			return $ndata;
		}
		return false;
	}
	
	public function getTitle($id){
		return $this->selectOne(array("where"=>"id=".intval($id),"fields"=>"name"));
	}
	
	public function children($pid){
		$data=$this->select(array("where"=>"upid=".$pid));
		if($data){
			foreach($data as $k=>$v){
				$child=$this->select(array("where"=>"upid=".$v['id']));
				if($child){
					foreach($child as $kk=>$vv){
						$children=$this->select(array("where"=>"upid=".$vv['id']));
						if($children){
						$child[$kk]['children']=$children;
						}
					}
				}
				$data[$k]['child']=$child;
			}
		}
		return $data;
	}
	
	public function id_family($id=0){
		$id=intval($id);
		$ids[]=$id;
		$ids1=$this->selectCols(array("where"=>" upid=".$id."  ","fields"=>"id"));
		if($ids1){
			$ids=array_merge($ids,$ids1);
			$ids2=$this->selectCols(array("where"=>" upid in("._implode($ids1).") ","fields"=>"id"));
			if($ids2){
				$ids=array_merge($ids,$ids2);
				$ids3=$this->selectCols(array("where"=>" upid in("._implode($ids2).") ","fields"=>"id"));
				if($ids3){
					$ids=array_merge($ids,$ids3);
				}
			}
		}
		return $ids;
		
	}
}

?>