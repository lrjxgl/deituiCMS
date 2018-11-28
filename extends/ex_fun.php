<?php
function myDiy($str){
	echo myDiy();
}
function pay_type_list($moneypay=1,$un=array()){
	$data=array();
	 
	if(!INWEIXIN && ALIPAY){
		$data['alipay']="支付宝";
	}
	if(MONEYPAY && $moneypay){
		$data['moneypay']='余额支付';
	}
	if(INWEIXIN && WXPAY){
		$data['wxpay']="微信支付";
	}
	
 
	
	if(!empty($un)){
		$data=array_diff_key($data,$un);
	}
	return $data;
}
function hex2rgb($hexColor) {
		$hexColor=$color = str_replace('#', '', $hexColor);
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

function loadEditor($all=1){
	 
		echo '
		<script type="text/javascript" src="/plugin/ueditor/ueditor.config.js?v2"></script>';
		if($all){
			echo '<script type="text/javascript" src="/plugin/ueditor/ueditor_all.js"></script>';
		}else{
			echo '<script type="text/javascript" src="/plugin/ueditor/ueditor_simple.js"></script>';
		}
echo '<script language="javascript" src="/plugin/ueditor/ueditor.all.min.js?v2"></script>';
	
} 
?>