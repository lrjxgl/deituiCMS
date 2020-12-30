<?php
class forumModel extends model{
	public $table="mod_forum";
	public function __construct(){
		parent::__construct();
	}
	
	public function id_list($option){
		$data=$this->select($option);
		if($data){
			foreach($data as $k=>$v){
				$t[$v['id']]=$v;
			}
			return $t;
		}
		return false;
	}
	public function getListByIds($ids){
		$ids=array_unique($ids);
		$res=$this->Dselect(array(
			"where"=>" id in("._implode($ids).") "
		));
		if($res){
			foreach($res as $rs){
				$list[$rs["id"]]=$rs;
			}
			return $list;
		}
	}
	public function Dselect($option=array(),&$rscount=false){
		$data=$this->select($option,$rscount);
		$catlist=M("mod_forum_category")->select(array(
			"where"=>"  status=2 ",
			"order"=>" orderindex ASC",
		)); 
		if($catlist){
			foreach($catlist as $v){
				$cats[$v['catid']]=$v;
			}
		}
		if($data){
			foreach($data as $v){
				$uids[]=$v['userid'];
				$gids[]=$v['gid'];
			}
			$gs=MM("forum","forum_group")->getListByIds($gids);
			$us=M("user")->getUserByIds($uids); 
			foreach($data as $k=>$v){
				$v['cname']=$cats[$v['catid']];
				$v['imgurl']=images_site($v['imgurl']);
				$v['nickname']=$us[$v['userid']]['nickname'];
				$v['user_head']=images_site($us[$v['userid']]['user_head']);
				$v['timeago']=timeago($v['dateline']);
				$v['group_title']=$gs[$v['gid']]['title'];
				if($v['imgsdata']){
					$imgs=explode(",",$v['imgsdata']);
					$imgslist=array();
					foreach($imgs as $img){
						$imgslist[]=images_site($img);
					}
					$v['imgslist']=$imgslist;
				}
				$data[$k]=$v;
			}
		}
		return $data;
	}
	
	public function recommendList($ops=array(),$limit=6){
		$where="  status=2 AND is_recommend=1 ";
		if(isset($ops['gid'])){
			$where.=" AND gid=".intval($ops['gid']);
		}
		if(isset($ops['catid'])){
			$where.="AND catid=".intval($ops['catid']);
		}
		$option=array(
			"where"=>$where,
			"limit"=>$limit,
			"order"=>"id DESC"
		);
		return $this->Dselect($option);
	}
	
}

?>