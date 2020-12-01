<?php
class helpControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$list=M("article")->getAll("
			select a.id,a.title,c.content 
			from ".table("article")." as a left join ".table("article_data")." as c
			on a.id=c.id
			where a.status=1 
			limit 10
		");
		if($list){
			foreach($list as $k=>$v){
				if($k==0){
					$v["isActive"]=1;
				}else{
					$v["isActive"]=0;
				}
				$list[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list
		));
		$this->smarty->display("help/list.html");
	}
	
} 