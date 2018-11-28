<?php
class recharge_chinabankControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	
	public function onNotify(){
		$key='test';
		$v_oid     =trim($_POST['v_oid']);      
		$v_pmode   =trim($_POST['v_pmode']);      
		$v_pstatus =trim($_POST['v_pstatus']);      
		$v_pstring =trim($_POST['v_pstring']);      
		$money=$v_amount  =trim($_POST['v_amount']);     
		$v_moneytype  =trim($_POST['v_moneytype']);     
		$remark1   =trim($_POST['remark1' ]);     
		$remark2   =trim($_POST['remark2' ]);     
		$v_md5str  =trim($_POST['v_md5str' ]); 
		$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
		if ($v_md5str==$md5string)
		{
			
		   if($v_pstatus=="20")
			{
			   //支付成功
				//商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
				//------------------------------
						//处理业务开始
						//------------------------------
						
						//处理数据库逻辑
						//注意交易单不要重复处理
						//注意判断返回金额
						 
						$row=M("recharge")->selectRow(array("where"=>" orderno='".$v_oid."' "));
						log_result($out_trade_no.' 验证订单中\r\n'); 
						if(empty($row) or $row['status']==1){
							log_result('您的充值订单失效了');
						}elseif(intval($row['money'])!=intval($v_amount)){
							log_result('订单金额不对\r\n');
						}else{//充值成功
							$this->loadControl("jfapi");
							$money=round($total_fee/100,1);
							$this->jfapiControl->userid=$row['userid'];
							$this->jfapiControl->addMoney(array(
								"money"=>$money,
								"content"=>"你使用财付通充值了￥".$money."，之前余额￥[oldmoney]，现在余额￥[newmoney]。", 
								"type_id"=>21,
								"ispay"=>2,
							));
							M("recharge")->update(array("status"=>1,"pay_orderno"=>$transaction_id)," id='".$row['id']."'" );
							
							//判断订单是否购物订单 如果是处理订单
							if(substr($out_trade_no,0,2)=='o_'){
							
								$order=M("order")->selectRow(array("orderno='".$out_trade_no."' "));
								$this->loadControl("jfapi");
								//添加金钱消费记录		
								$this->jfapiControl->addMoney(array(
									"money"=>"-".$order['money'],
									"type_id"=>5,
									"ispay"=>1,
									"content"=>"您购买了商品,消耗了".$order['money']."元，之前有[oldmoney]元，目前还剩[newmoney]元",
								));
								M("order")->update(array("ispay"=>1),"order_id=".$order['order_id']);
			
							}
							
							log_result($out_trade_no."充值成功");
						}
						//------------------------------
						//处理业务完毕
						//------------------------------
			}
		  echo "ok";
			
		}else{
			echo "error";
		}    
	}
	
	public function onReturn(){
		$key='test';
		$v_oid     =trim($_POST['v_oid']);      
		$v_pmode   =trim($_POST['v_pmode']);      
		$v_pstatus =trim($_POST['v_pstatus']);      
		$v_pstring =trim($_POST['v_pstring']);      
		$v_amount  =trim($_POST['v_amount']);     
		$v_moneytype  =trim($_POST['v_moneytype']);     
		$remark1   =trim($_POST['remark1' ]);     
		$remark2   =trim($_POST['remark2' ]);     
		$v_md5str  =trim($_POST['v_md5str' ]); 
		$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
		if ($v_md5str==$md5string)
		{
			
		   if($v_pstatus=="20")
			{
			   //支付成功
				//商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
				
			}
		  echo "ok";
			
		}else{
			echo "error";
		}
	}
	
}
?>