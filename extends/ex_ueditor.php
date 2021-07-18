<?php
 function ueditor_replace($content){
	 $content=str_replace("<video ",'<video webkit-playsinline="true" playsinline="true" X5-playsinline="true" ',$content);
 }
?>