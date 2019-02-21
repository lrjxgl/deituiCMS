<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class articleControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" status=2 ";
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
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"catlist"=>$catlist,
					"per_page"=>$per_page,
					"url"=>$url
				)
			);
			$this->smarty->display("article/index.html");
		}
		public function onList(){
			$where=" status=2  ";
			$type=get_post('type','h');
			$parent=$cat_2nd=$cat_3nd=array();
			$catid=get('catid','i');
			if($catid){	
				$cat=M("category")->selectRow(array("where"=>"catid=$catid"));
				$seo=array(
					"title"=>$cat['title'],
					"description"=>$cat['description']
				);
				$cat_top=$cat;
				if($cat['pid']){
					
					$parent=M("category")->selectRow(array("where"=>"catid=".$cat['pid']));
					if($cat['pid']){
						$parent=M("category")->selectRow(array("where"=>array("catid"=>$cat['pid'])));
						if($parent['pid']){
							$cat_2nd=$parent;
							$cat_top=M("category")->selectRow(array("where"=>array("catid"=>$parent['pid'])));
							$cat_3nd=$cat;
						}else{
							$cat_top=$parent;
							$cat_2nd=$cat;
						}			 
					}
					
				}
			
				$children=M("category")->children($catid);
				if(empty($children)){
					if($cat['level']>2){
						$children=M("category")->children($parent['catid']);
					}
				}
				$tpl=M("category")->getTpl($cat['catid'],1);
				$cids=M("category")->id_family($catid);
				if(!empty($cids)){
					$where.=" AND catid in("._implode($cids).") ";
				}else{
					$where.=" AND 1=2 ";
				}
			}
			
			$catlist=M("category")->children($catid,"article") ; 
			$rscount=true;
			
			
			$url="/index.php?m=list&catid=".$catid;
			
			$keyword=get('keyword','h');
			if($keyword){
				$where.=" AND title like '%".$keyword."%' ";
				$url.="&keyword=".urlencode($keyword);
			}
			
			$vtpl="article/list.html";
			$tpl=$tpl?$tpl:$vtpl;
			$orderby=get('orderby','h');
			$order=" id DESC";
			if($orderby){
				switch($orderby){
					 
					case "price":
							$order=" price ASC";
						break;
					case  "id":
							$order=" id DESC";
						break;
					case  "sold_num":
							$order=" sold_num DESC";
						break;

					default :
							$order=" id DESC";
						break;
				}
				$url.="&orderby=".$orderby;
			}
			$start=get_post('per_page','i');
			$limit=20;
			 
			$option=array(
				"where"=>$where,
				"start"=>$start,
				"limit"=>$limit,
				"order"=>$order
			);
			$data=M("article")->Dselect($option,$rscount);
			if($data){
				foreach($data as $k=>$v){
					$v["imgurl"]=images_site($v["imgurl"]);
					$data[$k]=$v;
				}
			} 
			$pagelist=$this->pagelist($rscount,$limit,$url);
		 	//end分页
			$per_page=$start+$limit;
			$per_page=$per_page>=$rscount?0:$per_page;
			$this->smarty->goassign(array(
				"list"=>$data,
				"rscount"=>$rscount,
				"pagelist"=>$pagelist,
				"catlist"=>$catlist,
				"per_page"=>$per_page,
				"cat"=>$cat,
				"children"=>$children,
				"parent"=>$parent,
				"cat_top"=>$cat_top,
				"cat_2nd"=>$cat_2nd,
				"cat_3nd"=>$cat_3nd,
				"seo"=>$seo
			));
			$this->smarty->display($tpl);
		}
		public function onShow(){
			$id=get_post("id","i");
			$data=M("article")->selectRow(array("where"=>"id={$id}"));
			if(empty($data)){
				$this->goAll("文章不存在",1);
			}
			$data["imgurl"]=images_site($data["imgurl"]);
			$data['timeago']=timeago(strtotime($data['createtime']));
			$cat=M("category")->selectRow("catid=".$data['catid']);
		 
			$userid=M("login")->userid;
			
			$data['content']=M("article_data")->selectOne(array(
				"where"=>" id=".$id,
				"fields"=>"content"
			));
			 
			//是否点赞
			$islove=0;
			$love=M("love")->selectRow("tablename='article' AND userid=".$userid." AND objectid=".$id);
			if($love){
				$islove=1;
			}
			//是否收藏
			$isfav=0;
			$fav=M("fav")->selectRow("tablename='article' AND userid=".$userid." AND objectid=".$id);
			if($fav){
				$isfav=1;
			}
			$seo=array(
				"title"=>$data['title'],
				"description"=>$data['description']
			);
			if(!empty($data['imgsdata'])){
				$imgs=explode(",",$data['imgsdata']);
				foreach($imgs as $v){
					$imgsdata[]=array(
						"trueimgurl"=>images_site($v),
						"imgurl"=>$v
					);
				}
			} 
			$this->smarty->goAssign(array(
				"seo"=>$seo,
				"islove"=>$islove,
				"isfav"=>$isfav,
				"data"=>$data,
				 
				"cat"=>$cat,
				"comment_objectid"=>$id,
				"comment_tablename"=>"article",
				"comment_f_userid"=>$data['shopid'],
				"imgsdata"=>$imgsdata 
			));
			$tpl="article/show.html";
			$tpl=$data['tpl']?$data['tpl']:$tpl;
		 
			$this->smarty->display($tpl);
		}
		public function onAddClick(){
			$id=get("id","i");
			M("article")->changenum("view_num",1,"id=".$id);
		}
	}

?>