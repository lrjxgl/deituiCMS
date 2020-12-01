<?php
class b2c_categoryModel extends model{
	public $table="mod_b2c_category";
	public function __construct(&$base){
		parent::__construct($base);
	}
	public function getListByIds($ids){
		$rss=$this->select(array(
			"where"=>" catid in("._implode($ids).") "
		));
		if($rss){
			$data=array();
			foreach($rss as $rs){
				$data[$rs["catid"]]=$rs;
			}
			return $data;
		}
	}
	public function children($pid=0,$status=1){
		if($status){
			$where=" status=1 ";
		}else{
			$where=" status in(0,1,2) ";
		}
		//$where.=" AND pid=".$pid;
		$option=array(
			"where"=>$where,
			"order"=>" orderindex DESC"
		);
		$rss=M("mod_b2c_category")->select($option,$rscount);
		if($rss){
			$child=array();
			foreach($rss as $rs){
				 
				$rs["imgurl"]=images_site($rs["imgurl"]);
				if($rs["pid"]==0){
					$catlist[$rs["catid"]]=$rs;
				}else{
					$child[$rs["pid"]][]=$rs;
				}
			}
			
			foreach($catlist as $k=>$v){
				$v["child"]=$child[$v["catid"]];
				$catlist[$k]=$v;
			}
		}
		
		if($pid){
			return $catlist[$pid]["child"];
		}
		return $catlist;
	}
	
	public function id_family($id=0){
		$id=intval($id);
		$ids[]=$id;
		$ids1=$this->selectCols(array("where"=>" pid=".$id."  ","fields"=>"catid"));
		if($ids1){
			$ids=array_merge($ids,$ids1);
			
		}
		return $ids;
		
	}
	
	public function parseType($data){
		if(empty($data)){
			return false;
		}
		$arr=explode("\r\n",$data);
		$list=array();
		foreach($arr as $v){
			if(!empty($v)){
				$ev=explode("=",$v);
				if(!empty($ev[1])){
					$list[intval($ev[0])]=htmlspecialchars($ev[1]);
				}
			}
		}
		if(empty($list)){
			return false;
		}else{
			return $list;
		}
	}
}

?>