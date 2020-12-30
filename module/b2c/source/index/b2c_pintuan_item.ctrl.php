<?php
class b2c_pintuan_itemControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	public function onList(){
		$list=M("mod_b2c_pintuan_item")->select();
		if($list){
			foreach($list as $v){
				$uids[]=$v["userid"];
			}
			$us=M("user")->getUserByIds($uids);
			foreach($list as $k=>$v){
				$v["nickname"]=$us[$v["userid"]]["nickname"];
				$list[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list
		));
	}
	public function onSave(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		$productid=post("productid","i");
		$product=M("mod_b2c_product")->selectRow("id=".$productid);
		if(!$product["pt_open"]){
			$this->goall("该产品未开启拼团",1);
		}
		M("mod_b2c_pintuan_item")->insert(array(
			"userid"=>$userid,
			"productid"=>$productid,
			"createtime"=>date("Y-m-d H:i:s")
		));
		$this->goAll("创建成功");
	}
	
}
