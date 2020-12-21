<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class site_cityControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
 
		}
		
		public function onDefault(){
			 
			$pid=get("pid",'i');
			$parent=M("site_city")->selectRow(array("where"=>" sc_id=".$pid." AND siteid=".SITEID." "));
			$where=" siteid=".SITEID." AND pid=".$pid;
			$url=APPADMIN."?m=site_city&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" sc_id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("site_city")->select($option,$rscount);
			 
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"parent"=>$parent,
					"id_title"=>M("site_city")->id_title()
				)
			);
			$this->smarty->display("site_city/index.html");
		}
		
 
		
		public function onShow(){
			$sc_id=get_post("sc_id","i");
			if($sc_id){
				$data=M("site_city")->selectRow(array("where"=>"sc_id={$sc_id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("site_city/show.html");
		}
		public function onAdd(){
			$sc_id=get_post("sc_id","i");
			if($sc_id){
				$data=M("site_city")->selectRow(array("where"=>"sc_id=".$sc_id.""));
				if($data['pid']){
					$d_p=M("site_city")->selectRow(array("where"=>"sc_id=".$data['pid'].""));
					if($d_p['pid']){
						$pid_2nd_list=M("site_city")->id_title(array("where"=>" pid=".$d_p['pid']." "));
						$sc_2nd=$d_p;
						$sc_top=M("site_city")->selectRow(array("where"=>"sc_id=".$d_p['pid'].""));
					}else{
						$sc_top=$d_p;
					}
				}
			}
			$pid_top_list=M("site_city")->id_title(array("where"=>" pid=0  AND siteid=".SITEID.""));
			$this->smarty->assign(array(
				"data"=>$data,
				"pid_top_list"=>$pid_top_list,
				"pid_2nd_list"=>$pid_2nd_list,
				"sc_top"=>$sc_top,
				"sc_2nd"=>$sc_2nd
			));
			$this->smarty->display("site_city/add.html");
		}
		
		public function onSave(){
			
			$sc_id=get_post("sc_id","i");
			$data["title"]=post("title","h");
			if(empty($data['title'])) $this->goall("名称不能为空");
			$data["cityid"]=post("cityid","i");
			$data["lat"]=post("lat","r",2);
			$data["lng"]=post("lng","r",2);
			$data["orderindex"]=post("orderindex","i");
			$data["status"]=post("status","i");
			$data["pid"]=array_lastnum(post('pid','i'));
			
			if($sc_id){
				M("site_city")->update($data,"sc_id='$sc_id'");
			}else{
				$data['siteid']=SITEID;
				M("site_city")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$sc_id=get_post('sc_id',"i");
			$status=get_post("status","i");
			M("site_city")->update(array("status"=>$status),"sc_id=$sc_id");
			exit(json_encode(array("error"=>0,"message"=>"状态修改成功")));
		}
		
		public function onDelete(){
			$sc_id=get_post('sc_id',"i");
			M("site_city")->delete("sc_id={$sc_id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		public function onChild(){
			$sc_id=get_post('sc_id','i');
			echo "<option value='0'>请选择</option>";	
			$data=M("site_city")->id_title(array("where"=>" pid=".$sc_id." "));
			if($sc_id){
				foreach($data as $k=>$v){
					echo "<option value='".$k."'>".$v."</option>";
				}
			}
		}
		
	}

?>