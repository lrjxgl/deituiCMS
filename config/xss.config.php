<?php
class xssConfig{
	public static function init(){
		$xssConfig   = HTMLPurifier_Config::createDefault();
		//设置允许的html
		$cfg->set('HTML.Allowed', 'div,b,strong,i,em,a[href|title],ul,ol,li,br,span[style],img[width|height|alt|src]');
		return $xssConfig;
	}
}
