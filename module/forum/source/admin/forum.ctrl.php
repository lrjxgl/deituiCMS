<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class forumControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onInit(){
			 
		}
		public function onMenu(){
			$this->smarty->display("menu.html");
		}
		public function onDefault(){
			$where=" status in(0,1,2) " ;
			$url="/moduleadmin.php?m=forum&a=default";
			$limit=24;
			$start=get("per_page","i");
			$sarr=array("id");
			foreach($_GET as $k=>$v){
				if($_GET[$k] && in_array($k,$sarr)){
					$where.=" AND $k='".get($k,'x')."' ";
					$url.="&$k=".urlencode(get($k));
				}
			}
			$isrecommend=get("isrecommend","i");
			if($isrecommend){
				$where.=" AND isrecommend=1 ";
			}
			$stime=get('stime','h');
			if($stime){
				$where.=" AND dateline>='".$stime."' ";
			}
			$etime=get('etime','h');
			if($etime){
				$where.=" AND dateline<='".$etime."'";
			}
			$catid=get_post('catid','i');
			if($catid){
			 
				$where.=" AND catid=".$catid;
				$url.="&catid=".$catid;
			}
			$gid=get("gid","i");
			if($gid){
				$where.=" AND gid=".$gid;
				$url.="&gid=".$gid;
			}
			$title=get('title','h');
			if($title){
				$where.=" AND title like '%".$title."%'";
				$url.="&title=".urlencode($title);
			}
			$nickname=get("nickname","h");
			if($nickname){
				$userid=M("user")->selectOne(array(
					"where"=>"nickname='".$nickname."'",
					"fields"=>"userid"
				));
				if($userid){
					$where.=" AND userid=".$userid;
				}else{
					$where.=" AND 1=2 ";
				}
				$url.="&nickname=".urlencode($nickname);
				
			}
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=MM("forum","forum")->select($option,$rscount);
			$catlist=MM("forum","mod_forum_category")->select(array(
				"where"=>" status=1  ",
				"fields"=>"title,catid"
			));
			$grouplist=MM("forum","forum_group")->select(array(
				"where"=>"  status=1  ",
				"fields"=>"title,gid"
			));
			if($catlist){
				foreach($catlist as $v){
					$cats[$v['catid']]=$v;
				}
			}
			if($data){
				foreach($data as $v){
					$gids[]=$v["gid"];
					$uids[]=$v["userid"];
				} 
				$us=M("user")->getUserByIds($uids);
				$groups=MM("forum","forum_group")->getListByIds($gids); 
				foreach($data as $k=>$v){
					if($v['catid']) $v['cat_name']=$cats[$v['catid']]['title'];
					if($v["gid"]){
						$v["gid_name"]=$groups[$v['gid']]["title"];
					}
					$v["nickname"]=$us[$v["userid"]]["nickname"];
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$taglist=M("mod_forum_tags")->select(array(
				"where"=>" status=1"
			));	 
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"catlist"=>$catlist,
					"grouplist"=>$grouplist,
					"taglist"=>$taglist
				)
			);
			$this->smarty->display("forum/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
		 
			$imgsdata=array();
			if($id){
				$data=MM("forum","forum")->selectRow(array("where"=>"id=$id"));
				$t_d=MM("forum","forum_data")->selectRow(array("where"=>"id=$id"));
				if(!empty($t_d)){
					$data=array_merge($data,$t_d);
				}		
				if($data["imgsdata"]){
						$imgs=explode(",",$data["imgsdata"]);
						foreach($imgs as $v){
							$imgsdata[]=array(
								"imgurl"=>$v,
								"trueimgurl"=>images_site($v)
							);
						}
				} 
				$catlist=M("mod_forum_category")->select(array(
					"where"=>" gid=".$data['gid']." AND status=1 "
				));
			}
			$grouplist=M("mod_forum_group")->select(array(
				"where"=>"    status=1 ",
				"order"=>" orderindex ASC"
			)); 
			 
			$this->smarty->assign(array(
				"data"=>$data,
				"catlist"=>$catlist,
				"grouplist"=>$grouplist,
				"imgsdata"=>$imgsdata
			));
			 
			$this->smarty->display("forum/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$data=MM("forum","forum")->postData();
			 
			$sdata=array(
				"id"=>$id,
				"content"=>post('content','x'),
				"dateline"=>time()
			);
		 
			
			if(empty($data['title'])){
				$this->goAll("标题不能为空",1);
			}
			//处理imgsdata
			if(!empty($data["imgsdata"])){
				$ims=explode(",",$data["imgsdata"]);
				foreach($ims as $im){
					if($im!="undefined" && $im!=""){
						$imgsdata[]=$im;
					}
				}
				if(!empty($imgsdata)){
					$data["imgurl"]=$imgsdata[0];
					$data["imgsdata"]=implode(",",$imgsdata);
				}
				
			} 
			if($id){
				 
				 
				$data['last_time']=time();
				MM("forum","forum")->update($data,"id='$id'");
				if(!MM("forum","forum_data")->selectRow("id=$id")){
					MM("forum","forum_data")->insert($sdata);
				}else{
					MM("forum","forum_data")->update($sdata,array("id"=>$id));
				}
				 
				
			}else{
				$data['dateline']=$data['last_time']=time();
				$id=MM("forum","forum")->insert($data);
				$sdata['id']=$id;
				if(!MM("forum","forum_data")->selectRow("id=$id")){
					MM("forum","forum_data")->insert($sdata);
				}else{
					MM("forum","forum_data")->update($sdata,array("id"=>$id));
				}
				
			}
			//处理标签
			$tagarr=explode(" ",$data['tags']);
			foreach($tagarr as $k=>$v){
				if(empty($v)){
					unset($tagarr[$k]);
				}
			}
			if(!empty($tagarr)){
				MM("forum","forum_tags")->done($id,$tagarr);
			}
			
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$row=M("mod_forum")->selectRow("id=".$id);
			$status=1;
			if($row["status"]==1){
				$status=2;
			}
			M("mod_forum")->update(array(
				"status"=>$status
			),"id=".$id);
			$this->goAll("success",0,$status);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("mod_forum")->update(array("status"=>11),"id=$id");
			$this->goAll("删除成功");
			 
		}
		
		public function onRecommend(){
			$id=get_post('id',"i");
			$row=M("mod_forum")->selectRow("id=".$id);
			$isrecommend=0;
			if($row["isrecommend"]==0){
				$isrecommend=1;
			}
			M("mod_forum")->update(array(
				"isrecommend"=>$isrecommend
			),"id=".$id);
			$this->goAll("success",0,$isrecommend);
		}
		
		public function onCategory(){
			$ids=post('ids','i');
			$catid=post('catid','i');
			if(!$catid) $this->goall("请选择分类",1);
			if($ids){
				foreach($ids as $id){
					M("mod_forum")->update(array("catid"=>$catid),"id=".$id);
				}
			}
			$this->goall("修改成功");
		}
		
		public function onDelAll(){
			$ids=post('ids','i');
			 
			 
			if($ids){
				foreach($ids as $id){
					M("mod_forum")->update(array("status"=>11),"id=".$id);
				}
			}
			$this->goall("删除成功");
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
			$hasids=M("mod_forum_tags_index")->selectCols(array(
				"where"=>" tagid=".$tagid." AND objectid in("._implode($ids).") ",
				"fields"=>"objectid"
			));
			$newids=$ids;
			if($hasids){
				$newids=array_diff($ids,$hasids);
			}
			if(!empty($newids)){
				foreach($newids as $objectid){
					M("mod_forum_tags_index")->insert(array(
						"tagid"=>$tagid,
						"objectid"=>$objectid,
						"orderindex"=>11
					));
				}
			}
			$this->goAll("success");
		}
		
		public function onSendGold(){
			$id=get_post('id',"i");
			$row=M("mod_forum")->selectRow("id=".$id);
			$gold=get("gold","i");
			M("user")->addMoney(array(
				"userid"=>$row["userid"],
				"gold"=>$gold,
				"content"=>"您的帖子被打赏了{$gold}个金币"
			));
			M("mod_forum")->update(array(
				"gold"=>$row["gold"]+$gold
			),"id=".$id);
			$this->goAll("打赏成功",0,$row["gold"]+$gold);
		}
		
	}

?>