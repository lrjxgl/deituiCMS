<?php
class commentControl extends skymvc{
	public $tables=array("article","product","picture","forum","ershou","shop_article","artlib");
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		//检验table是否合法
		$tablename=get_post("tablename","h");
		if(!empty($tablename)){
			if(preg_match("/[^\w]+/",$tablename)){
				exit("出错了");
			}
		}
	}
	public function onDefault(){
		 
		$tablename=get_post("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		}
		if(!in_array($tablename,$this->tables)){
			//$this->goAll("参数出错",1);
		}
		$table=$tablename;
		$tableComment=$tablename."_comment";
		$objectid=get("objectid","i");
		if(!$objectid){
			$objectid=get("object_id",'i');
		}
		$start=get("per_page","i");
		$limit=24;
		$row=M($table)->selectRow("id=".$objectid);
		$where=" status in(0,1) AND objectid=".$objectid." AND pid=0";
		$option=array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>"id ASC"
		);
		$rscount=true;
		$data=M($tableComment)->select($option,$rscount);
		if($data){
			foreach($data as $v){
				$uids[]=$v['userid'];
				$pids[]=$v['id'];
			}
			//下级评论
			$cds=M($tableComment)->select(array(
				"where"=> " pid in("._implode($pids).") "
			));
			if(!empty($cds)){
				foreach($cds as $v){
					$uids[]=$v['userid'];
				}
			}
			$cmchild=array();
			$us=M("user")->getUserByIds($uids);
			if(!empty($cds)){
				foreach($cds as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['user_head']=images_site($us[$v['userid']]['user_head']);
					$v['timeago']=timeago(strtotime($v['createtime']));
					
					$cmchild[$v['pid']][]=$v;
				}
			}
			foreach($data as $k=>$v){
				$v['child']=$cmchild[$v['id']];
				$v['nickname']=$us[$v['userid']]['nickname'];
				$v['user_head']=images_site($us[$v['userid']]['user_head']);
				$v['timeago']=timeago(strtotime($v['createtime']));
				$v['imgslist']=array();
				if($v['imgsdata']!=""){
					$imgsdata=explode(",",$v['imgsdata']);
					$imgs=array();
					foreach($imgsdata as $img){
						if(!empty($img)){
							$imgs[]=htmlspecialchars($img);
						}
					}
					if(!empty($imgs)){
						$v['imgslist']=$imgs;
					}
				}
				$data[$k]=$v;
			}
		}
		$per_page=$start+$limit;
		$per_page=$per_page<$rscount?$per_page:0;
		$this->smarty->goAssign(array(
			"list"=>$data,
			"rscount"=>$rscount,
			"per_page"=>$per_page,
			"comment_object_id"=>$objectid,
			"comment_tablename"=>$table,
			"comment_f_userid"=>$row['userid'],
		));
		
		$this->smarty->display("comment/index.html");
	}
	public function onSave(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		M("blacklist")->check($userid);
		M("blacklist_post")->check($userid);
		$id=get_post("id","i");
		$tablename=get_post("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		}
		if(!in_array($tablename,$this->tables)){
			//$this->goAll("参数出错".$tablename,1);
		}
		$table=$tablename;
		$tableComment=$tablename."_comment";
		$data=M($tableComment)->postData();
		if(empty($data["content"])){
			$this->goAll("内容不能为空",1);
		}
		
		
		$fields=M($tablename)->getFields();
		$idField=$fields[0]['Field'];
		$rootPath=get_post("rootPath","h");
		switch($rootPath){
			case "module":
				$rootPath="/module.php";
				break;
			default:
				$rootPath="/";
				break;
		}
		if($id){
			
			$row=M($tableComment)->selectRow("id=".$id);
			
			if($row['userid']!=$userid){
				$this->goAll("您无权限",1);
			}
			M($tableComment)->update($data,"id=".$id);
		}else{
			$data['userid']=$userid;
			$row=M($table)->selectRow(array(
				"where"=>" {$idField}=".$data['objectid'],
				 
			));
			$fields=M($tablename)->getFields();
			$idField=$fields[0]['Field'];
			M($table)->changenum("comment_num",1,"{$idField}=".$data['objectid']);
			$data['ip']=ip();
			$data['ip_city']=ipcity($data['ip'],1);
		 
			if(empty($data['ip_city'])){
				$data['ip_city']="本地";
			}
			if($tablename=="forum"){
				M("forum_group")->changenum("comment_num",1,"gid=".$row['gid']);
			}
			$data['createtime']=date("Y-m-d H:i:s");
			if($row['userid']){
				M("notice")->add(array(
					"content"=>"有人评论了你：".$data['content'],
					"userid"=>intval($row['userid']),
					"template_id"=>"comment",
					"linkurl"=>array(
						"path"=>$rootPath,
						"m"=>$tablename,
						"a"=>"show",
						"param"=>"&id=".$data['objectid']
					)
				));
			}elseif($row['shopid']){
				M("apppush")->sendShop(array(
					"table"=>"shop",
					"content"=>"有人评论了你：".$data['content'],
					"shopid"=>$row['shopid'],
					"type_id"=>1,
					"linkurl"=>array(
						"path"=>"/",
						"m"=>$tablename,
						"a"=>"show",
						"param"=>"&shopid=".$data['shopid']."&id=".$data['objectid']
					)					 
				));
			}
			
			M($tableComment)->insert($data);
		}
		
		$this->goAll("保存成功");
	}
	
	public function onMy(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		
		$tablename=get_post("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		}
		if(!in_array($tablename,$this->tables)){
			//$this->goAll("参数出错",1);
		}
		
		$tableComment=$tablename."_comment";
		$objectid=get("objectid","i");
		$start=get("per_page","i");
		$limit=24;
		
		$where=" userid=".$userid;
		$where.=" AND status in(0,1,2) "; 
		$option=array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>"id DESC"
		);
		$data=M($tableComment)->select($option);
		if($data){
			foreach($data as $v){
				$uids[]=$v['userid'];
			}
			$us=M("user")->getUserByIds($uids);
			foreach($data as $k=>$v){
				$v['nickname']=$us[$v['userid']]['nickname'];
				$v['user_head']=images_site($us[$v['userid']]['user_head']);
				$v['timeago']=timeago(strtotime($v['createtime']));
				
				$data[$k]=$v;
			}
		}
		 $per_page=$start+$limit;
		$per_page=$per_page<$rscount?$per_page:0;
		$this->smarty->goAssign(array(
			"list"=>$data,
			"per_page"=>$per_page,
			"comment_tablename"=>$tablename
		));
		
		$this->smarty->display("comment/my.html");
	}
	
	public function onDelete(){
		$id=get("id","i");
		$tablename=get("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		}
		if(!in_array($tablename,$this->tables)){
			//$this->goAll("参数出错",1);
		}
		$fields=M($tablename)->getFields();
		$idField=$fields[0]['Field'];
		$tableComment=$tablename."_comment";
		$row=M($tableComment)->selectRow("id=".$id);
		$userid=M("login")->userid;
		if($row['userid']!=$userid){
			$this->goAll("暂无权限",1);
		}
		if(empty($row)){
			$this->goAll("评论数据出错",1);
		}
		M($tableComment)->update(array(
			"status"=>11
		),"id=".$id);
		M($tablename)->changenum("comment_num",-1,"{$idField}=".$row['objectid']);
		$this->goAll("删除成功");
	}
	 
	public function onAddLove(){
		M("login")->checkLogin();
		$id=get("id","i");
		$tablename=get("tablename","h");
		if(empty($tablename)){
			$tablename="article";
		}
		if(!in_array($tablename,$this->tables)){
			//$this->goAll("参数出错",1);
		}	
		$tableComment=$tablename."_comment";
		$row=M($tableComment)->selectRow("id=".$id);
		$love_num=$row['love_num']+1;
		$key=$tableComment."love".$id;
		if(cache()->get($key)){
			$this->goAll("你已经点赞了",1);
		}
		cache()->set($key,1,36000);
		M($tableComment)->update(array(
			"love_num"=>$love_num
		),"id=".$id);
		$this->goAll("感谢您的支持",0,$love_num);
		
	}
}
?>