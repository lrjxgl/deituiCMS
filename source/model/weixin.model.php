<?php
class weixinModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="weixin";
	}
	
	public function id_list($option=array(),&$rscount=false){
		$data=$this->select($option,$rscount);
		if($data){
			foreach($data as $k=>$v){
				$t_d[$v['id']]=$v;
			}
			return $t_d;
		}
	}
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
	public function SendWeiXinMb($msg=array()){
		$wx=M("weixin")->selectRow(array("where"=>"","order"=>"id DESC"));
		$data=get_weixin_access_token();
		$token=$data['access_token'];
		$userid=$msg['userid'];
		$template_id=isset($msg['template_id'])?$msg['template_id']:'';
		$json=array(
			"touser"=>$touser,
			"template_id"=>"HExcAkt25-GPrqoJXrk91_luGk5bMyvhElMAwUEJQfI",
			"url"=>"http://weixin.qq.com/download",
			"data"=>array(
				"first"=>array("value"=>"尊敬的张三先生，您好！您认购的《资金信托计划》已确认认购成功，详情如下："),
				"type"=>array("value"=>"bbb"),
				"share"=>array("value"=>"ccccccc"),
				"remark"=>array("value"=>"dddddd"),
			)
		);
		$json=wx_mb_send($token,$msg);	
		 
		 
	}
	
}

?>