<?php
	class pageTplModel extends model{
		 
		public function __construct (){
			parent::__construct ();
			 
			$this->table="pagetpl";
		}
		
		public function get($m,$a,$tpl=""){
			if(empty($tpl)) $tpl="$m/$a.html";
			$row=M("pagetpl")->selectRow("m='".sql($m)."' AND a='".sql($a)."' ");
			if($row){
				$tpl=$row['tpl'];
			}
			return $tpl;
		}
		
	}
?>