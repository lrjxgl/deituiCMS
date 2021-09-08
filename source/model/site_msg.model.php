<?php
class site_msgModel extends model{
	public $table="site_msg";
	public function add($ops){
		$tablename=$ops["tablename"];
		$content=$ops["content"];
		$u=M("site_msg")->selectRow("tablename='".$tablename."'");
		if(!empty($u)){
			M("site_msg")->update([
				"createtime"=>date("Y-m-d H:i:s"),
				"content"=>$content
			],"tablename='".$tablename."' ");
			
		}else{
			M("site_msg")->insert([
				"createtime"=>date("Y-m-d H:i:s"),
				"content"=>$content,
				"tablename"=>$tablename
			]);
		}
	}
	
	public function remove($tablename){
		M("site_msg")->delete("tablename='".$tablename."'");
	}
	
}