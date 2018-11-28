<?php
class categoryModel extends model{
	public $base;
	
	function __construct(&$base){
		parent::__construct($base);
		$this->table="category";
	}
	/**
	*获取模板
	*catid 分类id
	* type 1列表2分类
	*/
	public function getTpl($catid,$type=1){
		$catid=intval($catid);
		$data=$this->selectRow("catid=$catid");
		switch($type){
			case 1:
				if($data['list_tpl']){
					return $data['list_tpl'];
				}else{
					if($data['pid']){
						return self::getTpl($data['pid'],$type);
					}
				}
				break;
			case 2:
				if($data['show_tpl']){
					return $data['show_tpl'];
				}else{
					if($data['pid']){
						return self::getTpl($data['pid'],$type);
					}
				}
				break;
				
		
		}
	}
	/*增加主题数*/
	public function add_topic_num($catid,$num){
		$catid=intval($catid);
		$data=$this->selectRow("catid=$catid");
		$this->update(array("topic_num"=>$data['topic_num']+1),"catid=".$catid);
		if($data['pid']){
			return self::add_topic_num($data['pid'],$num);
		}
	}
	
	/*更新最后发表的主题*/
	public function update_new_topic($catid,$last_post){
		$catid=intval($catid);
		$data=$this->selectRow("catid=$catid");
		$this->update(array("topic_num"=>$data['topic_num']+1,"last_post"=>addslashes(json_encode($last_post))),"catid=".$catid);
		if($data['pid']){
			return self::update_new_topic($data['pid'],$last_post);
		}
	}
	
	/*更新最后发表的帖子*/
	public function update_comment_num($catid,$num){
		$catid=intval($catid);
		$num=intval($num);
		$data=$this->selectRow("catid=$catid");
		$this->update(array("comment_num"=>$data['comment_num']+$num),"catid=".$catid);
		if($data['pid']){
			return self::update_comment_num($data['pid'],$num);
		}
	}
	
	public function id_title($option){
		if(!isset($option['order'])){
			$option['order']=" orderindex ASC";
		}
		$data=$this->select($option);
		if($data){
			foreach($data as $k=>$v){
				$ndata[$v['catid']]=$v['cname'];
			}
		}
		return $ndata;
	}
	
 
	
	public function children($pid=0,$tablename='',$status=0){
		$pid=intval($pid);
		$tablename=sql($tablename);
		$status=intval($status);
		$cache_key="category_children_".$tablename."_".$status."_".$pid;
		 
		if($d=cache()->get($cache_key)) return $d;
		$where="   status in(0,1,2) ";
		if($tablename){
			$where.=" AND tablename='".$tablename."' ";
		}
		if($status){
			$where.=" AND status=$status ";
		}
		$c_1=$this->select(array(
			"where"=>$where." AND pid=".$pid,
			"order"=>"orderindex asc",
			"fields"=>"catid,cname,logo"
		));
		if($c_1){
			foreach($c_1 as $k=>$v){
				$v['last_post']=json_decode($v['last_post'],true);
				$v['logo']=IMAGES_SITE($v['logo']);
				$c_1[$k]=$v;
				$c_2[$k]=$v;
				$c_2=$this->select(array(
					"where"=>$where."  AND pid=".$v['catid'],
					"order"=>"orderindex asc",
					"fields"=>"catid,cname,logo"
				));
				
				if($c_2){
					foreach($c_2 as $k_2=>$v_2){
						$c_3=$this->select(array(
							"where"=>$where." AND pid=".$v_2['catid'],
							"order"=>"orderindex asc",
							"fields"=>"catid,cname,logo"
						));
						if($c_3){
							foreach($c_3 as $k_3=>$v_3){
								$v_3['last_post']=json_decode($v_3['last_post'],true);
								$v_3['logo']=IMAGES_SITE($v_3['logo']);
								$c_3[$k_3]=$v_3;
							}
							
						}
						$v_2['logo']=IMAGES_SITE($v_2['logo']);
						$v_2['last_post']=json_decode($v_2['last_post'],true);
						$c_2[$k_2]=$v_2;
						$c_2[$k_2]['child']=$c_3;
					}
				}
				
				$c_1[$k]['child']=$c_2;
			}
		}
		cache()->set($cache_key,$c_1,30);
		return $c_1;	
		 
	}
	
	public function getList($option,$child=true){
		$cat=$this->select($option);
		if(!$child) return $cat;
		if($cat){
			foreach($cat as $k=>$c){
				$cat[$k]['child']=$this->select(array("where"=>array("pid"=>$c['catid'],"status<"=>99),"order"=>" orderindex asc"));
				if($cat[$k]['child']){
					foreach($cat[$k]['child'] as $kk=>$cc){
						$cat[$k]['child'][$kk]['child']=$this->select(array("where"=>array("pid"=>$cc['catid'],"status<"=>99),"order"=>" orderindex asc"));
					}
				}
			}
		}
		return $cat;
	}
	
	public function cat_child($catid){
		return $this->select(array("where"=>array("pid"=>intval($catid)),"order"=>" orderindex asc"));
	}
	public function get($catid){
		return $this->selectRow(array("where"=>array("catid"=>$catid)));
	}
	 
	
	public function id_family($id=0){
		$id=intval($id);
		$ids[]=$id;
		$ids1=$this->selectCols(array("where"=>" pid=".$id."  ","fields"=>"catid"));
		if($ids1){
			$ids=array_merge($ids,$ids1);
			$ids2=$this->selectCols(array("where"=>" pid in("._implode($ids1).") ","fields"=>"catid"));
			if($ids2){
				$ids=array_merge($ids,$ids2);
				$ids3=$this->selectCols(array("where"=>" pid in("._implode($ids2).") ","fields"=>"catid"));
				if($ids3){
					$ids=array_merge($ids,$ids3);
				}
			}
		}
		return $ids;
		
	}
	
	 
	
	
}

?>