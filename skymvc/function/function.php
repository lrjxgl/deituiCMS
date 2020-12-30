<?php
/**
*函数库核心文件
*/
/*全局变量定义*/
function G($var){
	return $GLOBALS[$var];
}
 

/*运营时间*/
function running_time(){
	return round(microtime(true)-B_TIME,4);
}
/*内存占用*/
function memory_use(){
	return intval(memory_get_usage()/1024);
}
/*输出测试数据*/
function skyTest(){
	 
	echo "服务器：".$_SERVER['SERVER_SOFTWARE']."<br>";
	 
	echo "php模式：".php_sapi_name()." <br>";
	echo "SQL执行时间：".G('query_time')."<br>";
	echo "程序运营时间：".running_time()."<br>";
	echo "程序内存使用：PID.".getmypid().",占用内存：".memory_use()."KB<br>";
	echo "SQL执行次数:".G('skysqlnum')."<br>";	
	echo "SQl执行语句：".G('skysqlrun')."<br>";
}
/**页面测试记录时间**/
function skymvc_test_page_auto(){
	if(isset($_GET['skymvc_test_page_auto'])){
		$t=microtime(true)-B_TIME;
		skyLog("test_page.txt","当前页面花费时间：".$t."秒");
	}
}

/**系统日志**/
function skyLog($file,$content){
	$file=ROOT_PATH."temp/log/".$file;
	umkdir(ROOT_PATH."temp/log/");
	if(file_exists($file)){
		if(filesize($file)>1024*1024*300){
			rename($file,ROOT_PATH."temp/log/".str_replace(".",date("Ymdhis").".",basename($file)));
		}
		clearstatcache() ;
	}
	
	$fp=fopen($file,"a+");
	
	fwrite($fp,"\r\n---".date("Y-m-d H:i:s")."--".$_SERVER['REQUEST_URI']."--\r\n".$content."\r\n");
	fclose($fp);	
}


/*
构造表格前缀 函数
*/
function table($tb)
{
	return TABLE_PRE.$tb;
}

/*
*字符串处理函数库
*/
function nrexplode($str){
	$str=str_replace("\r\n","\n",$str);
	return explode("\n",$str); 
}

function texplode($str){
	$t_d=explode(" ",$str);
	if($t_d){
		foreach($t_d as $v){
			if(!empty($v)){
				$data[]=$v;
			}
		}
	}
	return $data;
}

//获取小数点
function numdot($str){
	$s=explode(".",$str);
	if(isset($s[1])){
		return $s[1];
	}else{
		return $s[0];
	}
}
function sql($value){
	return newaddslashes($value);
}
function html($str){
	$str=htmlspecialchars($str);
	return $str;
}
function ustrip_tags($str){	
	$arr=array("&amp;","&nbsp;","&ldquo;","&rdquo;","&hellip;");
	$str=str_replace($arr,"",$str);
	$str=strip_tags($str);
	return $str;
}
function get($k,$format="x",$len=0){
        if(isset($_GET[$k])){
				$_GET[$k]=get_format($_GET[$k],$format,$len);
				         
                return $_GET[$k];                
        }elseif($format=='i'){
			$_GET[$k]=0;
			return 0;
		}
}
function post($k,$format="x",$len=0){
        if(isset($_POST[$k])){         
                $_POST[$k]=get_format($_POST[$k],$format,$len);
				return $_POST[$k];                
        }elseif($format=='i'){
			$_POST[$k]=0;
			return 0;
		}
}

function get_post($k,$format="x",$len=0){
        if(isset($_GET[$k])){         
                return get_format($_GET[$k],$format,$len);                
        }
        if(isset($_POST[$k])){         
                return get_format($_POST[$k],$format,$len);                
        }
		if($format=='i'){
			return $_GET[$k]=0;
		}
}

function get_format($str,$format='',$len=0){
        if(!$format) return $str;

        if(is_array($str)){
                foreach($str as $k=>$v){
						$str[$k]=get_format($v,$format,$len);
                }
                return $str;
        }else{
                return str_format($str,$format,$len);
        }
         
}

function str_format($str,$format='',$len=0){
        if(!$format) return $str;
        $str=trim($str);
        $arr=str_split($format);
        foreach($arr as $html){
                switch($html){
					case "i":
							if($str>2147483647){
								$str=round($str,$len);
							}else{
								$str=intval($str);
							}
							break;
					case "f":
								$str=floatval($str);
							break;
					case "h":
							$str=htmlspecialchars($str);
							break;
					case "s":
							$str=strip_tags($str);
							break;
					case "x":
							
							$str=removeXSS($str);
							break;
					case "r":
							$str=round($str,$len);
							break;
					case "a"://返回全部
					
							break;
                }
        }
        return $str;
}

function get_post_Html($arr){
	if(!empty($arr)){
		return is_array($arr) ? array_map('get_post_Html', $arr) : htmlspecialchars(trim($arr));
	}
}

function arrRemoveXss($arr){
	if(!empty($arr)){
		return is_array($arr) ? array_map('arrRemoveXss', $arr) : removeXSS(trim($arr));
	}
}
function removeXSS($str){
	
	if(!empty($_POST)){
		
		if(function_exists("extends_removeXss")){
			return extends_removeXss($str);
		}else{
			return nRemoveXSS($str);
		}
	}else{
		return nRemoveXSS($str);
	}
	
}

function nRemoveXSS($str){
	
	$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link',  'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound','base','alert');
	$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);
	$x_r="(".implode("|",$ra).")";
	//过滤script 不允许<>
	$str=preg_replace("/<script([^>]*)>/iUs","&ltscript\\1&gt",$str);
	$str=str_replace("</script>","&lt/script&gt",$str);
	//过滤a 允许<>
	while(@preg_match("/<([^>]*){$x_r}([^>]*)>/iUs",$str)){
			$str=preg_replace("/<([^>]*){$x_r}([^>]*)>/iUs","<\\1xss_\\3>",$str);
	}
	return $str;
}
 

/**
* 将数组元素格式化成类似 '1','2','3' 的字符串
* @return STRING 字串 否则为 NULL
*/
function _implode($array) {
	if(!empty($array)) {
		return "'".implode("','", is_array($array) ? $array : array($array))."'";
	} else {
		return '';
	}
}


/**
* 递归方式的对变量中的特殊字符进行转义
*
* @access  public
* @param   mix     $value
*
* @return  mix
*/
function addslashes_deep($value)
{
	if (empty($value))
	{
		return $value;
	}
	else
	{
		return is_array($value) ? array_map('addslashes_deep', $value) : addslashes(trim($value));
	}
}


function stripslashes_deep($value)
{
	if (empty($value))
	{
		return $value;
	}
	else
	{
		return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes(trim($value));
	}
}
function newaddslashes($value){		 
		if(empty($value)){
			return $value;
		}else{
			if(is_array($value)){
				 return array_map('newaddslashes', $value);
			}else{				
				$value=stripslashes($value);
				$value=str_replace("\'","'",$value);  
				$value=str_replace('\"','"',$value);
				$value=addslashes(trim($value));				
				return $value;	
			}
		}	 
}



function ev($str){
	eval($str);
}

//截取字符串函数
function cutstr($string, $length, $dot = ' ...') {
	if(strlen($string) <= $length) {
		return $string;
	}
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	$n = $tn = $noc = 0;
	while($n < strlen($string)) {	
		$t = ord($string[$n]);
		if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1; $n++; $noc++;
		} elseif(194 <= $t && $t <= 223) {
			$tn = 2; $n += 2; $noc += 2;
		} elseif(224 <= $t && $t < 239) {
			$tn = 3; $n += 3; $noc += 2;
		} elseif(240 <= $t && $t <= 247) {
			$tn = 4; $n += 4; $noc += 2;
		} elseif(248 <= $t && $t <= 251) {
			$tn = 5; $n += 5; $noc += 2;
		} elseif($t == 252 || $t == 253) {
			$tn = 6; $n += 6; $noc += 2;
		} else {
			$n++;
		}	
		if($noc >= $length) {
			break;
		}	
	}
	if($noc > $length) {
		$n -= $tn;
	}
	$strcut = substr($string, 0, $n);		
	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}


/**
@字符转换函数
*/
function iconvstr($from,$to,$str)
{
	if(empty($str))
	{
		return false;
	}
	if(is_array($str))
	{
		foreach($str as $key=>$val)
		{
		$string[$key]=iconvstr($from,$to,$val);
		}		
	}else
	{
		$string=iconv($from,$to,$str);
	}
	
	return $string;
}

//移除链接
function removelink($c)
{
	return preg_replace("/<a.*>(.*)<\/a>/iU","\\1",$c);
}

/*加密函数*/
function umd5($str)
{
	return md5(md5($str));	
}

function array_lastnum($arr){
	if(!is_array($arr)) return intval($arr);
	if($arr){
		$len=count($arr)-1;
		for($i=$len;$i>=0;$i--){
			if($arr[$i]>0){			 
				return $arr[$i];
			}
		}
	}else{
		return 0;
	}
}



/*保持中文格式 转化*/
function zh_json_encode($data){
		$data=array_urlencode($data);
		$data=json_encode($data);
		$data=array_urldecode($data);
		return $data;
}

function array_urlencode($data){
		if(is_array($data)){
			foreach($data as $k=>$v){
				$data[$k]=array_urlencode($v);
			}
			return $data;
		}else{
			return urlencode($data);
		}
}

function array_urldecode($data){
		if(is_array($data)){
			foreach($data as $k=>$v){
				$data[$k]=array_urldecode($v);
			}
			return $data;
		}else{
			return urldecode($data);
		}
}
/**
*@json 处理jsonp和json
**/
function sky_json_encode($data){
	if(get_post('jsonp')){
		return get_post('callback','h')."(".json_encode($data).")";
	}else{
		return json_encode($data);
	}
}

function sky_json_decode($data){
	return json_decode($data,true);
}
/**数组 字符串转换***/
function arr2str($arr){
	return urlencode(base64_encode(json_encode($arr)));
}
function str2arr($str){
	return json_decode(base64_decode(urldecode($str)),true);
}
/**
*@简易字符串转js
*/
function strToJs($content){
	$content=str_replace(array("\r","\n"),"",$content);
	$content=str_replace("'","\'",$content);
	return "document.write('$content');";
}
 

/**
* 获得用户的真实IP地址
*/
function ip(){
	return realip();
}
function realip() {
	$onlineip = '';
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	$onlineip=sql(html($onlineip));
	return $onlineip;
}

function ipCity($ip,$type=0){
	if($ip=="127.0.0.1") return false;
	if(!file_exists(ROOT_PATH."extends/ip/IP4datx.class.php")) return false;
	require_once ROOT_PATH."extends/ip/IP4datx.class.php";
	$res=IP::find($ip);
	if($type==0){
		return array(
			"country"=>$res[0],
			"region"=>$res[1],
			"city"=>$res[2],
			"county"=>""
		);
	}else{
		return $res[0].$res[1].$res[2];
	}
}

/*获取远程内容*/
function curl_get_contents($url,$timeout=30,$referer="http://www.qq.com"){
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_HEADER, 0);
	 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	 curl_setopt($ch, CURLOPT_REFERER,$referer); //伪造来路页面 防止被禁止
	 $content= curl_exec($ch);
	 curl_close($ch);
	 return $content;
} 

/*远程post*/
function curl_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

function curl_post_json($url, $json)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json))
);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

/**
*判断是否来自搜索引擎
*/
function is_robot() { 
	$kw_spiders = 'Bot|Crawl|Spider|spider|Slurp|slurp|sohu-search|Lycos|lycos|robozilla|baidu|Baidu|google|Google|soso|Soso|YodaoBot|Sogou|sogou|Adsbot|Mediapartners|Msn|msn|scooter|FAST|ia_archiver|Ia_archiver'; 
	if(preg_match("/($kw_spiders)/i", $_SERVER['HTTP_USER_AGENT'],$matches)) 
	{ 
		return true;
	} else { 
		return false;
	}
}

/**
* 验证输入的邮件地址是否合法
*
* @access  public
* @param   string      $email      需要验证的邮件地址
*
* @return bool
*/
function is_email($user_email)
{
	$user_email=trim($user_email);
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
	{
		if (preg_match($chars, $user_email))
		{
			return true;
		}
		else
		{
			return false;
		}
	}else
	{
		return false;
	}
}


/*判断是否手机号码*/
function is_tel($tel){
	if(preg_match("/1[345879]{1}\d{9}$/",$tel)){
		return true;
	}
	return false;
}


/*是否来自手机*/
function is_mobile(){ 
 
    // returns true if one of the specified mobile browsers is detected 
 
    $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|"; 
    $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
    $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";     
    $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|"; 
    $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220"; 
    $regex_match.=")/i";
	         
    return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT'])); 
}
/****加解密*****/
if(!defined("JIAMI_MIYAO")){
	define("JIAMI_MIYAO","我要保密");
}
/*加密*/
function jiami($str,$miyao=''){
	$miyao=$miyao?$miyao:JIAMI_MIYAO;
	$mlen=strlen($miyao);
	$code=md5(md5($miyao));
	$step=array(
		1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17
	);
	$clen=strlen(base64_encode($miyao));
	$str=base64_encode(urlencode($str));
	 	  
	$slen=strlen($str);
	$nstr="";	
	for($i=0;$i<$slen;$i++){
		$nstr.= substr($str,$i,1);
		if(in_array($i,$step)){		
			$nstr.=substr($code,$i,1);
		} 
	}
	$nstr=$mlen.$nstr;
	 
	return $nstr;
}
/******解密******/
function jiemi($str,$miyao=''){
	$miyao=$miyao?$miyao:JIAMI_MIYAO;
	$mlen=strlen($miyao);
	//判断秘钥长度
	$mmi=substr($str,0,strlen($mlen));
	if($mmi!=$mlen){
		return false;
	}
	$str=substr($str,strlen($mlen));
 
	$code=md5(md5($miyao));
	$step=array(
		1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17
	);
	$bstep=array();
	$si=1;
	foreach($step as $s){
		$bstep[]=$s+$si;
		$si++;
	} 
	$clen=strlen(base64_encode($miyao));
	$slen=strlen($str);
	$nstr="";
 
	$ii=1;
	for($i=0;$i<$slen;$i++){
		if(in_array($i,$bstep)){
			 
			if(substr($str,$i,1) != substr($code,$i-$ii,1) ){
				return false;
			}
			 $ii++;
			continue;
		}else{
			$nstr.=substr($str,$i,1);
		}
	}
	$nstr=urldecode(base64_decode($nstr));
	
	return $nstr;
} 

 function checkEmpty($str,$msg="请填写完整信息"){
 	if(empty($str)){
 		C()->goAll($msg,1);
 	}
 }
?>