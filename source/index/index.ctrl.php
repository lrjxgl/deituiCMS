<?php
class indexControl extends skymvc
{
	function __construct()
	{
		parent::__construct();
	}
	
	

	public function onDefault()
	{
		if(defined("RURL301") && RURL301!=""){
			header("HTTP/1.1 301 Moved Permanently");			
			header("Location: ".RURL301);			
			exit();
		}
		$fromapp=get("fromapp");
		switch($fromapp){
			case "uniapp":
				$flashList=M("ad")->listByNo("uniapp-index");
				break;
			default:
				$flashList=M("ad")->listByNo("wap-index");
				break;
		}
		
		$articleList=M("article")->Dselect(array(
			"where"=>" is_recommend=1 AND status=2 ",
			"limit"=>6,
			"order"=>" id DESC"
		));
		$this->smarty->goAssign(array(
			"flashList"=>$flashList,
			"articleList"=>$articleList
		));
		$this->smarty->display("index.html");
	}
}

?>