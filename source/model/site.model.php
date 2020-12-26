<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class siteModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="site";
	}
	public function get(){
		$site=$this->selectRow("1");
		if(!$site){
			$this->insert(array(
				"siteid"=>1
			));
			$site=$this->selectRow("1");
		}
		$site["logo"]=images_site($site["logo"]);
		return $site;
	}
}

?>