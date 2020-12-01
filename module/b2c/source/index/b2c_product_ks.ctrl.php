<?php
class b2c_product_ksControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$productid=get("productid","i");
		$product=MM("b2c","b2c_product")->selectRow(array(
			"where"=>" id=".$productid
		));
		$ksList=MM("b2c","b2c_product_ks")->getListByTitle($productid);
		$ksList2=array();
		$ksid=0;
		if($ksList){
			$ks=$ksList[0];
			$ksid=$ks["id"];
			$ksList2=MM("b2c","b2c_product_ks")->select(array(
				"where"=>" productid=".$ks['productid']." AND title='".$ks['title']."' "
			));
		}
		$product["incart"]=0;
		$product["cart_amount"]=0;
		$userid=M("login")->userid;
		if($userid){
			$cart=MM("b2c","b2c_cart")->selectRow("userid=".$userid." AND ksid=".$ksid);
			if($cart){
				$product["incart"]=1;
				$product["cart_amount"]=$cart["amount"];
			}
		}
		
		$this->smarty->goAssign(array(
			"ksList"=>$ksList,
			"ks"=>$ks,
			"ksList2"=>$ksList2,
			"product"=>$product,
			"ksid"=>$ksid
		));
	}
	
	public function onsizeList(){
		$id=get('id','i');
		$row=M("mod_b2c_product_ks")->selectRow("id=".$id);
		if(!$row){
			$this->goAll("无数据",1);
		}
		$product=MM("b2c","b2c_product")->selectRow(array(
			"where"=>" id=".$row["productid"]
		));
		$ksid=$row["id"];
		$ksList=M("mod_b2c_product_ks")->select(array(
			"where"=>" productid=".$row['productid']." AND title='".$row['title']."' "
		));
		if($ksList){
			$ks=$ksList[0];
			$ksid=$ksList[0]["id"];
		}
		//处理购物车
		$product["incart"]=0;
		$product["cart_amount"]=0;
		$userid=M("login")->userid;
		if($userid){
			$cart=MM("b2c","b2c_cart")->selectRow("userid=".$userid." AND ksid=".$ksid);
			if($cart){
				$product["incart"]=1;
				$product["cart_amount"]=$cart["amount"];
			}
		}
		$this->smarty->goAssign(array(
			"ks"=>$ks, 
			"ksList2"=>$ksList,
			"product"=>$product,
			"ksid"=>$ksid,
			 
		));
		 
	}
	
	public function onGet(){
		$id=get('id','i');
		$row=M("mod_b2c_product_ks")->selectRow("id=".$id);
		if(!$row){
			$this->goAll("无数据",1);
		}
		$product=MM("b2c","b2c_product")->selectRow(array(
			"where"=>" id=".$row["productid"]
		));
		$ksid=$row["id"];
		 
		//处理购物车
		$product["incart"]=0;
		$product["cart_amount"]=0;
		$userid=M("login")->userid;
		if($userid){
			$cart=MM("b2c","b2c_cart")->selectRow("userid=".$userid." AND ksid=".$ksid);
			if($cart){
				$product["incart"]=1;
				$product["cart_amount"]=$cart["amount"];
			}
		}
		$this->smarty->goAssign(array(
			"ks"=>$row,  
			"product"=>$product,
			"ksid"=>$ksid,
			 
		));
	}
}