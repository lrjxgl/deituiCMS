<?php
class rechargeControl extends skymvc{
	public $userid;
	public function __construct(){
		parent::__construct();		
	}
	
	public function onInit(){
		M("login")->checkLogin();
		$this->userid=M("login")->userid;	
	}
	
	public function onDefault(){
		
		if(get('pay_type')){
			$this->onRecharge();
			exit();
		}
		 
		$order_id=get('order_id','i');
		if($order_id){
			$table=get_post("table",'h');
			if($table){
				$this->smarty->assign(array(
					"ordertable"=>$table
				));
			}
			 
			switch($table){
				case "order":
						$table_order="order";
						$table_order_address="order_address";
					break;
				default:
						$table_order=$table."_order";
						$table_order_address=$table."_order_address";
					break;
			}
			$user=M("login")->getUser();
			$data=M($table_order)->selectRow(array("where"=>"order_id=".$order_id));
			if(empty($data)) $this->goall("参数出错",1);
			if($data['status']!=0){
				$this->goAll("当前订单无法进行支付",1);
			}
			//$addr=M($table_order_address)->selectRow(array("where"=>"order_id=".$order_id,"order"=>"id DESC"));
			 
			if(empty($data)) $this->goall("参数出错",1);
			if($data['ispay']==2) $this->goall("该订单已支付",1);
			 
			$pay_type_list= pay_type_list(0,array("unpay"=>1));
			 
			
		}else{
			$pay_type_list= pay_type_list(0,array("unpay"=>1,"fenqi"=>1));
		}
		
		$this->smarty->goassign(array(
				"data"=>$data,
				//"addr"=>$addr,
				"order_status_list"=>$order_status_list,
				"order_type_list"=>$order_type_list,
				"order_ispay"=>$order_ispay,
				"table"=>$table,
				"pay_type_list"=>$pay_type_list,
				"backurl"=>base64_encode(HTTP_HOST."/index.php?m=user"),
			));
		
		if($order_id){
			$this->smarty->display("recharge/order.html");
		}else{
			$this->smarty->display("recharge/index.html");
		}
		
	}
	
	public function onMy(){
		$start=get('per_page','i');
		$limit=20;
		$where=" userid=".$this->userid;
		$url=APPINDEX."?m=recharge&a=my";
		$option=array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
		);
		$rscount=true;
		$data=M("recharge")->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$v['timeago']=timeago($v['dateline']);
				$v['status_name']=$v['status']==1?"成功":"失败";
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$per_page=$start+$limit;
		$per_page=$per_page>=$rscount?0:$per_page;
		$this->smarty->goassign(array(
			"list"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist,
			"per_page"=>$per_page
		));
		$this->smarty->display("recharge/my.html");
	}
	
	
	 
	
	
	public function onRecharge(){
		$order_id=get_post('order_id','i');
		$order_des="网站充值";
		if($order_id){
			$table=get_post("table",'h');
			$order_des="订单支付";
			switch($table){
				case "order":
						$table_order="order";
						$table_order_address="order_address";
					break;
				default:
						$table_order=$table."_order";
						$table_order_address=$table."_order_address";
					break;
			}
			$data=M($table_order)->selectRow(array("where"=>"order_id=".$order_id));
			if(empty($data)) $this->goall("参数出错",1);
			$data['table']=$table;
			$orderdata=base64_encode(json_encode($data));
			if($data['ispay']==2) $this->goall("该订单已支付",1);
			$backurl="/index.php/{$table_order}/order_id-".$order_id;
		}else{
			$backurl="/index.php/recharge/";
		}
		$pay_type=get_post('pay_type','h');
		$orderno="re".date("YmdHis").M("login")->userid;//根据实际情况一个用户1s不可能重复下订单
		$order_product=post('product_name')?post('product_name'):$order_des;
		$order_price=$data?$data['money']:post('order_price',"r",2);
		$order_info=post('order_info','h');
		$bank_type=post('bank_type');
		/*****插入充值表******/
		M("recharge")->insert(array(
			"userid"=>$this->userid,
			"money"=>$order_price,
			"pay_type"=>$pay_type,
			"orderno"=>$orderno,
			"orderinfo"=>$order_product."<br>".$order_info, 
			"type_id"=>1,
			"tablename"=>$table?$table:"",
			"dateline"=>time(),
			"status"=>2,
			"orderdata"=>$orderdata,
		));
		
		/*插入充值表结束*/
		
		//$url="http://".$_SERVER['HTTP_HOST']."/api/".$pay_type."/".$pay_type.".php";
		$url=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/index.php?m=recharge_{$pay_type}&a=go";
		$url.="&orderno=$orderno";
		$url.="&bank_type=".$bank_type;
		$url.="&order_product=".urlencode($order_product);
		$url.="&order_price=".$order_price;
		$url.="&order_info=".urlencode($order_info);
		$url.="&backurl=".urlencode($backurl);
		
		header("Location: ".$url);
		exit;
	}
	
}

?>