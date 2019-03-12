<?php
class htmlControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
		
	}
	
	public function onDefault(){
		switch(get('a','h')){
			case "aboutus":
					$word="关于我们";
				break;
			case "contact":
					$word="联系我们";
				break;
			case "wzkf":
					$word="网站建设";
				break;
			case "php":
					$word="php";
				break;
		}
		$data=array();
		if($word){
			$data=M("dataapi")->getWord($word);
		}
		$this->smarty->goAssign(array(
			"data"=>$data
		));
		$this->smarty->display("html/".str_replace(ROOT_PATH,"",get('a','h')).".html");		
	}
}
?>