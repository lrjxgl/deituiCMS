<?php
class forum_imgControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		 
	}
	public function onDefault(){
		$objectid=get_post('objectid','i');
		$forum=M("mod_forum")->selectRow(array(
			"where"=>"id=".$objectid,
			"fields"=>"id,title"
		));
		$data=M('mod_forum_img')->select(array(
			"where"=>" objectid=".$objectid
		));
		if($data){
			foreach($data as $k=>$v){
				$v['imgurl']=images_site($v['imgurl']);
				$data[$k]=$v;
			}
			
		}
		$this->smarty->goAssign(array(
			"data"=>$data,
			"forum"=>$forum
		));
		
		$this->smarty->display("forum_img/index.html");
	}
	
	public function onSave(){
		$data=M('mod_forum_img')->postData();
		if($data['id']){
			$row=M('mod_forum_img')->selectRow("id=".$data['id']);
			M('mod_forum_img')->update($data,"id=".$data['id']);
		}else{
			 
			$data['createtime']=date("Y-m-d H:i:s");
			$id=M('mod_forum_img')->insert($data);
		}
		$rdata=array(
			"id"=>$id
		);
		$this->goAll('保存成功',0,$rdata);
	}
	
	public function onImgsData(){
		$objectid=get("objectid");
		$imgs=M('mod_forum_img')->selectCols(array(
			"where"=>" objectid=".$objectid,
			"order"=>"id ASC",
			"fields"=>"imgurl"
		));
		M("mod_forum")->update(array(
			"imgsdata"=>implode(",",$imgs)
		),"id=".$objectid);
		$this->goAll("成功");
	}
	
	public function ondelete(){
		$id=get_post('id','i');
		M('mod_forum_img')->delete("id=".$id);
		$this->goAll('删除成功');
	}
	
	
}
?>