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
			
			$url="/admin.php?m=article&a=default";
			$limit=20;
			$start=get("per_page","i");
			$type=get("type",'h');
			switch($type){
				case "new":
					$where=" status=0 ";
					$url.="&type=".$type;	
					break;
				case "pass":
					$where=" status=1 ";
					$url.="&type=".$type;	
					break;
				case "forbid":
					$where=" status=2 ";
					$url.="&type=".$type;	
					break;
				default:
					$where=" status in(0,1,2) ";
					break;
			}
			$s_recommend=get("s_recommend");
			switch($s_recommend){
				case 1:
						$where.=" AND is_recommend=1";
						$url.="&s_recommend=1";
					break;
				case 2:
						$where.=" AND is_recommend=0";
						$url.="&s_recommend=2";
					break;
			}
			$catid=get("catid","i");
			if($catid){
				$cids=M("category")->id_family($catid);
				$where.=" AND catid in("._implode($cids).") ";
			}
			$id=intval(get('id','i'));
			if($id){
				$where.=" AND id=$id";
			}
			$title=get_post('title','h');
			if($title){
				$where.=" AND title like '%{$title}%' ";
				$url.="&title=".urlencode($title);
			}
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			
			 
			$rscount=true;
			$data=M("article")->select($option,$rscount);
			if($data){
				foreach($data as $k=>$v){
					$catids[]=$v['catid'];					
				}
				$cats=M("category")->id_title(array(
					"where"=>" tablename='article' AND catid in("._implode($catids).") "
				));
				
				foreach($data as $k=>$v){
					$v['imgurl']=images_site($v['imgurl']);
					$v['cat_name']=$cats[$v['catid']];
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$catlist=M("category")->children(0,"article");
			$taglist=M("article_tags")->select(array(
				"where"=>" status=1"
			));
			$this->smarty->goassign(
				array(
				"catlist"=>$catlist,
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"taglist"=>$taglist
				)
			);
			$this->smarty->display("article/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			$imgsdata=array();
			if($id){
				$data=M("article")->selectRow(array("where"=>"id={$id}"));
				$data['content']=M("article_data")->selectOne(array(
					"where"=>" id=".$id,
					"fields"=>"content"
				));
				$data["true_videourl"]=images_site($data["videourl"]);
				if(!empty($data['imgsdata'])){
					$imgs=explode(",",$data['imgsdata']);
					foreach($imgs as $v){
						$imgsdata[]=array(
							"trueimgurl"=>images_site($v),
							"imgurl"=>$v
						);
					}
				}
			}
			$catlist=M("category")->children(0,"article");
			$this->smarty->goassign(array(
				"data"=>$data,
				"catlist"=>$catlist,
				"imgsdata"=>$imgsdata
			));
			$this->smarty->display("article/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$content=post("content","x");
			$data=M("article")->postData();
			
			 
			$data["status"]=1;
			if($id){
				M("article")->update($data,"id='$id'");
				M("article_data")->update(array(
					"content"=>$content
				),"id=".$id);
			}else{
				$data['createtime']=date("Y-m-d H:i:s");
				$id=M("article")->insert($data);
				M("article_data")->insert(array(
					"content"=>$content,
					"id"=>$id
				));
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$row=M("article")->selectRow("id=".$id);
			if($row["status"]==1){
				$status=2;
			}else{
				$status=1;
			}
			M("article")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0,$status);
		}
		public function onRecommend(){
			$id=get('id','i');
			$row=M("article")->selectRow("id=".$id);
			if($row["is_recommend"]==1){
				$status=0;
			}else{
				$status=1;
			}
			M("article")->update(array("is_recommend"=>$status),array("id"=>$id));	
			$this->goall("状态修改成功",0,$status); 
		}
		public function onDelete(){
			$id=get_post('id',"i");
			M("article")->update(array("status"=>99),"id=$id");
			$this->goall("删除成功",0);
		}
		
		 
		public function onCategory(){
			$ids=post('ids','i');
			$catid=post('catid','i');
			if(!$catid) $this->goall("请选择分类",1);
			if($ids){
				foreach($ids as $id){
					M("article")->update(array("catid"=>$catid),"id=".$id);
				}
			}
			$this->goall("修改成功");
		}
		
		public function onTags(){
			$ids=post('ids','i');
			$tagid=post("tagid","i");
			if(!$tagid){
				$this->goAll("请选择归类",1);
			}
			if(empty($ids)){
				$this->goAll("请选择产品",1);
			}
			$hasids=M("article_tags_index")->selectCols(array(
				"where"=>" tagid=".$tagid." AND objectid in("._implode($ids).") ",
				"fields"=>"objectid"
			));
			$newids=$ids;
			if($hasids){
				$newids=array_diff($ids,$hasids);
			}
			if(!empty($newids)){
				foreach($newids as $objectid){
					M("article_tags_index")->insert(array(
						"tagid"=>$tagid,
						"objectid"=>$objectid,
						"orderindex"=>11
					));
				}
			}
			$this->goAll("success");
		}
		
		public function onDelAll(){
			$ids=post('ids','i');
			if($ids){
				foreach($ids as $id){
					$id=intval($id);
					M("article")->update(array("status"=>11),"id=".$id);
				}
			}
			$this->goAll("删除成功");
		}
		
		
	}

?>