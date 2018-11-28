<?php
class indexControl extends skymvc
{
	function __construct()
	{
		parent::__construct();
	}
	
	

	public function onDefault()
	{
		$res=M("navbar")->select(array(
			"where"=>" group_id=2 AND status=1 ",
			"order"=>" orderindex ASC"
		));
		$a=$b=array();
		if($res){
			foreach($res as $v){
				if($v['pid']==0){
					$a[]=$v;
				}else{
					$b[$v['pid']][]=$v;
				}
			}
			foreach($a as $k=>$v){
				if(isset($b[$v['id']])){
					$a[$k]['child']=$b[$v['id']];
				}
			}
		}
		$topNav=M("navbar")->select(array(
			"where"=>" group_id=1 AND status=1 ",
			"order"=>" orderindex ASC"
		));
		 $this->smarty->goAssign(array(
			"navList"=>$a,
			"topNav"=>$topNav
		 ));
		$this->smarty->display("index.html");
	}
	
	public function onMain(){
		
		$this->smarty->display("index/main.html");
	}
}

?>