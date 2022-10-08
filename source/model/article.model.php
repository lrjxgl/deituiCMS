<?php
class articleModel extends model{
	public $table="article";
	public function __construct(){
		parent::__construct ();
	}
	
	public function Dselect($option,&$rscount=false){
		if(!isset($option["fields"])){
			$option["fields"]="id,title,love_num,view_num,comment_num,fav_num,imgsdata,status,imgurl,description";
		}
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
	
	public function getListByCatid($catid,$fields="id,title,imgurl,description"){
		$cids=M("category")->id_family($catid);
		$list=$this->Dselect(array(
			"where"=>" catid in("._implode($cids).") ",
			"fields"=>$fields
		));
		return $list;
	}
	
	public function recList($catid,$limit=10){
		$where=" is_recommend=1 ";
		if($catid){
			$cids=M("category")->id_family($catid);
			$where.=" AND catid in("._implode($cids).") ";
		}
		$option=array(
			"where"=>$where,
			"limit"=>$limit,
			"order"=>"id DESC"
		);
		return $this->Dselect($option);
	}
	
	public function get($id,$fields="id,title,imgurl,description"){
		$id=intval($id);
		$row=$this->selectRow(array(
			"where"=>"id=".$id,
			"fields"=>$fields
		));
		 
		if($row){
			$row["imgurl"]=images_site($row["imgurl"]);
		}
		return $row;
	}
	
	public function getListByIds($ids,$fields="*"){
		$ids=array_unique($ids);
		$res=$this->Dselect(array(
			"where"=>" id in("._implode($ids).") ",
			"fields"=>$fields
		));
		if($res){
			foreach($res as $rs){
				$list[$rs["id"]]=$rs;
			}
			return $list;
		}
	}
	
}
?>