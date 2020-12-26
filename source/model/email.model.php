<?php
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
		C()->loadClass("phpmailer",false,false);
		
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
		$mail             = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host       = $smptArr['smtphost'];
		$mail->SMTPAuth   = true;
		$mail->Port       = $smptArr['smtpport'];
		$mail->Username   = $smptArr['smtpuser']; 
		$mail->Password   = $smptArr['smtppwd'];
		$mail->SetFrom($smptArr['smtpemail']);
		$mail->Subject    = $mailsubject;

		$address = $smtpemailto;
		$mail->AddAddress($address);
		$mail->MsgHTML($mailbody);  
		if(!$mail->Send()) {
		  return false;
		} else {
		  return true;
		} 
		

	}
 
	 
	
}
?>