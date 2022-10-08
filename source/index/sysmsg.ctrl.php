<?php
class sysmsgControl extends skymvc{
	public $userid;
	public function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		M("login")->checkLogin();
		$this->userid=M("login")->userid;
		 
	}
	
	public function onDefault(){
		$where=" status in(0,1,2) AND  userid=".$this->userid;
		$url="/index.php?m=sysmsg";
		$limit=12;
		$start=get('per_page','i');
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$rscount=true;
		$data=M("sysmsg_user")->select($option,$rscount);
		if($data){
			$statusList=[
				0=>"未读",
				1=>"已读"
				
			];
			$ids=[];
			foreach($data as $v){
				$ids[]=$v["msgid"];
			}
			$ms=M("sysmsg")->getListByIds($ids);
			
			foreach($data as $k=>$v){
				 
				$v['title']=$ms[$v["msgid"]]['title'];
				$v["status_name"]=$statusList[$v["status"]];
				$v["createtime"]=date("Y-m-d H:i:s",$v["dateline"]);
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->goassign(array(
			"list"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist,
		));
		$this->smarty->display("sysmsg/index.html");
	}
	
	public function onShow(){
		$id=get('id','i');
		if($id){
			$data=M("sysmsg_user")->selectRow(array("where"=>"id=$id"));
			$d=M("sysmsg")->selectRow(array("where"=>"id=".$data['msgid']));
			$data['title']=$d['title'];
			$data['content']=$d['content'];
			if($data['status']==0){
				M("sysmsg_user")->update(array("status"=>1),"id=$id");
				
			}
		}
		$this->smarty->goassign(array(
			"data"=>$data
		));
		$this->smarty->display("sysmsg/show.html");
	}
	
	public function onDelete(){
		$id=get('id','i');
		M("sysmsg_user")->update(array("status"=>99),"id=$id AND userid=".$this->userid);
		$this->goall("删除成功");
	}
	
	public function onGet(){
		$userid=M("login")->userid;
		if(!$userid){
			$this->goAll("error");
		}
		$msg=M("sysmsg_user")->selectRow(array("where"=>" userid=".$userid,"order"=>" id DESC"));
		$w="";
		if($msg){
			$w=" AND id>".$msg['msgid'];
		}
		$data=M("sysmsg")->select(array("where"=>" start_time<".time()." AND end_time >".time()." AND type_id in(1,2) AND status=1 $w "));
		
		if($data){
			foreach($data as $k=>$v){
				if(!M("sysmsg_user")->selectRow(" userid=".$userid." AND msgid=".$v['id'])){
					$sdata=array(
						"userid"=>$userid,
						"msgid"=>$v['id'],
						"status"=>0,
						"dateline"=>time()
					);
					
					M("sysmsg_user")->insert($sdata);
				}
			}
		}
		$this->goAll("success");
	}
	
}
?>