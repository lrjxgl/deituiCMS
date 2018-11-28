<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class open_aliossControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="";
			$url="/admin.php?m=open_alioss&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("open_alioss")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("open_alioss/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("open_alioss")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("open_alioss/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$data=M("open_alioss")->postData();
			if($id){
				M("open_alioss")->update($data,"id='$id'");
			}else{
				M("open_alioss")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("open_alioss")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("open_alioss")->update(array("status"=>99),"id=$id");
			$this->goall("删除成功",0);
		}
		
		
	}

?>