<?php
class inviteControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onInit(){
		if(!in_array(get('a'),array('ewm'))){
			M("login")->checkLogin();
		}
		
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$this->smarty->assign(array(
			"invitecode"=>M("user_invitecode")->getCode($userid), 
			"userid"=>$userid
		));
		$this->smarty->display("invite/index.html");
	}
	public function onMy(){
		$userid=M("login")->userid;
		$rscount=true;
		$list=M("user")->Dselect(array(
			"where"=>"invite_userid=".$userid,
			"fields"=>"userid,nickname,user_head"
		),$rscount);
		
		$iaccount=M("invite_account")->get($userid);
		$money=$iaccount["income"];
	 	$user=M("user")->getUser($userid,"userid,nickname,money,user_head");
		$this->smarty->goassign(array(
			"list"=>$list,
			"userid"=>$userid,
			"user"=>$user,
			"rscount"=>$rscount,
			"money"=>$money,
			"iaccount"=>$iaccount,
			"invitecode"=>M("user_invitecode")->getCode($userid), 
			"ewm"=>HTTP_HOST."/index.php?m=invite&a=ewm&userid=".$userid
		));
		$this->smarty->display("invite/my.html");
	}
	
	 
	
	public function onEwm(){
		$this->loadClass("qrcode",false,false);
		$userid=M("login")->userid;
		if(!$userid){
			$userid=get("userid","i");
		}
		$user=M("login")->getUser($userid);
		ob_start();
		$url="http://".$_SERVER['HTTP_HOST']."/index.php?invite_uid=".$userid;
		QRcode::png($url,false,QR_ECLEVEL_L,6);
		$ewmdata=ob_get_contents();
		ob_end_clean();
		
		//header("Content-type:image/jpg");
		$w=640;
		$h=200;
		$im=imagecreatetruecolor($w,$h);
		$whitebg = imagecolorallocatealpha($im,250,250,250,0);
		imagefill($im,0,0,$whitebg);
		$ewm=imagecreatefromString($ewmdata);
		$ewmx=imagesx($ewm);
		$ewmy=imagesy($ewm);
		imagecopyresampled($im,$ewm,5,5,0,0,175,175,$ewmx,$ewmy);
		//文字
		$font=ROOT_PATH."/static/msyh.ttf";
		$black = imagecolorallocate($im, 32, 32, 32);
		imagettftext($im, 16, 0, 200, 45, $black, $font, "我是".$user["nickname"]);
		imagettftext($im, 16, 0, 200, 85, $black, $font, "得推网能不仅省钱还能赚零花钱");
		imagettftext($im, 16, 0, 200, 125, $black, $font, "快来关注一下吧");
		imagejpeg($im);
	}
}
?>