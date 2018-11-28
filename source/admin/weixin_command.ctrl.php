<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class weixin_commandControl extends skymvc{
		public $wx;
		public function __construct(){
			parent::__construct();			
		}
		
		public function onInit(){
			$wid=get_post('wid','i');
			$wid=intval($_SESSION['ssweixinid']);
			$this->wx=$weixin=M("weixin")->selectRow("id=".$wid);
			
			if(empty($weixin)){
				$this->goall("请选择微信",1);
			}
			$this->smarty->assign("weixin",$weixin);
		}
		
		public function onDefault(){
			$where=" 1=1 ";
			if($this->wx){
				$where.=" AND wid=".$this->wx['id'];
			}
			$url="{$appadmin}?m=weixin_command&a=default&id=".$this->wx['id'];
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" isdefault DESC,id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("weixin_command")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"weixin_list"=>M("weixin")->id_list(),
					"fun_list"=>M("weixin_command")->fun_list,
					"type_list"=>M("weixin_command")->type_list,
					
				)
			);
			$this->smarty->display("weixin_command/index.html");
		}
		
 
 
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("weixin_command")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data,
				"fun_list"=>M("weixin_command")->fun_list,
				"type_list"=>M("weixin_command")->type_list,
			));
			$this->smarty->display("weixin_command/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$data["wid"]=post("wid","i");
			$data["title"]=post("title","h");
			$data["command"]=post("command","h");
			$data["type_id"]=post("type_id","i");
			$data["content"]=post("content","h");
			$data["dateline"]=time();
			$data['fun']=post('fun','h');
			$data['isdefault']=post('isdefault','i');
			
			$data['sc_id']=post('sc_id','i');
			if($data['isdefault']){
				M("weixin_command")->update(array("isdefault"=>0),"wid=".$data['wid']);
			}
			if($id){
				M("weixin_command")->update($data,"id='$id'");
			}else{
				M("weixin_command")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("weixin_command")->update(array("status"=>$status),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"状态修改成功")));
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("weixin_command")->delete("id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>