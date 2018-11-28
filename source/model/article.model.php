<?php
class articleModel extends model{
	public $table="article";
	public function __construct(&$base=null){
		parent::__construct($base);
	}
	
	public function Dselect($option,&$rscount=false){
		$data=$this->select($option,$rscount);
		 
		if($data){
			foreach($data as $v){
				$catids[]=$v['catid'];
			}
			$cats=M("category")->id_title(array(
				"where"=>" catid in("._implode($catids).")"
			));
			foreach($data as $k=>$v){
				$v['catid_name']=$cats[$v['catid']]; 
				$v['imgurl']=images_site($v['imgurl']);
				$v['timeago']=timeago(strtotime($v['createtime']));
				$data[$k]=$v;
			} 
		}
		
		return $data;
	}
}
?>