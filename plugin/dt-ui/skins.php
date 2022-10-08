<?php
$color=$_GET['color'];

$css=<<<eof
/**头部风格***/
.header,.header-show{
 background-color: #basecolor;	
 box-shadow: none;  
}
.header-back:after,.header-title{color: #fff;}

.header-search{
	background-color: rgba(0,0,0,.1);
	border: 0 !important;
	color: #fff;
}
.header-search-icon{
	color: #fff;
}
.header-search-btn{
	background-color: #basecolor;
    color: #fff;
}
.header-right{
	color: #fff;
}
.header-right-btn{
	color: #fff;
	border-color: #fff;
}
/*****底部风格****/
.footer{
	background-color: #basecolor;
}
.footer-item,.footer-item:before{
	color: #e0e0e0;
}
.footer-add:after{
	background-color: #e45538;
	color: #fff;
}
.footer-active, .footer-active:before {
    background-color: #basecolor-active;
}
/*********/
.btn-primary,.btn-row-submit,.input-flex-btn{
	background-color: #basecolor;
	border-color:#basecolor;
}
.cart-list-btn{
	background-color:#basecolor !important;
}

.btn,.btn-buy{
	background-color: #basecolor;
}
eof;

$rgb=hex2rgb($color);
if($rgb['g']>60){
	$rgb['g']=$rgb['g']-20;	
}else{
	$rgb['g']=$rgb['g']+30;	
}

$hex=RGBToHex("rgb({$rgb['r']},{$rgb['g']},{$rgb['b']})");
$css=str_replace("#basecolor-active",$hex,$css);
$css=str_replace("basecolor",$color,$css);
header("Content-type:text/css;");
echo $css;



function RGBToHex($rgb){
        $regexp = "/^rgb\(([0-9]{0,3})\,\s*([0-9]{0,3})\,\s*([0-9]{0,3})\)/";
        $re = preg_match($regexp, $rgb, $match);
        $re = array_shift($match);
        $hexColor = "#";
        $hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        for ($i = 0; $i < 3; $i++) {
            $r = null;
            $c = $match[$i];
            $hexAr = array();
            while ($c > 16) {
                $r = $c % 16;
                $c = ($c / 16) >> 0;
                array_push($hexAr, $hex[$r]);
            }
            array_push($hexAr, $hex[$c]);
            $ret = array_reverse($hexAr);
            $item = implode('', $ret);
            $item = str_pad($item, 2, '0', STR_PAD_LEFT);
            $hexColor .= $item;
        }
        return $hexColor;
    }
    
    function hex2rgb($hexColor) {
        $color = str_replace('#', '', $hexColor);
        if (strlen($color) > 3) {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        } else {
            $color = $hexColor;
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }
?>