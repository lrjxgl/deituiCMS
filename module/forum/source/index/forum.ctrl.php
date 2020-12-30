<?php
	class forumControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			
			$list=MM("forum","forum_tags")->getForumByKey("index");
			 
			//广告
			$fromapp=get("fromapp");
			switch($fromapp){
				case "uniapp":
					$flashList=M("ad")->listByNo("uniapp-forum-index");
					$adList=M("ad")->listByNo("uniapp-forum-ad");
					$navList=M("ad")->listByNo("uniapp-forum-nav"); 
					break;
				default:
					$flashList=M("ad")->listByNo("wap-forum-index");
					$adList=M("ad")->listByNo("wap-forum-ad");
					$navList=M("ad")->listByNo("wap-forum-nav"); 
					break;
			}
			 
			$this->smarty->goassign(array(
				"list"=>$list,
				"flashList"=>$flashList,
				"adList"=>$adList,
				"navList"=>$navList,
				"rscount"=>$rscount,
				"per_page"=>$per_page
			));
			if(MDAPPTYPE=="plugin"){
				$this->smarty->display("forum/index.html");
			}else{
				$this->smarty->display("forum/indexdiy.html");
			}
			 
		}
		
		public function onNew(){
			 
			$rscount=true;
			$where="   status=1 ";
			$url="/module.php?m=forum&a=new";
			 
			$start=get_post('per_page','i');
			$limit=24;
			$option=array(
				"where"=>$where,
				"start"=>$start,
				"limit"=>$limit,
				"order"=>"id DESC"
			);
			$data=MM("forum","forum")->select($option,$rscount);
			 
			if($data){
				foreach($data as $v){
					$uids[]=$v['userid'];
					$gids[]=$v['gid'];
				}
				$gs=MM("forum","forum_group")->getListByIds($gids,"gid,title");
				$us=M("user")->getUserByIds($uids);
				 
				foreach($data as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['user_head']=images_site($us[$v['userid']]['user_head']);
					$v['timeago']=timeago($v['dateline']);
					$v['group_title']=$gs[$v['gid']]['title'];
					$v['imgurl'] && $v['imgurl']=images_site($v['imgurl']);
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
			 
			$pagelist=$this->pagelist($rscount,$limit,$url);
		 	$per_page=$start+$limit;
			$per_page=$per_page<$rscount?$per_page:0;
			
			$this->smarty->goassign(array(
				"per_page"=>$per_page,
				"list"=>$data,
				"rscount"=>$rscount,
				"pagelist"=>$pagelist,
				 
			));
			$this->smarty->display("forum/new.html");
		}
		
		public function onList(){
			$gid=get("gid","i");
			$group=MM("forum","forum_group")->selectRow("gid=".$gid);
			if($group['status']!=1){
				$this->goAll("本版块暂时无法访问",1);
			}
			$rscount=true;
			$where=" gid=".$gid." AND  status=1 ";
			$url="/module.php?m=forum&a=list&gid=".$gid;
			$catid=get_post('catid','i');
			$cat=array();
			if($catid){
				$where.=" AND catid=".$catid;
				$url.="&catid=".$catid;
				$cat=M("mod_forum_category")->selectRow("catid=".$catid);
			}
			$start=get_post('per_page','i');
			$limit=24;
			$option=array(
				"where"=>$where,
				"start"=>$start,
				"limit"=>$limit,
				"order"=>"id DESC"
			);
			$data=MM("forum","forum")->select($option,$rscount);
			$catlist=M("mod_forum_category")->select(array(
				"where"=>" gid=".$gid." AND status=1 ",
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
				$gs=MM("forum","forum_group")->getListByIds($gids,"gid,title");
				$us=M("user")->getUserByIds($uids);
				foreach($data as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['user_head']=images_site($us[$v['userid']]['user_head']);
					$v['timeago']=timeago($v['dateline']);
					$v['group_title']=$gs[$v['gid']]['title'];
					$v['imgurl'] && $v['imgurl']=images_site($v['imgurl']);
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
			//推荐帖子
			$recList=array();
			if($start==0){
				if($catid){
					$where=" status=1 AND catid=".$catid." AND isrecommend=1 ";
				}else{
					$where=" status=1 AND  gid=".$gid." AND isrecommend=1 ";
				}
				
				$recList=MM("forum","forum")->Dselect(array(
					"where"=>$where,
					"limit"=>6
				));
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
		 	$per_page=$start+$limit;
			$per_page=$per_page<$rscount?$per_page:0;
			
			$this->smarty->goassign(array(
				"per_page"=>$per_page,
				"list"=>$data,
				"rscount"=>$rscount,
				"pagelist"=>$pagelist,
				"catlist"=>$catlist,
				"group"=>$group,
				"cat"=>$cat,
				"catid"=>$catid,
				"recList"=>$recList
			));
			$this->smarty->display("forum/list.html");
		}
		
		
		public function onSearch(){
			$start=get_post('per_page','i');
			$limit=24;
			$url="/index.php?m=forum&a=search";
			$where="   status=1 ";
			 
			$keyword=get("keyword","h");
			if($keyword){
				$where.=" AND title like '%".$keyword."%' ";
				$url.="&title=".urlencode($keyword);
			}else{
				$where.=" AND 1=2 ";
			}
			$option=array(
				"where"=>$where,
				"start"=>$start,
				"limit"=>$limit,
				"order"=>"id DESC"
			);
			$rscount=true;
			$data=MM("forum","forum")->select($option,$rscount);
			if($data){
				foreach($data as $v){
					$uids[]=$v['userid'];
					$gids[]=$v['gid'];
				}
				$gs=MM("forum","forum_group")->getListByIds($gids,"gid,title");
				$us=M("user")->getUserByIds($uids);
				foreach($data as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['user_head']=images_site($us[$v['userid']]['user_head']);
					$v['timeago']=timeago($v['dateline']);
					$v['group_title']=$gs[$v['gid']]['title'];
					$v['imgurl'] && $v['imgurl']=images_site($v['imgurl']);
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
			
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page<$rscount?$per_page:0;
			$this->smarty->goassign(array(
				"list"=>$data,
				"rscount"=>$rscount,
				"pagelist"=>$pagelist,
				"keyword"=>$keyword, 
				"per_page"=>$per_page
			));
			$this->smarty->display("forum/search.html");
		}
		
		public function onTag(){
			$rscount=true;
			$where=" status=1 ";
			$url="/index.php?m=forum&a=tag";
			$tagname=get("tagname","h");
			$tagid=get("tagid","i");
			if($tagid){
				$where.=" AND tagid=".$tagid;
				$url.="&tagid=".$tagid;
				$tag=MM("forum","forum_tags")->selectRow("  tagid='".$tagid."' ");
				if(!$tag){
					$tagid=0;
				}
			}elseif($tag){
				$tag=MM("forum","forum_tags")->selectRow("  title='".$tagname."' ");
				if($tag){
					$tagid=$tag['tagid'];
					$url.="&tagid=".$tag['tagid'];
				}
				
			}
			
			$start=get_post('per_page','i');
			$limit=24;
			$data=array();
			if($tagid){
				$sql=" select a.id,a.title,a.imgurl,a.description,a.tags,a.dateline  
					from ".table("forum_tags_index")." as i 
					left join ".table("forum")." as a
					on i.objectid=a.id
					where i.tagid=".$tag['tagid']."
					limit $start,$limit
				";
				$rscount=M("forum_tags_index")->selectOne(array(
					"where"=>" tagid=".$tag['tagid'],
					"fields"=>" count(id) as ct "
				));
				$data=MM("forum","forum")->getAll($sql);
			
				if($data){
					foreach($data as $v){
						$uids[]=$v['userid'];
						$gids[]=$v['gid'];
					}
					$gs=MM("forum","forum_group")->getListByIds($gids,"gid,title");
					$us=M("user")->getUserByIds($uids);
					foreach($data as $k=>$v){
						$v['nickname']=$us[$v['userid']]['nickname'];
						$v['user_head']=images_site($us[$v['userid']]['user_head']);
						$v['timeago']=timeago($v['dateline']);
						$v['group_title']=$gs[$v['gid']]['title'];
						$v['imgurl'] && $v['imgurl']=images_site($v['imgurl']);
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
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			 
			$this->smarty->goassign(array(
				"list"=>$data,
				"rscount"=>$rscount,
				"pagelist"=>$pagelist,
				"tag"=>$tag
			));
			$this->smarty->display("forum/tag.html");
		}
		
		public function onShow(){
			$id=get('id','i');
 			$userid=M("login")->userid;
			$data=MM("forum","forum")->selectRow("id=".$id." AND status in(0,1) ");
			if(!$data) $this->goAll("数据出错",1);
			
			$author=M("user")->getUser($data['userid'],"userid,nickname,user_head,follow_num,followed_num");
			$author['user_head']=images_site($author['user_head']);
			if($data){
				$data['content']=MM("forum","forum_data")->selectOne(array(
					"fields"=>"content",
					"where"=>"id=".$id
				));
				$data["timeago"]=timeago($data["dateline"]);
			}
			if($userid){
				$author["isFollow"]=0;
				if($author["userid"]){
					$isFollow=M("follow")->selectRow(array("where"=>"t_userid=".$author["userid"]." AND userid=".$userid."   "));
				 
					if($isFollow){
						$author["isFollow"]=1;
					}
					 
				}
			}
			 
			$data['imgurl']=images_site($data['imgurl']); 
			 
			$catlist=M("mod_forum_category")->select(array(
				"where"=>"  status=1 AND gid=".$data['gid']
			));
		 
			 
		 	//图集
			$imgslist=array();
			if($data['imgsdata']){
				$imgs=explode(",",$data['imgsdata']);
				foreach($imgs as $img){
					$imgslist[]=images_site($img);
				}
				  
			}else{
				$imgslist=M("mod_forum_img")->select(array(
					"where"=>"objectid=".$id
				));
				if($imgslist){
					foreach($imgslist as $k=>$v){
						$v['imgurl']=images_site($v['imgurl']);
						$imgslist[$k]=$v;
					}
				}
			} 
			//是否点赞
			$islove=0;
			$love=M("love")->selectRow("tablename='mod_forum' AND userid=".$userid." AND objectid=".$id);
			if($love){
				$islove=1;
			}
			//是否收藏
			$isfav=0;
			if($userid){
				$fav=M("fav")->selectRow("tablename='mod_forum' AND userid=".$userid." AND objectid=".$id);
				if($fav){
					$isfav=1;
				}
			}
			$group=MM("forum","forum_group")->selectRow(array(
				"where"=>" gid=".$data['gid'],
				"fields"=>" gid,title"
			));
			$this->smarty->goassign(array(
				"islove"=>$islove,
				"isfav"=>$isfav,
				"data"=>$data,
				"catlist"=>$catlist,
				"comment_objectid"=>$id,
				"comment_tablename"=>"mod_forum",
				"comment_f_userid"=>$data['userid'],
				"imgslist"=>$imgslist,
				"author"=>$author,
				"group"=>$group,
				"userid"=>$userid
				 
			));
			$this->smarty->display("forum/show.html");
		}
		public function onShow_content(){
			$id=get("id","i");
			$row=MM("forum","forum_data")->selectRow("id=".$id);
			
			all_app_html($row['content']);
		}
		
		public function onMy(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			$rscount=true;
			$where=" userid=".$userid." AND status in(0,1,2) ";
			$url="/index.php?m=forum&a=my";
			$catid=get_post('catid','i');
			if($catid){
				$where.=" AND catid=".$catid;
				$url.="&catid=".$catid;
			}
			$start=get_post('per_page','i');
			$limit=24;
			$option=array(
				"where"=>$where,
				"start"=>$start,
				"limit"=>$limit,
				"order"=>"id DESC"
			);
			$data=MM("forum","forum")->select($option,$rscount);
			$catlist=M("mod_forum_category")->select(array(
				"where"=>"   status=1 ",
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
				$gs=MM("forum","forum_group")->getListByIds($gids,"gid,title");
				$us=M("user")->getUserByIds($uids); 
				foreach($data as $k=>$v){
					$v['group_title']=$gs[$v['gid']]['title'];
					$v['cname']=$cats[$v['catid']];
					$v['imgurl']=images_site($v['imgurl']);
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['user_head']=images_site($us[$v['userid']]['user_head']);
					$v['timeago']=timeago($v['dateline']);
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
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page<$rscount?$per_page:0;
			$this->smarty->goassign(array(
				"list"=>$data,
				"per_page"=>$per_page,	
			
				"rscount"=>$rscount,
				"pagelist"=>$pagelist,
				"catlist"=>$catlist,
				"group"=>$group
			));
			$this->smarty->display("forum/my.html");
			
		}
		
		public function onAdd(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			M("blacklist")->check($userid);
			M("blacklist_post")->check($userid); 
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
			
			$grouplist=MM("forum","forum_group")->select(array(
				"where"=>"   status=1 ",
				"fields"=>"gid,title",
				"order"=>" orderindex ASC"
			));
			 
			$allCat=M("mod_forum_category")->select(array(
				"where"=>" status=1 ",
				"fields"=>"catid,title,imgurl,gid,description"
			)); 
			$gcats=array();
			if($allCat){
				foreach($allCat as $v){
					$v['imgurl']=images_site($v['imgurl']);
					$gcats[$v['gid']][]=$v;
				}
			}
			if($grouplist && $gcats){
				foreach($grouplist as $k=>$v){
					$grouplist[$k]['child']=$gcats[$v['gid']];
				}
			}
			
			 
			$this->smarty->goAssign(array(
				"data"=>$data,
				"catlist"=>$catlist,
				"grouplist"=>$grouplist,
				"imgsdata"=>$imgsdata
			));
			
			$this->smarty->display("forum/add.html");
		}
		
		public function onSave(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			M("blacklist")->check($userid);
			$id=get_post("id","i");
			$data=MM("forum","forum")->postData();
			 
			$sdata=array(
				"id"=>$id,
				"content"=>post('content','x'),
				"dateline"=>time(),
				 
			);
			if(empty($sdata["content"])){
				$sdata["content"]=$data["description"];
			}
			
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
				$data['userid']=$userid;
				$data['dateline']=$data['last_time']=time();
				$data['status']=1; 
				$id=MM("forum","forum")->insert($data);
				$sdata['id']=$id;
				//修改topic
				MM("forum","forum_group")->changenum("topic_num",1,"gid=".$data['gid']);
				if(!MM("forum","forum_data")->selectRow("id=$id")){
					MM("forum","forum_data")->insert($sdata);
				}else{
					MM("forum","forum_data")->update($sdata,array("id"=>$id));
				}
				//推送到订阅
				$us=M("follow")->selectCols(array(
					"fields"=>"userid",
					"where"=>"t_userid=".$userid,
					"limit"=>100000000
				));
					
				if(!$us) $us=array();
				$us[]=$userid;
				foreach($us as $uid){
					M("mod_forum_feeds")->insert(array(
						"userid"=>$uid,
						"objectid"=>$id,
						"fuserid"=>$userid,
						"dateline"=>time(),
					));
				}		 
				
				
			}
			//处理标签
			$tagarr=explode(" ",$data['tags']);
			foreach($tagarr as $k=>$v){
				if(empty($v)){
					unset($tagarr[$k]);
				}
			}
			MM("forum","forum_tags")->done($id,$tagarr);
			//处理图片
			$this->goall("保存成功");
		}
		public function onDelete(){
			$id=get_post('id',"i");
			$row=MM("forum","forum")->selectRow("id=".$id);
			 
			MM("forum","forum")->update(array(
				"status"=>11
			),"id=".$id);
			 
			$this->goAll("删除成功");
			
		}
		public function onUser(){
			M("login")->checkLogin();
			$userid=M("login")->userid;
			$user=M("user")->getUser($userid,"userid,user_head,nickname,money,gold");
			$topic_num=M("mod_forum")->selectOne(array(
				"where"=>" userid=".$userid." AND status=1 ",
				"fields"=>" count(*)"
			));
			$comment_num=M("mod_forum_comment")->selectOne(array(
				"where"=>" userid=".$userid." AND status in(0,1,2) ",
				"fields"=>" count(*)"
			));
			$invitecode=M("user_invitecode")->getCode($userid);
			$reg_invitecode=0;
			if(defined("REG_INVITECODE") && REG_INVITECODE==1){
				$reg_invitecode=1;
			}
			$this->smarty->goAssign(array(
				"user"=>$user,
				"topic_num"=>$topic_num,
				"comment_num"=>$comment_num,
				"invitecode"=>$invitecode,
				"reg_invitecode"=>$reg_invitecode
			));
			$this->smarty->display("forum/user.html");
		}
		public function onAddClick(){
			$id=get("id","i");
			MM("forum","forum")->changenum("view_num",1,"id=".$id);
		}
		public function onmyFav(){
			$this->smarty->display("forum/myfav.html");
		}
	}
?>