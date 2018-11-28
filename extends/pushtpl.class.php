<?php
class pushTpl{
 
	public static function wxList($key=""){
		$option=array(
			"neworder"=>"QP8FgA400IFGM2uPlf7UM6oFg4pLVLFnXVKmQ1CmtAM",
			"updateorder"=>"QP8FgA400IFGM2uPlf7UM6oFg4pLVLFnXVKmQ1CmtAM",
			"newuser"=>"XKpjqwevkoRZOskCs8PMb0HlGG3IlNN9G6Lx6QR-zKQ"
			
		);
		if(!empty($key)){
			return $option[$key];
		}else{
			return $option;
		}
		
	} 
}
?>