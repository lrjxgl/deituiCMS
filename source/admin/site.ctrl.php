<?php
class siteControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
 
	}
	
	public function onDefault(){
		$this->onAdd();
	}
	
	public function onAdd(){
		$data=M("site")->selectRow("");
		if(empty($data)){
			$data=array("siteid"=>1,"sitename"=>"默认站点");
			M("site")->insert($data);
		}
		$this->smarty->assign("data",$data);
		$this->smarty->display("site/add.html");
	}
	
	public function onSave(){
		$siteid=intval(get_post('siteid','i'));
		$data['sitename']=post('sitename','h');
		$data['domain']=post('domain','h');
		$data['is_open']=post('is_open','i');
		$data['title']=post('title','h');
		$data['keywords']=post('keywords','h');
		$data['description']=post('description','h');
		if(empty($data['description'])){			
			$data['description']=cutstr(strip_tags($_POST['content']),240);
		}
		$data['close_why']=post('close_why','h');
		$data['logo']=post('logo','h');
		$data['icp']=post('icp','h');
		$data['index_template']=post('index_template','h');
		$data['statjs']=$_POST['statjs'];
		$data['wapbg']=post('wapbg','h');
		if($siteid){
			M("site")->update($data,"1=1");
		}else{
			M("site")->insert($data);
		}
	
		$this->goall("保存成功");
	}
	
	 
 
	
	
}

?>