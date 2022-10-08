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
		QRCODE::png($content,false,QR_ECLEVEL_L,18);
	}
	public function onEwm(){
		echo $content=get("content","h");
		$this->loadClass("qrcode",false,false);
		//QRCODE::png($content,false,QR_ECLEVEL_L,6);
	}
	
	public function onWxMini(){
		$post=array(
			"page"=>"gread/gread/index",
			"scene"=>"invite_userid=1",
			"width"=>480
			 
		);
		//ex_wx_mini::createCode($post); 
		ex_wx_mini::createTimeCode($post);
		
	} 
}
?>