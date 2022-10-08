<?php
class open_mapModel extends model{
	public $table="open_map";
	public function get($com='gaode',$app='web'){
		$row=$this->selectRow(array(
			"where"=>"map_com='".$com."' AND map_app='".$app."' AND status=1 ",
			"order"=>"rand() "
		));
		return $row;
	}
	
	 
	
}