<?php
class user_rankControl extends skymvc{
	
	public function onDefault(){
		$list=M("user_rank")->select(array(
			"order"=>" min_grade ASC"
		));
		if(!empty($list)){
			foreach($list as &$v){
				$v["logo"]=images_site($v["logo"]);
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list
		));
		$this->smarty->display("user_rank/index.html");
	}
}