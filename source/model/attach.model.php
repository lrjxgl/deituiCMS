<?php
class attachModel extends model{
	public $table="attach";
	public function __construct(){
		parent::__construct();
	}
	
	public function add($ops){
		if(!isset($ops["url"]) && empty($ops["url"]) && file_exists($ops["url"])){
			return false;
		}
		$data=array();
		$data["file_url"]=$ops["url"];
		$data["file_name"]=basename($ops["url"]);
		$data["file_size"]=filesize($data["file_url"])/1024;
		$data["file_type"]=strtolower(trim(substr(strrchr($ops["url"], '.'), 1)));
		$data["file_group"]=$this->group($data["file_type"]);
		if(isset($ops["userid"])){
			$data["userid"]=$ops["userid"];
		}else{
			$data["userid"]=M("login")->userid;
		}
		$data["dateline"]=time();
		$this->insert($data);
		
	}
	public function group($type){
		switch($type){
			case "png":
			case "bmp":
			case "jpg":
			case "jpeg":
			case "gif":
			case "webp":
				return "img";
				break;
			case "mp3":
			case "wma":
			case "aac":
			case "wav":
			case "midi":
				return "audio";
				break;
			case "mp4":
			case "wmv":
			case "flv":
			case "rm":
			case "mpeg":
			case "avi":
			case "3gp":
				return "video";
				break;
			case "txt":
			case "doc":
			case "docx":
			case "csv":
			case "xsl":
				return "text";
				break;
			case "zip":
			case "rar":
				return "zip";
				break;
			default:
				return "other";
				break;
		}
	}
	
}