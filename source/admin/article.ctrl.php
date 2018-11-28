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
					$where=" status=2 ";
					$url.="&type=".$type;	
					break;
				case "forbid":
					$where=" status=4 ";
					$url.="&type=".$type;	
					break;
				default:
					$where=" status in(0,1,2,4) ";
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
			$this->smarty->goassign(
				array(
				"catlist"=>$catlist,
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("article/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("article")->selectRow(array("where"=>"id={$id}"));
				$data['content']=M("article_data")->selectOne(array(
					"where"=>" id=".$id,
					"fields"=>"content"
				));
			}
			$catlist=M("category")->children(0,"article");
			$this->smarty->goassign(array(
				"data"=>$data,
				"catlist"=>$catlist
			));
			$this->smarty->display("article/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$data=M("article")->postData();
			$content=post("content");
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
			$status=get_post("status","i");
			M("article")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		public function onRecommend(){
			$id=get('id','i');
			$is_recommend=get('is_recommend','i');
			M("article")->update(array("is_recommend"=>$is_recommend),array("id"=>$id));	
			echo json_encode(array("error"=>0,"message"=>$this->lang['save_success']));	 
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
		
	}

?>