<?php
	class skinscolorControl extends skymvc{
		public function onDefault(){
			$color="";
			if(defined("SKINSCOLOR")){
				$color=SKINSCOLOR;
			}
			$fttype="color";
			if(defined("SKINS_FTTYPE")){
				$fttype=SKINS_FTTYPE;
			}
			$url="https://www.deituicms.com/skinscolor/skins.php?";
			$url.="color=".$color;
			$url.="&fttype=".$fttype; 
			//echo $url;
			header("Content-type:text/css;");
			$file="temp/css.".$color.$fttype.".css";
			if(file_exists($file)){
				
				echo file_get_contents($file);
				exit;
			} 
			$css=file_get_contents($url);
			 
			file_put_contents($file,$css);
			 
			echo $css;
		}
	}
?>