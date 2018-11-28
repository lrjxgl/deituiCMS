<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class ad_tagsControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" pid=0  ";
			$url=APPADMIN."?m=ad_tags&a=default";
			$limit=30;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" tag_id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("ad_tags")->select($option,$rscount);
			if($data){
				foreach($data as $k=>$v){
					$child=M("ad_tags")->select(array("where"=>"  pid=".$v['tag_id'],"order"=>"orderindex asc"));
					$v['child']=$child;
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"pid_list"=>M("ad_tags")->tagList(0,0)
				)
			);
			$this->smarty->display("ad_tags/index.html");
		}
		
		public function onShow(){
			$tag_id=get_post("tag_id","i");
			if($tag_id){
				$data=M("ad_tags")->selectRow(array("where"=>"tag_id={$tag_id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data,
				
			));
			$this->smarty->display("ad_tags/show.html");
		}
		public function onAdd(){
			$tag_id=get_post("tag_id","i");
			if($tag_id){
				$data=M("ad_tags")->selectRow(array("where"=>"tag_id={$tag_id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data,
				"pid_list"=>M("ad_tags")->tagList(0,0)
			));
			$this->smarty->display("ad_tags/add.html");
		}
		
		public function onSave(){
			
			$tag_id=get_post("tag_id","i");
			$data["title"]=post("title","h");
			$data["orderindex"]=post("orderindex","i");
			$data["pid"]=post("pid","i");
			$data["status"]=post("status","i");
			
			$data["m"]=post("m","h");
			$data["a"]=post("a","h");
			$data["width"]=post("width","i");
			$data["height"]=post("height","i");
			$data['tagno']=post('tagno','h');
			$row=M("ad_tags")->selectRow(array("where"=>"tagno='".$data['tagno']."' "));
			if($data['tagno'] && $row['tag_id'] && $row['tag_id']!=$tag_id){
				$this->goall("唯一代号已存在，请换一个",1);
			}
			if($tag_id){
				M("ad_tags")->update($data,"tag_id='$tag_id'");
			}else{
				$data["dateline"]=time();
				
				M("ad_tags")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$tag_id=get_post('tag_id',"i");
			$status=get_post("status","i");
			M("ad_tags")->update(array("status"=>$status),"tag_id=$tag_id");
			exit(json_encode(array("error"=>0,"message"=>"状态修改成功")));
		}
		
		public function onDelete(){
			$tag_id=get_post('tag_id',"i");
			M("ad_tags")->delete("tag_id={$tag_id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		public function onChild(){
			$tag_id=get('tag_id','i');
			if($tag_id){
				$tag=M("ad_tags")->selectRow(array("where"=>" tag_id=".$tag_id." "));
				$data=M("ad_tags")->select(array("where"=>"pid=".$tag_id));
				exit(json_encode(array("error"=>0,"data"=>$data,"width"=>$tag['width'],"height"=>$tag['height'])));
			}else{
				json_encode(array("error"=>1,"data"=>$data));
			}
		}
		
		
	}

?>