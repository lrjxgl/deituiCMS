<?php
class seoControl extends skymvc{
	
	function __construct(){
		parent::__construct();	
	}
	
	public function onDefault(){
		$limit=20;
		$start=get('per_page','i');
		$option=array(
			"where"=>" 1=1 ",
			"start"=>$start,
			"limit"=>$limit,
			"order"=>"id DESC"
		);
		$rscount=true;
		$data=M("seo")->select($option,$rscount);
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->assign(array(
			"data"=>$data,
			"rscount"=>$rscount,
		));
		$this->smarty->display("seo/index.html");
	}
	/*添加*/
	public function onAdd(){
		
		$id=get_post('id','i');	
		if($id){
			$seo=M("seo")->getRow("SELECT * FROM ".table('seo')." WHERE id='$id'  ");	
			$this->smarty->assign("seo",$seo);
		}
		$this->smarty->display("seo/add.html");	
	}
	public function onSave(){
		$id=get_post('id','i');
		$data['cname']=post('cname','h');
		$data['m']=post('m','h');
		$data['a']=post('a','h');
		$data['object_id']=post('object_id','i');
		$data['title']=post('title','h');
		$data['description']=post('description','h');
		if(empty($data['description'])){			
			$data['description']=cutstr(strip_tags($_POST['content']),240);
		}
		$data['keywords']=post('keywords','h');
		
		if($id){
			M("seo")->update($data,"   id='$id' ");
		}else{
			M("seo")->insert($data);
		}
		$this->goall("操作成功");	
	}
	
	public function onDel(){
		$id=get_post('id','i');
		if(M("seo")->delete(array("id"=>$id))){
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}else{
			exit(json_encode(array("error"=>0,"message"=>"删除失败")));
		}
	}
	
}
?>