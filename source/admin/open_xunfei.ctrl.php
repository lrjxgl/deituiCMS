<?php
class open_xunfeiControl extends skymvc{
	
	public function onDefault(){
		$data=M("open_xunfei")->get();
		$this->smarty->goAssign(array(
			"data"=>$data
		));
		$this->smarty->display("open_xunfei/index.html");
	}
	public function onSave(){
		$data=M("open_xunfei")->postData();
		M("open_xunfei")->update($data," 1 ");
		$this->goAll("保存成功");
	}
	
}