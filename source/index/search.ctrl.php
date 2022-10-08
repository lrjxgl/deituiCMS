<?php
class searchControl extends skymvc{
	public function onDefault(){
		
		$this->smarty->display("search/index.html");
	}
	
	public function onArticle(){
		$where=" status=1 ";
		$url="/index.php?m=article&a=default";
		$limit=24;
		$start=get("per_page","i");
		$catid=get('catid','i');
		$w="";
		if($catid){
			$cids=M("category")->id_family($catid);
			if($cids){
				$w.=" AND catid in(".implode(",",$cids).") ";
			}else{
				$w.=" AND 1=2 ";
			}
		}
		$where.=$w;
		$keyword=get("keyword","h");
		if(!empty($keyword)){
			$where.=" AND title like '%".$keyword."%' ";
		}
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$rscount=true;
		$data=M("article")->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$v["imgurl"]=images_site($v["imgurl"]);
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$catlist=M("category")->children(0,"article");
		$per_page=$start+$limit;
		$per_page=$per_page>=$rscount?0:$per_page;
		$seo=M("seo")->get("article");
		$this->smarty->goassign(
			array(
				"seo"=>$seo,
				"list"=>$data,
				"pagelist"=>$pagelist,
				"rscount"=>$rscount,
				"catlist"=>$catlist,
				"per_page"=>$per_page,
				"url"=>$url
			)
		);
	}
}