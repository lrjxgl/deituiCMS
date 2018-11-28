<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class adControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" 1=1 ";
			$url=APPADMIN."?m=ad&a=default";
			$limit=20;
			$start=get("per_page","i");
			$tag_id=get_post('tag_id','i');
			$tag_2nd_id=get_post('tag_2nd_id','i');
			if($tag_id){
				$where.=" AND tag_id=".$tag_id;
				$url.="&tag_id=".$tag_id;
			}
			if($tag_2nd_id){
				$where.=" AND tag_id_2nd=".$tag_2nd_id;
				$url.="&tag_id_2nd=".$tag_2nd_id;
			}
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("ad")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"tag_list"=>M("ad_tags")->tagList(),
				)
			);
			$this->smarty->display("ad/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("ad")->selectRow(array("where"=>"id={$id}"));
				$tag=M("ad_tags")->selectRow(array("where"=>"   tag_id=".$data['tag_id'].""));
				$tag_2nd=M("ad_tags")->selectRow(array("where"=>"tag_id=".$data['tag_id_2nd'].""));
				$_GET['tag_id']=$data['tag_id'];
				$_GET['tag_2nd_id']=$data['tag_id_2nd'];
				$this->smarty->assign("tag_list_2nd",M("ad_tags")->tagList($data['tag_id'],0));
			}else{
				if(get_post('tag_id','i')) $tag=M("ad_tags")->selectRow(array("where"=>"  tag_id=".get_post('tag_id','i').""));
				if(get_post('tag_2nd_id','i')) {
					$tag_2nd=M("ad_tags")->selectRow(array("where"=>"tag_id=".get_post('tag_2nd_id','i').""));
					$this->smarty->assign("tag_list_2nd",M("ad_tags")->tagList(get_post('tag_id','i'),0));
				}
			}
			$this->smarty->assign(array(
				"data"=>$data,
				"tag_list"=>M("ad_tags")->tagList(0,0),
				"tag"=>$tag,
				"tag_2nd"=>$tag_2nd
			));
			$this->smarty->display("ad/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$data["tag_id"]=post("tag_id","i");
			 
			$data['tag_id_2nd']=post('tag_id_2nd','i');	
			 
			$data["title"]=post("title","h");
			$data["info"]=post("info","h");
			$data["link1"]=post("link1","h");
			$data["link2"]=post("link2","h");
			$data["starttime"]=strtotime(post("starttime"));
			$data["endtime"]=strtotime(post("endtime"));
			$data["imgurl"]=post("imgurl","h");
			$data["imgurl2"]=post("imgurl2","h");
			$data["orderindex"]=post("orderindex","i");
			$data["status"]=post("status","i");
			$data["dateline"]=time();
			$data["price"]=post("price","r",2);
			$data["object_id"]=post("object_id","i");
			$city=post('city');
			if(!empty($city)){
				$data['checkbox_attr']=implode(",",post('city'));
			}
			if($id){
				M("ad")->update($data,"id='$id'");
			}else{
				
				M("ad")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("ad")->update(array("status"=>$status),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"状态修改成功")));
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("ad")->delete("id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		public function onTag_id_2nd(){
			$tag_id=get('tag_id','i');
			$data=M("ad_tags")->taglist($tag_id,0);
			$str='<option value=0>请选择</option>';
			if($data){
				foreach($data as $k=>$v){
					$str.='<option value='.$k.'>'.$v['title'].'('.$v['width'].'*'.$v['height'].')</option>';
				}
			}
			echo $str;
		}
		
		
	}

?>