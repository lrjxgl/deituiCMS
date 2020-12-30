<?php
	class pageTplModel extends model{
		public $table="pagetpl";
		public function __construct(){
			parent::__construct();
	
			
		}
		
		public function get($m,$a,$tpl=""){
			if(empty($tpl)) $tpl="$m/$a.html";
			$row=M("pagetpl")->selectRow("m='".sql($m)."' AND a='".sql($a)."' ");
			if($row){
				$tpl=$row['tpl'];
			}
			$tpl=str_replace("../","",$tpl);
			return $tpl;
		}
		
	}
?>