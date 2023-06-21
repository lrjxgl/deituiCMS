<?php
class feedsModel extends model{
	public $table="feeds";
	public function add($userid,$tablename,$objectid){
		//推送到订阅
		$us=M("followed")->selectCols(array(
			"fields"=>"userid",
			"where"=>"userid=".$userid,
			"limit"=>100000000
		));
		
		if(empty($us)){
			$us=[];
			$us[]=$userid;
		}
		if(!empty($us)){
			foreach($us as $uid){
				M("feeds")->insert(array(
					"userid"=>$uid,
					"objectid"=>$objectid,
					"tablename"=>$tablename,
					"dateline"=>time(),
				));
			}	
		}
	}
}