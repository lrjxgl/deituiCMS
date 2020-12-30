<?php
class b2c_product_ksControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$productid=get("productid","i");
		$product=M("mod_b2c_product")->selectRow(array(
			"where"=>" id=".$productid,
			"fields"=>"id,title,ks_label_name,ks_label_size"
		));
		$this->smarty->goAssign(array(
			"product"=>$product
		));
		$this->smarty->display("b2c_product_ks/index.html");
	}
	public function onJlist(){
		$productid=get_post('productid','i');
		$data=M('mod_b2c_product_ks')->select(array("where"=>" productid=".$productid));
		exit(json_encode($data));
	}
	public function onSave(){
		$id=get_post("id","i");
		$data=M('mod_b2c_product_ks')->postData();
	 
		if($id){
			 
			$row=M('mod_b2c_product_ks')->selectRow("id=".$id);
			M('mod_b2c_product_ks')->update($data,"id=".$id);
		}else{
			$data['createtime']=date("Y-m-d H:i:s");
			$id=M('mod_b2c_product_ks')->insert($data);
		}
		$rdata=array(
			"id"=>$id
		);
		//
		M("mod_b2c_product")->update(array(
			"isksid"=>1
		),"id=".$data["productid"]);
		$this->goAll('保存成功',0,$rdata);
	}
	
	public function ondelete(){
		$id=get_post('id','i');
		$row=M("mod_b2c_product_ks")->selectRow("id=".$id);
		if(empty($row)){
			$this->goAll("参数出错",1);
		}
		M('mod_b2c_product_ks')->delete("id=".$id);
		//
		$kslist=M("mod_b2c_product_ks")->selectRow(array(
			"where"=>" productid=".$row["productid"]
		));
		if(empty($kslist)){
			M("mod_b2c_product")->update(array(
				"isksid"=>0
			),"id=".$row["productid"]);
		}
		
		$this->goAll('删除成功');
	}
}