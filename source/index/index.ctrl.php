<?php
class indexControl extends skymvc
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function onTest(){
		echo M("user_invitecode")->getCode(1);
		 
	} 

	public function onDefault()
	{
		if(defined("RURL301") && RURL301!="" && !get("ajax")){
			$arr=parse_url(RURL301);
			parse_str($arr["query"],$get);
			 
			if($arr["path"]=="/module.php" && isset($get["m"])){
				$m=preg_replace("/\W/iUs","",$get["m"]);
				
				CC($m,$m)->smarty->assign("skins","module/".$m."/themes/index/");
				CC($m,$m)->smarty->template_dir="module/".$m."/themes/index/";
				require_once(ROOT_PATH."module/".$m."/module.php");
				if(function_exists("moduleInit")){
					moduleInit();
				}
				CC($m,$m)->onDefault();
				exit;
			}
			
			header("HTTP/1.1 301 Moved Permanently");			
			header("Location: ".RURL301);			
			exit();
		}
		$fromapp=get("fromapp");
		switch($fromapp){
			case "uniapp":
				$flashList=M("ad")->listByNo("uniapp-index");
				$navList=M("navbar")->navlist(14);
				break;
			default:
				$flashList=M("ad")->listByNo("wap-index");
				$navList=M("navbar")->navlist(4);
				break;
		}
		
		$articleList=M("article")->Dselect(array(
			"where"=>" is_recommend=1 AND status=1 ",
			"limit"=>6,
			"order"=>" id DESC"
		));
		$this->smarty->goAssign(array(
			"flashList"=>$flashList,
			"articleList"=>$articleList,
			"navList"=>$navList
		));
		$tpl=M("pagetpl")->get("index","index","index.html");
		$this->smarty->display($tpl);
	}
}

?>