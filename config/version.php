<?php
class cmsVersion{
	public static function get(){
		return array(
			"version"=>"deituiCMS",
			"version_num"=>3.1,
			"onlineupdate"=>"https://www.deituicms.com/index.php?m=newversion&a=update&product=deituiCMS",
			"checkversion"=>"https://www.deituicms.com/index.php?m=newversion&product=deituiCMS",
			"checkshouquan"=>"https://www.deituicms.com/index.php?m=newversion&a=checkshouquan&product=deituiCMS",
			"description"=>"deituiCMS包含绝大多数网站所需要的基础功能，采用基础功能+插件模式架构，通过插件可以轻松扩展无限的功能。",
			"mds"=>array()
		);
	}
}
define("POWEREDBY","----powered by www.deituicms.com");
?>