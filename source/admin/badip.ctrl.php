<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class badipControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="";
			$url="/admin.php?m=badip&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("badip")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("badip/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("badip")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("badip/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$data=M("badip")->postData();
			$data['createtime']=date("Y-m-d H:i:s");
			if(empty($data['content'])){
				$this->goAll("请输入原因",1);
			}
			if($id){
				M("badip")->update($data,"id='$id'");
			}else{
				$row=M("badip")->selectRow("ip='".$data['ip']."'");
				if($row){
					$this->goAll("ip已经存在",1);
				}
				M("badip")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("badip")->delete("id=$id");
			$this->goall("删除成功",0);
		}
		
		
	}

?>