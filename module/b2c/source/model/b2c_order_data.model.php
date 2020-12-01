<?php
class b2c_order_dataModel extends model{
	public $table="mod_b2c_order_data";
	public function __construct(){
		parent::__construct();
	}
	
	public function getListByOrderIds($oids){
		$rss=$this->select(array(
			"where"=>" orderid in("._implode($oids).") ",
			"fields"=>"orderid,content"
		));
		$data=array();
		if($rss){
			foreach($rss as $k=>$v){
				$data[$v['orderid']]=json_decode(base64_decode($v['content']),true);
			}
			return $data;
		}
		return false;
	}
	
	public function get($orderid){
		$row=$this->selectRow("orderid=".$orderid);
		if(empty($row)) return false;
		return json_decode(base64_decode($row['content']),true);
	}
	
}
?>