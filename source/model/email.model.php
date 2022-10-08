<?php
use PHPMailer\PHPMailer;
require_once ROOT_PATH."/skymvc/library/phpmailer/PHPMailer.php";
require_once ROOT_PATH."/skymvc/library/phpmailer/SMTP.php";
require_once ROOT_PATH."/skymvc/library/phpmailer/Exception.php";
require_once ROOT_PATH."/skymvc/library/phpmailer/OAuthTokenProvider.php";
require_once ROOT_PATH."/skymvc/library/phpmailer/OAuth.php";

class emailModel extends model{
	 
	public $emailServer=NULL;
	function __construct (){
		parent::__construct ();
		 
		$this->table="email";
	}
	
	public function setEmail($data){
		$this->emailServer=$data;
		return $this;
	}
	
	public function unSetEmail(){
		$this->emailServer=NULL;
		return $this;
	}
	
	 
	
	public function sendEmail( $smtpemailto, $mailsubject, $mailbody , $mailtype="html"){
		
		
		if(!$this->emailServer){
			$smptArr=array(
				"smtphost"=>SMTPHOST,
				"smtpport"=>SMTPPORT,
				"smtpemail"=>SMTPEMAIL,
				"smtpuser"=>SMTPUSER,
				"smtppwd"=>SMTPPWD
			);
		}else{
			$smptArr=$this->emailServer;
		
		}
		//开始发送
		$mail             = new PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->Host       = $smptArr['smtphost'];
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = PHPMailer\PHPMailer::ENCRYPTION_SMTPS;  
		$mail->Port       = $smptArr['smtpport'];
		$mail->Username   = $smptArr['smtpuser']; 
		$mail->Password   = $smptArr['smtppwd'];
		$mail->SetFrom($smptArr['smtpuser']);
		$mail->Subject    = $mailsubject;
		//$mail->SMTPDebug  = 2; 
		$address = $smtpemailto;
		$mail->AddAddress($address);
		$mail->MsgHTML($mailbody);  
		if(!$res=$mail->Send()) {
			 
		  return false;
		} else {
		  return true;
		} 
		

	}
 
	 
	
}
?>