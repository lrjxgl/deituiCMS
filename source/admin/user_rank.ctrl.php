<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class user_rankControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="";
			$url=APPADMIN."?m=user_rank&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("user_rank")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("user_rank/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("user_rank")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("user_rank/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$data["rank_name"]=post("rank_name","h");
			$data["min_grade"]=post("min_grade","i");
			$data["max_grade"]=post("max_grade","i");
			$data["discount"]=post("discount","i");
			$data['logo']=post('logo','h');
			$data["description"]=post("description","h");
			if($id){
				M("user_rank")->update($data,"id='$id'");
			}else{
				M("user_rank")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("user_rank")->delete("id=".$id);
			$this->sexit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>