<?php
/**
 * 网站管理员前台汇总页面
 */
class site_msgControl extends skymvc{
	
	public function onDefault(){
		$list=M("site_msg")->select(array(
			"where"=>" status in(0,1) ",
			"order"=>"createtime DESC"
		));
		$this->smarty->goAssign(array(
			"list"=>$list
		));
		$this->smarty->display("site_msg/index.html");
	}
	
	public function onDelete(){
		$tablename=get("tablename","h");
		M("site_msg")->delete("tablename='".$tablename."' ");
		echo json_encode([
			"error"=>0,
			"message"=>"删除成功"
		]);
	}
	
	
	
	
}
?>