<?php

class skymvc
{
	public $smarty,$cache,$db,$config_data=array(),$lang=array(),$rewriterule=array();
	public $version='4.0';
	public $skysqlrun="";//记录数据库执行的总数
	public $skysqlnum=0;
	function __construct($config=array())
	{
		
		$this->initLang();
		$this->initsmarty();
		$this->initCache(); 	
		if(!defined("SKYINIT")){
			$GLOBALS['control']=$this;
			define("SKYINIT",1);
			//过渡方法
			if(function_exists("userinit")){
				userinit($this);
			}
				
		}
	}
 
	
	
	//初始化语言包
	public function initLang(){
		if(file_exists(ROOT_PATH."lang/".LANG)){
			$dir=ROOT_PATH."lang/".LANG;
			$d=opendir($dir);
			while(false !==($f=readdir($d))){				
				if($f!="." && $f!=".." ){
					if(strtolower(trim(substr(strrchr($f, '.'), 1)))=="php"){
						@include($dir."/".$f);
					}
				}
			}
			closedir($d);
			if(isset($lang)){
				$this->lang=$lang;
			}
		}
		//加载模块语言包
		
	}
	 
	//初始化版本
	public function version()
	{
		$this->version;
	}
	 
	
	public function initsmarty()
	{
		if(defined("SMARTYPHP") && SMARTYPHP=="php" ){
			include_once SKYMVC_ROOT."class/cls_smarty_php.php";
		}else{
			include_once SKYMVC_ROOT."class/cls_smarty.php";
		}
		$this->smarty=new Smarty(); 
		if(ISWAP){
			$this->smarty->template_dir   =S_WAP_TEMPLATE_DIR;
		}else{
			$this->smarty->template_dir   =S_TEMPLATE_DIR;
		}
		$this->smarty->cache_dir=S_CACHE_DIR;
		$this->smarty->html_dir=S_HTML_DIR;
		$this->smarty->compile_dir=S_COMPILE_DIR;
		 
		if(defined("TESTMODEL") && TESTMODEL==1){
			$this->smarty->force_compile= true;
		}else{
			$this->smarty->force_compile= false;
		}
		 
		$this->smarty->assign("skins","/".(ISWAP?S_WAP_TEMPLATE_DIR:S_TEMPLATE_DIR )."/");
		$this->smarty->assign("lang",$this->lang);
	}
 	
	public function initCache(){
		$this->cache=cache();		
	}
	
	
	
	 
  
	
	/*引入类*/
	public function loadClass($cls,$dir=false,$isnew=true)
	{
		$dir=$dir?$dir:"library";
		$excls=ROOT_PATH."/extends/".$dir."/cls_{$cls}.php";
		if(file_exists($excls)){
			 $file=$excls;
		}else{
			$file=SKYMVC_ROOT."/{$dir}/cls_{$cls}.php"; 
		}
		include_once($file);
		if($isnew==true){
			$this->$cls = new $cls();
		}
	}
	/*引入func*/
	public function loadfun($fun,$dir=false)
	{
		loadFun($fun);
	}
	/*引入配置文件*/
	public function loadconfig($file){
		if(file_exists(ROOT_PATH."config/{$file}.php")){
			@include(ROOT_PATH."config/{$file}.php");
			
			if(isset($config)){
				$GLOBALS['config_data']+=$config;
			}
		}
	}
	/*获取配置信息*/
	public function config_item($k=""){
		 
		if(empty($k)){ 
			return $GLOBALS['config_data'];
		}else{
			if(is_array($k)){
				$ct=count($k);
				$d=isset($GLOBALS['config_data'][$k[0]])?$GLOBALS['config_data'][$k[0]]:false;
				if($d){
					for($i=1;$i<$ct;$i++){
						if(isset($d[$k[$i]])){
							$d=$d[$k[$i]];
						}else{
							return false;
						}
					}
					return $d;
				}else{
					return false;
				}
			}else{
				return isset($GLOBALS['config_data'][$k])?$GLOBALS['config_data'][$k]:false;
			}
		}
	}
	
	
	
	/*分页函数*/
	function pagelist($rscount,$pagesize,$url,$num=0){
		if(function_exists("pagelist")){
			return pagelist($rscount,$pagesize,$url,$num);
		}
		if(!$rscount or !$pagesize) return false;
		if(!defined("ISWAP")){
			define("ISWAP",false);
		}
		if(!$num){
			$num=ISWAP?6:10;	
		}
		
		$url .= strpos($url, '?')!==false ? '&' : '?';
		$per_page=get_post('per_page','i');
		$page=ceil($per_page/$pagesize);
		$pagenum=ceil($rscount/$pagesize);
		if($pagenum<2) return false;
		$pagestart=0;
		//中间页面
		$middle=ceil(($num-2)/2);
		 
		$prevlot=$lastlot="";
		if(($per_page-$pagesize*$num/2)>0){
			$prevlot='<a href="'.R($url.'per_page='.min($per_page-$pagesize*$num/2,$rscount)).'">....</a>';
		}
		if($rscount-$per_page-$pagesize*$num/2>0){
			$lastlot='<a href="'.R($url.'per_page='.min($per_page+$pagesize*$num/2,$rscount)).'">....</a>';
		}
		$min=intval(max(0,($per_page-$pagesize*$middle))/$pagesize);
		$pagelist='<div class="pages">';
		if($per_page==0){
			$pagelist.='<strong>首页</strong>';
		}else{
			$pagelist.='<a href="'.R($url).'" class="first">首页</a>';
		}
		if(!ISWAP){
			$pagelist.=$prevlot;
		}
		$max=min($min+$num,$pagenum);
		if($max-$min<$num){
			$min=max(1,$max-$num);
		}
		if(ISWAP){
			if($per_page>0){	
				$pagelist.='<a href="'.R($url.'per_page='.max(0,$per_page-$pagesize)).'">上一页</a>';
			}
			if($rscount>($pagesize+get_post("per_page","i"))){
				$pagelist.='<a href="'.R($url.'per_page='.min($per_page+$pagesize,$rscount)).'">下一页</a>';
			}
		}else{
			for($i=$min;$i<$max;$i++){
				if($i==0) continue;
				if($i>=$pagenum-1) continue;
				if($i==$page){
					$pagelist.='<strong>'.$i.'</strong>';
				}else{
					$pagelist.='<a href="'.R($url.'per_page='.min($i*$pagesize,$rscount)).'">'.$i.'</a>';
				}
			}
			$pagelist.=$lastlot;
		}
		
		if($per_page>=$rscount-$pagesize){ 
			$pagelist.='<strong>尾页</strong>';
		}else{
			$pagelist.='<a href="'.R($url.'per_page='.($pagenum-1)*$pagesize).'" class="last">尾页</a>';
		}
		$pagelist.='</div>';
		return $pagelist;
	}
	
	 
	public function set_cookie($key,$val,$expire,$path="/",$domain=""){
		if(function_exists("set_cookie")){
			set_cookie($key,$val,$expire,$path,$domain);
		}
		if(!$domain){
			$domain=COOKIE_DOMAIN;
		}		 
		setcookie($key,$val,time()+$expire,$path,$domain);
	}
	
	public function get_cookie($key){
		if(function_exists("get_cookie")){
			return get_cookie($key);
		}
		if(isset($_COOKIE[$key])){
			return $_COOKIE[$key];	
		}
		return false;
	}
	
	public function set_session($key,$val){
		if(function_exists("set_session")) {
			return set_session($key,$val);
		}
		$_SESSION[$key]=$val;
	}
	
	public function get_session($key,$field=false){
		if(function_exists("get_session")){
			 return get_session($key);
		}
		if(isset($_SESSION[$key])){
			if($field){
				if(isset($_SESSION[$key][$field])){
					return $_SESSION[$key][$field];
				}
				return false;
			}else{
				return $_SESSION[$key];
			}
		}else{
			return false;
		}
	}
	
	public function del_session($key){
		if(function_exists("del_session")){
			return del_session($key);
		}
		unset($_SESSION[$key]);
	}
	
	/*MD5加密*/	
	public function umd5($string){
		return md5(md5(md5($string)));
	}
	
	
	/*验证权限*/
	function checkpermission($permission,$m='',$a=''){
		$m=strtolower($m?$m:get('m','h'));
		$a=strtolower($a?$a:get('a','h'));
		$a=$a?$a:"default";
		if(!isset($permission[$m])) return false;
		$p=$permission[$m];
		$arr=array();
		if($p){
			foreach($p as $v){
				$arr=array_merge($arr,explode(",",$v)); 
			}
		}
		if(!in_array($a,$arr)){
				return false;
		}
		return true;	
	}
	
	function __destruct(){
		 
	}
	
	public function sexit($data=''){
		closeDb(); 
		exit($data);
	}
	/*Ajax和原始 跳转*/
	public function goall($message,$err=0,$data=array(),$url=NULL){
		if(!$url) $url=$_SERVER['HTTP_REFERER'];
		closeDb();
		if(get_post('ajax',1)){
			if(get_post('jsonp')){
				exit(get_post('callback','h')."(".json_encode(array("error"=>$err,"message"=>$message,"data"=>$data,"url"=>$url)).")");
			}else{
				exit(json_encode(array("error"=>$err,"message"=>$message,"data"=>$data,"url"=>$url)));
			}
		}else{
			if(empty($message)){
				if(empty($url))
				{
					echo "<script>location.href='".$_SERVER['HTTP_REFERER']."';</script>";
				}else
				{	
					echo "<script>location.href='".$url."';</script>";
				}
			}else{
				$this->smarty->assign("message",$message);
				$this->smarty->assign("url",$url?$url:$_SERVER['HTTP_REFERER']);
				if(isset($tpl)){
					$this->smarty->template_dir=$tpl;
				}
				$this->smarty->display("gomsg.html");
			}
		}
	}
	/*检测字符串*/
	public function checkBadWord(){
		if(!empty($_POST)){
			require(ROOT_PATH."config/badword.php");
			foreach($_POST as $k=>$v){
				if(is_string($v)){
					$b=preg_match("/(".$badword.")/iUs",$v,$a);
					 
					if(!empty($b)){						 
						$this->goall('有敏感字符串<span style="color:red;font-size:20px;">'.$a[1].'</span>请删除该字符串',1);
					}
				}
			}
		}
	}
	 
 
	
}