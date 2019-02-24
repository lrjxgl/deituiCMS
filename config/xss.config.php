<?php
class xssConfig{
	public static function init(){
		$xssConfig   = HTMLPurifier_Config::createDefault();
		//设置允许的html
		//$xssConfig->set("HTML.Allowed","div,span");
		return $xssConfig;
	}
}
