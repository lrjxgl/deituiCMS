<?php
class forum_groupModel extends model{
	public $table="mod_forum_group";
	public function __construct(){
		parent::__construct();
	}
	public function Dselect($option=array(),&$rscount=false){
		$data=$this->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$v['imgurl']=images_site($v['imgurl']);
				$data[$k]=$v;
			}
		}
		return $data;
	}
	
	public function getListByIds($ids=array(),$fields="gid,title,imgurl,view_num,topic_num,comment_num,description"){
		$res=$this->select(array(
			"where"=>" gid in("._implode($ids).")",
			"fields"=>$fields
		));
		$data=array();
		if($res){
			foreach($res as $rs){
				$data[$rs['gid']]=$rs;
			}
		}
		return $data;
	}
	
	 
}
?>