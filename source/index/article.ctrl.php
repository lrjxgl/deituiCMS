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
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("article")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("article/index.html");
		}
		
		public function onShow(){
			$id=get_post("id","i");
			$data=M("article")->selectRow(array("where"=>"id={$id}"));
			if(empty($data)){
				$this->goAll("文章不存在",1);
			}
			$data['timeago']=timeago(strtotime($data['createtime']));
			$cat=M("category")->selectRow("catid=".$data['catid']);
			$shopid=get("shopid","i");
			$userid=M("login")->userid;
			if($shopid){
				$shop=M("shop")->selectRow(array(
					"where"=>" shopid=".$shopid,
					"fields"=>"shopid,logo,shopname"
				));
				
				$shop['isfav']=0;
				if($userid){
					$fav=M("fav")->selectRow("tablename='shop' AND object_id=".$shopid." AND userid=".$userid);
					if($fav){
						$shop['isfav']=1;
					}
				}
				$shop['logo']=images_site($shop['logo']);
			}
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
			$fav=M("fav")->selectRow("tablename='article' AND userid=".$userid." AND object_id=".$id);
			if($fav){
				$isfav=1;
			}
			$seo=array(
				"title"=>$data['title'],
				"description"=>$data['description']
			);
			 
			$this->smarty->goAssign(array(
				"seo"=>$seo,
				"islove"=>$islove,
				"isfav"=>$isfav,
				"data"=>$data,
				"shop"=>$shop,
				"shopid"=>$shopid,
				"cat"=>$cat,
				"comment_object_id"=>$id,
				"comment_tablename"=>"article",
				"comment_f_userid"=>$data['shopid'],
				 
			));
			$this->smarty->display("article/show.html");
		}
		
	}

?>