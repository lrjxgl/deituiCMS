<?php


function getImgs($content,$i=9999){
	preg_match_all("/<img[^>]*src[^=]*=[^\"']*[\"'](.*)[\"'][^>]*>/iUs",$content,$imgs);
	if($i!=9999){
		return $imgs[1][$i];
	}else{
		return $imgs[1];
	}
}

function replaceImgs($content){
	preg_match_all("/<img[^>]*src[^=]*=[^\"']*[\"'](.*)[\"'][^>]*>/iUs",$content,$imgs);
	if(is_array($imgs[1])){
		foreach($imgs[1] as $img){
			$content=str_replace($img,images_site($img),$content);
		}
	}
	return $content;
}

/***获取一及域名***/
 function getBaseDomain($host){
		$com=array(
			".com.cn",
			".net.cn",
			".org.cn",
			".gov.cn",
			".com",
			".net",
			".cn",		
			".org",	
			".me",
			".co",
			".tv",
			".cc"	
		);
		$arr=$farr=explode(".",$host);
		$len=count($farr);
		//获取最后两个
		if($len>2){
			$dm2=".".$arr[$len-2].".".$arr[$len-1];
			$key=array_search($dm2,$com); 
			if($key!==false){
				 $cm=$dm2;
				
			}else{
				$cm=".".$arr[$len-1];
			}
			 
		}else{
			$cm=".".$arr[$len-1];
		}
		
		$s=str_replace($cm,"",$host);
		$arr=explode(".",$s);
		$s=array_pop($arr);
		return $s.$cm;
	}

/*剩余时间*/
function lefttime($endtime,$format="还剩#天#小时#分#秒",$ec=0){
	$t=$endtime-time();
	$a=explode("#",$format);
	if($t<=0){
		 $str="已结束"; 
	}elseif($t<60){
		$str= $a[0].$t.$a[4];
	}elseif($t<3600){
		$str= $a[0].intval($t/60).$a[3].($t-intval($t/60)*60).$a[4];
	}elseif($t<86400){//小时
		$str= $a[0].intval($t/3600).$a[2].($t-intval($t/3600)*3600).$a[3];
	}else{
		$str=$a[0].intval($t/86400).$a[1].intval(($t-intval($t/86400)*86400)/3600).$a[2];
	}
	if($ec){
		echo $str;
	}else{
		return $str;
	}
}

//格式化时间 多久前的
function timeago($dateline)
{
	$t=time()-intval($dateline);
	if($t<60)
	{
		return $t."秒前";
	}elseif($t<3600)
	{
		return ceil($t/60)."分前";
	}elseif($t<7200)
	{
		return "1小时".ceil(($t-3600)/60)."分前";
	}elseif($t<86400)//一天
	{
		return ceil($t/3600)."小时前";
	}elseif($t<604800)//一周
	{
		return ceil($t/86400)."天前";
	}else
	{
		return date("Y年m月d日",$dateline);
	}
}


/*计算开业时间函数*/
function opentype($starthour,$startminute,$endhour,$endminute)
{
	$opentype='doing';
	$h=intval(date("H"));
	$m=intval(date("i"));
	if($starthour>$endhour)
	{
		if(($endhour<$h && $starthour>$h) or (($endhour==$h && $endminute<$m) && ($starthour==$h && $startminute>$m)))
		{
			if(($starthour-$h)>(($starthour-$endhour)/2))
			{
				$opentype='done';
			}else
			{
				
				$opentype='will';
			}
		}elseif($endhour)
		{
			$opentype='doing';
		}
		
	}else
	{
		if($h<$starthour or ($h==$starthour && $m<$startminute))
		{
			$opentype='will';//未开时
		}elseif($h>$endhour or($h==$endhour && $m>$endminute))
		{
			$opentype='done';//一结束
		}else
		{
			$opentype='doing';
		}
	}
	return $opentype;
}


//星期几
function getweek($w="")
{
	if(date("N"))
	{
		return $w.date("N");
	}
	if(date("w")==0)
	{
		return $w."7";
	}else
	{
		return $w.intval(date("w"));
	}
}

function week_list($week=0){
	$data=array(
		'week1'=>'星期一',
		'week2'=>'星期二',
		'week3'=>'星期三',
		'week4'=>'星期四',
		'week5'=>'星期五',
		'week6'=>'星期六',
		'week7'=>'星期日',
	);
	if($week){
		return $data[$week];
	}else{
		return $data;
	}
}
 function echoweek($time){
	 $w=date("w",$time);
	 if($w==0) $w=7;
	 return week_list("week".$w);
	  
 }
?>