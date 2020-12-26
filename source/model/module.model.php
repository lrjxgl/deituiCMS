<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class moduleModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="module";
	}
	public function isInstall($module){
		$file="module/{$module}/install.lock";
		if(file_exists($file)){
			
			return true;
		}
		return false;
	}
}

?>