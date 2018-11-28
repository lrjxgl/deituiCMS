<?php
define("WEIXIN_MB_MSG_OPEN",1);
class pushControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
		require "extends/pushtpl.class.php";		
	}
	
	public function onDefault(){
		$key="push_plan";
		if(1==1 || !$res=cache()->get($key)){
			$this->onPlan();
			cache()->set($key,1,10);
		}
	}
	
	
	public function sendGeTui($plan,$app){
		
		$title=urlencode("商家推送");
		$content=urlencode($plan['content']);
		$json=curl_get_contents("http://".DOMAIN."/api/getui/demo.php?appid=".$app['appid']."&mtype=".$app['typeid']."&cid=".$app['clientid']."&token=".$app['token']."&title=".$title."&content=".$content."");
		$data=json_decode($json,true);
		if($data['result']){
			if($data['result']=='ok'){
				//如果推送成功 则删除推送计划
				M("apppush_plan")->delete("id=".$plan['id']);
			}else{
				//更新状态
				M("apppush_plan")->update(array(
					"status"=>2
				),"id=".$plan['id']);
			}
		}
	}
	
	
	public function SendWeiXin($plan,$app){
		if(empty($plan['content'])) return false;
		$wx=M("weixin")->selectRow(array("where"=>"","order"=>"id DESC"));
		$data=get_weixin_access_token();
		$token=$data['access_token'];
		$data=array(
			"touser"=>$app['openid'],
			"msgtype"=>"text",
			"text"=>array(
				"content"=>$plan['content']
			)
		);
		
		$json=curl_post("https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token,zh_json_encode($data));
		
		$data=json_decode($json,true);
		 
		if(isset($data['errcode']) && $data['errcode']==0){
			M("apppush_plan")->delete("id=".$plan['id']);
		}else{
			M("apppush_plan")->update(array(
					"dateline"=>time(),
					"errmsg"=>sql($json)
					//"status"=>0
				),"id=".$plan['id']);
		}
		
		  
	}
	
	/****发送模板消息****/
	/*
	   $json=array(
			"touser"=>"oMrliwPpsCCr_DNuBG4lQAHafugQ",
			"template_id"=>"HExcAkt25-GPrqoJXrk91_luGk5bMyvhElMAwUEJQfI",
			"url"=>"http://weixin.qq.com/download",
			"data"=>array(
				"first"=>array("value"=>"尊敬的张三先生，您好！您认购的《资金信托计划》已确认认购成功，详情如下："),
				"type"=>array("value"=>"bbb"),
				"share"=>array("value"=>"ccccccc"),
				"remark"=>array("value"=>"dddddd"),
			)
		);
	 */
	public function SendWeiXinMb($plan,$app){
		if(empty($plan['content'])) return false;
		$wx=M("weixin")->selectRow(array("where"=>"","order"=>"id DESC"));
		$data=get_weixin_access_token();
		$token=$data['access_token'];
		//require "config/weixin_mb.php";
		$con=str2arr($plan['content']);
		//根据模板判断发送内容
		$sendContent=array();
		switch($plan['template_id']){
			case "newuser":
				$sendContent=array(
					"first"=>array("value"=>$con['first']),
					"keyword1"=>array("value"=>$con['keyword1']),
					"keyword2"=>array("value"=>$con['keyword2']),
					"remark"=>array("value"=>$con['remark'])			 
				);
				break;
			default:
				$sendContent=array(
					"first"=>array("value"=>"您好"),
					"OrderSn"=>array("value"=>$con['orderno']),
					"OrderStatus"=>array("value"=>"有效"),
					"remark"=>array("value"=>$con['content'])			 
				);
				break;
		} 
		$json=array(
			"touser"=>$app['openid'],
			//template_id 微信公众号后台申请 可以搜索订单状态更新
			"template_id"=>pushtpl::wxlist($plan['template_id']),
			"url"=>$plan['url'],
			"data"=>$sendContent
		);
		$json=wx_mb_send($token,$json);
		 
		$data=json_decode($json,true);
		
		if(isset($data['errcode']) && $data['errcode']==0){
			M("apppush_plan")->delete("id=".$plan['id']);
		}else{
			M("apppush_plan")->update(array(
					"dateline"=>time(),
					"errmsg"=>sql($json)
					//"status"=>0
				),"id=".$plan['id']);
		}
		
		  
	}
	 
	
	public function onPlan($status=0){
		$key="index_push_plan_".$status;
		if(!cache()->get($key)){
			$time=($status+1)*2;
			cache()->set($key,1,$time);
			$data=M("apppush_plan")->select(array(
				"where"=>" status=".$status." ",
				"order"=>" dateline ASC",
				"limit"=>10
			));
			if($data){
				foreach($data as $v){
					$pids[]=$v['pid'];
					
					M("apppush_plan")->update(array(
						"status"=>$status+1
					),"id=".$v['id']);
					
				}
				$apps=M("apppush")->getListByIds($pids);
				
				foreach($data as $v){
					
					$app=$apps[$v['pid']];
					
					if($app['appname']=='getui'){
						$this->sendGeTui($v,$app);
					}elseif($app['appname']=='weixin'){
						if(WEIXIN_MB_MSG_OPEN==1){
							$this->SendWeiXinMb($v,$app);
						}else{
							$this->sendWeixin($v,$app);
						}
						
						
					}
				}
			}
		}
		
		echo "推送成功";
		
	}
	
	
	public function onSendSms(){
		$data=M("smspush")->select(array(
			"where"=>"1",
			"order"=>" dateline ASC",
			"limit"=>10
		));
		if($data){
			foreach($data as $v){
				$smsdata=unserialize(base64_decode($v['content']));
			 	 
				$res=M("email")->sendSms($v['telephone'],$smsdata);
				if($res){
					 
					M("smspush")->delete("id=".$v['id']);
				}else{
					if($v['sendnum']>5){
						M("smspush")->delete("id=".$v['id']);
					}else{
						M("smspush")->update(array(
							"dateline"=>time(),
							"sendnum"=>$v['sendnum']+1,
						),"id=".$v['id']);
					}
				}
			}
		}
		
		echo "短信计划执行完毕";
	}
	
}
?>