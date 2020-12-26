<?php
class dataapiModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="dataapi";
	}
	
	public function type_list(){
		return array(
			1=>"固定数据"
		);
	}
	
	public function getWord($word){
		$word=addslashes($word);
		return $this->selectRow(array("where"=>" word='".$word."' AND status=2 " ));
	}
}

?>