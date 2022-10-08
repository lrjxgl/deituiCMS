<?php
class article_tagsModel extends model{
	public $table="article_tags";
	public function __construct(){
		parent::__construct();
	}
	
	public function Done($objectid,$tags){
		if(empty($tags)) return false;
		foreach($tags as $k=>$v){
			$tags[$k]=sql($v);
		}
		$indexlist=M("article_tags_index")->selectCols(array(
			"where"=>"objectid=".$objectid,
			"fields"=>"tagid"
		));
		$indexTags=$otags=array();
		if($indexlist){
			$otags=$this->select(array(
				"fields"=>"tagid,title",
				"where"=>" tagid in ("._implode($indexlist).")"
			));
			if($otags){
				foreach($otags as $v){
					$indexTags[]=$v['title'];
				}
			}
		}			
		$deleteIndex=array_diff($indexTags,$tags);
		
		if($deleteIndex){
			$delTagsId=array();
			foreach($otags as $v){
				if(in_array($v['title'],$deleteIndex)){
					$delTagsId[]=$v['tagid'];
				}
			}
			M("article_tags_index")->delete("objectid=".$objectid." AND tagid in("._implode($delTagsId).") ");
			$this->changenum("total_num",-1,"tagid in("._implode($delTagsId).") ");
		}
		//处理增加的
		$addIndex=array_diff($tags,$indexTags);
		
		//原有的标签
		$tagsall=$this->select(array(
			"fields"=>"tagid,title",
			"where"=>"title in ("._implode($tags).")"
		));
		$tagslist=array();
		if($tagsall){
			foreach($tagsall as $v){
				$tagslist[]=$v['title'];
			}
		}
		$insert=array_diff($tags,$tagslist);
		$update=array_diff($tagslist,$tags);
		$insertIndex=array();
		
		if(!empty($insert)){
			foreach($insert as $v){
				$tagid=$this->insert(array(
					"title"=>$v,
					 
					"total_num"=>1
				));
				$insertIndex[]=array(
					 
					"tagid"=>$tagid,
					"objectid"=>$objectid
				);
				 
			}
		}
		if(!empty($update)){
			//更新未在index中的标签
			$addIndex=array_diff($tags,$indexTags);
			if($addIndex){
				$addTagsId=array();
				foreach($otags as $v){
					if(in_array($v['title'],$addIndex)){
						$addTagsId[]=$v['tagid'];
						$insertIndex[]=array(
							 
							"tagid"=>$v['tagid'],
							"objectid"=>$objectid
						);
					}
				}
				if(!empty($addTagsId)){
					$this->changenum("total_num",1,"tagsid in("._implode($addTagsId).") ");
				}
				
			}
			
		}
		if(!empty($insertIndex)){
			M("article_tags_index")->insertMore($insertIndex);
		}
		 
	}
	
	public function getarticleByKey($gkey){
		$group=$this->selectRow(array(
			"where"=>" gkey='".sql($gkey)."' ",
			 "fields"=>"tagid,gnum"
		));
		if(!$group) return false;
		$data=M("article_tags_index")->select(array(
			"where"=>" tagid=".$group["tagid"],
			"limit"=>$group["gnum"],
			"order"=>" orderindex ASC,id DESC",
		));
		 
		if($data){
			foreach($data as $v){
				$proids[]=$v["objectid"];
			}
			$pros=M("article")->getListByIds($proids);
			foreach($data as $k=>$v){
				$v=$pros[$v["objectid"]];
				$data[$k]=$v;
			}
		}
		return $data;
	}
	
}

?>