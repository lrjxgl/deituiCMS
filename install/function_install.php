<?php
function umd5($str)
{
	return md5(md5($str));	
}

function _implode($array) {
	if(!empty($array)) {
		return "'".implode("','", is_array($array) ? $array : array($array))."'";
	} else {
		return '';
	}
}
function echoflush($str){
	echo "<div class='logs'>".$str."</div>";
	flush();
	ob_flush();
}
 /*创建文件夹*/
	  function umkdir($dir)
	{
		if(empty($dir)) return false;
		$dir=str_replace(ROOT_PATH,"",$dir);
		$arr=explode("/",$dir);
		
		foreach($arr as $key=>$val)
		{
			$d="";
			for($i=0;$i<=$key;$i++)
			{
				if($arr[$i]!=""){				
					$d.=$arr[$i]."/";
				}
			} 
			if(!file_exists(ROOT_PATH.$d))
			{ 
				mkdir(ROOT_PATH.$d,0755);
			}
		}
	}
function slog($data){
	$f=fopen("log.txt","a+");
	fwrite($f,$data);
	fclose($f);
}


/*检测权限*/
function checkmode($dirs,$type=2){
	$data=array();
	foreach($dirs as $dir){
		if(!file_exists("../".$dir)){
			mkdir("../".$dir);
			chmod("../".$dir,"0777");
		}
		switch($type){
			case 2://写入
				if(!is_writeable("../".$dir)){
					$data[]=$dir." <font style='color:red;'>不可写</font><br>";
				}
				break;
			case 4://读取
				if(!is_readable("../".$dir)){
					$data[]=$dir." <font style='color:red;'>不可读</font><br>";
				}
				break;
			case 1://执行
				if(!is_executable("../".$dir)){
					$data[]=$dir." <font style='color:red;'>不可执行</font><br>";
				}
				break;
			case 6://读写权限
				$s="";
				if(!is_writeable("../".$dir)){
					$s.=" <font style='color:red;'>不可写</font>";
				}
				
				if(!is_readable("../".$dir)){
					$s.=" <font style='color:red;'>不可读</font>";
				}
				if(!empty($s)){
					$data[]=$dir.$s."<br>";
				}
				break;
			case 7://读写执行权限
				$s="";
				if(!is_writeable("../".$dir)){
					$s.=" <font style='color:red;'>不可写</font>";
				}
				
				if(!is_readable("../".$dir)){
					$s.=" <font style='color:red;'>不可读</font>";
				}
				
				if(!is_executable("../".$dir)){
					$s.=" <font style='color:red;'>不可执行</font>";
				}
				if(!empty($s)){
					$data[]=$dir.$s."<br>";
				}
				break;
				
		}
		
	}
	return $data;
}
/*************开始处理******************/

function sqlQuery($sql){
	global $link;
	global $dbconfig;
	if(!$link or !mysqli_ping($link)){
		$link=sqlConn();
	}
	mysqli_query($link,$sql);
	if($err=mysqli_error($link)){
		echo "<br>".$sql."<br>";
		echo $err;
	}
}
$link=NULL;
function sqlConn(){
	global $link,$dbconfig;
	
		$link=mysqli_connect($dbconfig['master']['host'],$dbconfig['master']['user'],$dbconfig['master']['pwd']) or die("数据库连接出错了");
		mysqli_select_db($link,$dbconfig['master']['database']);
		mysqli_query($link,"SET NAMES utf8");
		mysqli_query($link,"SET sql_mode=''");
		return $link;
}

function insert_data($table,$das){
	global $link;
	if(empty($das)) return false;
	foreach($das[0] as $field=>$v){
		$fields[]=$field;
	}
	$sq=$sql="INSERT INTO ".$table."(".implode(",",$fields).") values";
	$i=0;
	$isval=false; 
	 
	foreach($das as $k=>$data){
		  
		 $fieldsval=array();
		foreach($data as $v){
			$fieldsval[]=$v;		 
		}
		
		if($i>0){
			$sql.=",";
		}	
	 	if(!empty($fieldsval)){
			$sql.=" ("._implode($fieldsval).") ";
		}
		$isval=true;
		$i++;
		if($i>30){
			
			sqlQuery($sql);
			$sql=$sq;
			$i=0;
			$isval=false;
		}
		
	}
	if($table=='sky_district'){
		echo  count($das) ;
	}
	if($isval){
		sqlQuery($sql);
	}
	 
	 
}
