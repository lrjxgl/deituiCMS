<?php
class b2cControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}

	public function onDefault(){
		//推荐
		$recList=MM("b2c","b2c_product")->Dselect(array(
			"where"=>" status=1 AND isrecommend=1 ",
			"limit"=>12,
			"order"=>"id DESC"
		));
		$hotList=MM("b2c","b2c_product")->Dselect(array(
			"where"=>" status=1 AND isrecommend=1 ",
			"limit"=>12,
			"order"=>"id DESC"
		));
		$fromapp=get("fromapp");
		switch($fromapp){
			case "uniapp":
				$flashList=M("ad")->listByNo("uniapp-b2c-index");
				$adList=M("ad")->listByNo("uniapp-b2c-ad");
				$navList=M("ad")->listByNo("uniapp-b2c-nav");
				
				break;
			default:
				$flashList=M("ad")->listByNo("wap-b2c-index");
				$adList=M("ad")->listByNo("wap-b2c-ad");
				$navList=M("ad")->listByNo("wap-b2c-nav");
				break;
		}
		$seo=M("seo")->get("b2c","default");
		$site=M("site")->get();
		$bmList=MM("b2c","b2c_group")->getProductByKey('bimai');
		$this->smarty->assign(array(
			"seo"=>$seo
		));
		$this->smarty->goAssign(array(
			"navList"=>$navList,
			"recList"=>$recList,
			"hotList"=>$hotList,
			"flashList"=>$flashList,
			"adList"=>$adList,
			
			"site"=>$site,
			"bmList"=>$bmList
		));
	 
		$tpl=M("pagetpl")->get("b2c","index");	
		$this->smarty->display($tpl);
	}
	 	
}

?>