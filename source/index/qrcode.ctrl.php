<?php
/***
 * 二维码
 */	
class qrcodeControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$content=get("content","x");
		$this->loadClass("qrcode",false,false);
		QRCODE::png($content,false,QR_ECLEVEL_L,6);
	}
	public function onEwm(){
		echo $content=get("content","h");
		$this->loadClass("qrcode",false,false);
		//QRCODE::png($content,false,QR_ECLEVEL_L,6);
	}
	/***商家二维码**/
	public function onShop(){
		$shopid=get("shopid","i");
		$shop=M("shop")->selectRow(array(
			"where"=>"shopid=".$shopid,
			"fields"=>" shopname,logo,shopid,zhuying"
		));
		if(empty($shop)){
			exit("商家不存在");
		}
		$shop['logo']=images_site($shop['logo']);
		$this->smarty->goAssign(array(
			"shop"=>$shop
		));
		$this->smarty->display("ewm/shop.html");
	}
	//扫码支付 给商家
	public function onShopPay(){
		$shopid=get("shopid",'i');
		$money=get("money",'h');
		if($money==0){
			$this->goAll("请输入金额",1);
		}
		$shop=M("shop")->selectRow("shopid=".$shopid);
		if($shop['status']!=2){
			$this->goAll("该商家已被关闭",1);
		}
		$content=get("content",'h');
		$pay_type=INWEIXIN?"wxpay":"alipay";
		$order_product=date("Y-m-d H:i:s")."线下购买商品支付".$money."元";
		$orderno="re".date("YmdHis").M("login")->userid;
		$backurl="/index.php?m=shop&shopid=".$shopid;
		$orderdata=array(
			"table"=>"plugin",
			"callback"=>'
				M("shop")->addMoney(array(
					"shopid"=>'.$shopid.',
					"income"=>'.$money.',
					"balance"=>'.$money.',
					"content"=>"线下扫码支付收款'.$money.'，备注：'.$content.'"
				));
				M("apppush")->sendShop(array(
					"shopid"=>'.$shopid.',
					"table"=>"shop",
					"content"=>"您收到了'.$money.'元",
					"template_id"=>"neworder"
				));
			',
			"url"=>$backurl
		);
		 
		$orderdata=base64_encode(json_encode($orderdata));
		$order_price=$money;
		$orderinfo="商家线下扫码支付".$content;
 
		/*****插入充值表******/
		M("recharge")->insert(array(
			"userid"=>$userid,
			"money"=>$order_price,
			"pay_type"=>$pay_type,
			"orderno"=>$orderno,
			"orderinfo"=>$orderinfo,
			"type_id"=>1,
			"tablename"=>"",
			"dateline"=>time(),
			"status"=>2,
			"orderdata"=>$orderdata,
		));
		
		/*插入充值表结束*/
		
		$url="http://".$_SERVER['HTTP_HOST']."/api/".$pay_type."/".$pay_type.".php";
		$url.="?orderno=$orderno";
		$url.="&bank_type=".$bank_type;
		$url.="&order_product=".urlencode($order_product);
		$url.="&order_price=".$order_price;
		$url.="&order_info=".urlencode($order_info);
		$url.="&backurl=".base64_encode($backurl);
		header("Location: ".$url);
	}
}
?>