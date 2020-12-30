<?php
class forum_paihangControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$fsList=M("user")->Dselect(array(
			"where"=>" status=1 ",
			"limit"=>100,
			"fields"=>" userid,user_head,nickname,followed_num",
			"order"=>"followed_num DESC"
		));
		$wzList=M("mod_forum")->getAll("SELECT   userid,sum(comment_num) as num  FROM sky_mod_forum   where  status in(0,1) group by userid   ORDER BY num DESC LIMIT 0,100 ");
		 
		if($wzList){
			foreach($wzList as $v){
				$uids[]=$v["userid"];
			}
			$us=M("user")->getUserByIds($uids," userid,user_head,nickname");
			foreach($wzList as $k=>$v){
				if(!isset($us[$v["userid"]])){
					unset($wzList[$k]);	
					continue;
				}
				$u=$us[$v["userid"]];
				$u["num"]=$v["num"];
				
				$wzList[$k]=$u;
			}
		}
		
		$this->smarty->goAssign(array(
			"fsList"=>$fsList,
			"wzList"=>$wzList
		));
		$this->smarty->display("forum_paihang/index.html");
	}
	
	public function onApi(){
		
	}
	
}
?>