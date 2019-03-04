<?php
class moduleControl extends skymvc{
	
	function __construct(){
		parent::__construct();
		 
	}
	
	public function onDefault(){
		
		$d=ROOT_PATH."module";
		$mods=$this->getmods($d);
		
		$this->smarty->assign(
			array(
				"mods"=>$mods,
			)
		);
		 
		$this->smarty->display("module/module.html");
		
	}
	
	public function onYun(){
		
		$this->smarty->display("module/yun.html");
	}
	
	public function onDownInstall(){
		$downcode=get_post('downcode','h');
		$domain=getBaseDomain($_SERVER['HTTP_HOST']);
	 
		$data=file_get_contents("http://www.deitui.com/index.php?m=yunmodule&a=down&downcode={$downcode}&domain={$domain}");
		 
		$json=json_decode($data,true);
		if(!$json || $json['error']){
			$this->goAll("数据出错",1);
		}else{
			 
			if(file_exists(ROOT_PATH."module/".$json['data']['appdir'])){
				$this->goAll("该模块已经存在了",1);
			}
			$file=ROOT_PATH."module/{$downcode}.zip";
			file_put_contents($file,file_get_contents($json['data']['downurl']));
		 
			$this->loadClass("pclzip",false,false);
			$zip = new pclzip($file);
			$zip->extract(ROOT_PATH."module");
			//unlink($file);
			$_GET['inmodule']=$json['data']['appdir'];
			$this->onInstall();
			$this->goAll("安装成功");
		}
		
	}

	public function onAdd(){
		
		$this->smarty->display("module/add.html");
	}
	
	public function onEdit(){
		$module=get('module','h');
		$data=M("module")->selectRow("module='".$module."'");
		$this->smarty->assign(array(
			"data"=>$data
		));
		$this->smarty->display("module/edit.html");
	}
	
	public function onSave(){
		$id=get_post('id','i');
		$data=M("module")->postData();
		M("module")->update($data,"id=".$id);
		$this->gomsg("保存成功");
	}
	
	
	public function onCreate(){
		
		$mod_name=post('mod_name','h');
		$mod_dir=post('mod_dir','h');
		$mod_table=post('mod_table','h');
		$mod_info=post('mod_info','h');
		if(substr($mod_table,0,4)!='mod_'){
			$this->goAll("请确保主表是以mod_开头",1);
		}
		//检测表名
		if(M("module")->selectRow(array("where"=>" tablename='".$mod_table."'"))){
			$this->goAll("主表已经存在了",1);
		}
		if(file_exists("module/{$mod_dir}")){
			$this->goAll("插件已经存在",1);
		}
		umkdir("module/{$mod_dir}/source/admin");
		 
		umkdir("module/{$mod_dir}/source/shop");
		umkdir("module/{$mod_dir}/source/index");
		umkdir("module/{$mod_dir}/source/model");
		umkdir("module/{$mod_dir}/themes/admin");
		umkdir("module/{$mod_dir}/themes/index");
		umkdir("module/{$mod_dir}/themes/shop");
		file_put_contents("module/{$mod_dir}/module.php",''); 
		//新建住控制文件
		$str='<?php
class '.$mod_dir.'Control extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}

	public function onDefault(){
		$this->smarty->display("index.html");
	}
}

?>';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/source/index/{$mod_dir}.ctrl.php",$str);
		
		file_put_contents(ROOT_PATH."module/{$mod_dir}/source/shop/{$mod_dir}.ctrl.php",$str);
		$str='<?php
		class '.$mod_dir.'Control extends skymvc{
			
			public function __construct(){
				parent::__construct();
			}
			public function onMenu(){
				$this->smarty->display("menu.html");
			}
			public function onDefault(){
				$this->smarty->display("index.html");
			}
		}
		
		?>';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/source/admin/{$mod_dir}.ctrl.php",$str);
		//建立主表model
		$str='<?php
class '.$mod_table.'Model extends model{
	public $table="'.$mod_table.'";
	public function __construct(&$base){
		parent::__construct($base);
	}
}

?>';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/source/model/".$mod_table.".model.php",$str);
		//建立模板文件
		$str='<!DOCTYPE html>
<html>
{include file="head.html"}
<body>
		<h1>开始开发插件吧</h1>
		{include file="footer.html" } 
</body>
		</html>
		';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/index/index.html",$str);
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/admin/index.html",$str);
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/shop/index.html",$str);
		$str='<!DOCTYPE html>
<html>
{include file="head.html"}
<script language="javascript">
function movenew()
{
	document.location="{$url}";
}
setTimeout(movenew,2000);

</script>
<style>
	.gomsg{
		width: 300px;
		margin: 50px auto;
		border: 3px solid #ddd;
		border-radius: 5px;
		padding: 20px; 
		
	}
</style>
<body>
{include file="header.html"}
<div class="main-body">	 
    <div class="gomsg">{$message}，如果没有自动跳转请点击 <a href="{$url}">跳转</a></div>    
</div>
{include file="footer.html"}
</body>
</html>';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/index/gomsg.html",$str);	
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/admin/gomsg.html",$str);	
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/shop/gomsg.html",$str);	
	 
		
		
		 
		//head
		$str='<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<title>'.$mod_name.'</title>
</head>
';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/admin/head.html",$str);
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/index/head.html",$str);
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/shop/head.html",$str);
	
		//footer
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/admin/footer.html",'');
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/index/footer.html",'');
		file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/shop/footer.html",'');
		//End footer
		//menu.html
		$str='<div class="menu menu-active">
	<div class="menu-title">'.$mod_name.'</div>
	<div class="menu-box">
		<div gourl="/moduleadmin.php?m='.$mod_dir.'&t=1" class="menu-item">功能一</div>
		<div gourl="/moduleadmin.php?m='.$mod_dir.'&t=2"  class="menu-item">功能二</div>
		<div gourl="/moduleadmin.php?m='.$mod_dir.'&t=3"  class="menu-item">功能三</div>
	</div>
</div>';
file_put_contents(ROOT_PATH."module/{$mod_dir}/themes/admin/menu.html",$str);
		//创建配置文件
		$str='<?php
$config=array(
	"title"=>"'.$mod_name.'",//模块名称
	"module"=>"'.$mod_dir.'",//模块目录
 	"version"=>1.0,//当前版本
	"info"=>"'.$mod_info.'",//模块信息
	"table_pre"=>"'.TABLE_PRE.'",//表前缀
	"adminurl"=>"moduleadmin.php?m='.$mod_dir.'&a=menu",
	"check_update"=>"http://www.deitui.com",
);
?>';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/config.php",$str);
		$model_id=M("module")->insert(array(
			"title"=>$mod_name,
			"tablename"=>$mod_dir,
			"data"=>$mod_info,
			"module"=>$mod_dir	
		));
		//创建model_id
 		
		
		$str='<?php define("MODULE_'.strtoupper($mod_dir).'_ID",'.$model_id.'); ?>';
		file_put_contents(ROOT_PATH."module/{$mod_dir}/module.php",$str);
		
		file_put_contents(ROOT_PATH."module/{$mod_dir}/install.sql.php","");
		file_put_contents(ROOT_PATH."module/{$mod_dir}/uninstall.sql.php","");
		file_put_contents(ROOT_PATH."module/{$mod_dir}/install.lock","success");
		$this->goAll("插件创建成功");
	}
	
	/*获取所有的模块*/
	public function getmods($dir){
		if(!file_exists($dir)) return false;
		
		$dh=opendir($dir);	
		while(false!==($file=readdir($dh))){
			if($file!="." && $file!=".."){
				if(is_dir($dir."/".$file)){
					if(file_exists($dir."/".$file."/config.php")){
						@include_once($dir."/".$file."/config.php");
					}else{
						continue;
					}
					if(file_exists($dir."/".$file."/install.lock")){
						$config['isinstall']=true;
					}else{
						$config['isinstall']=false;
					}
					$mods[]=$config;
				}
			}
		}
		
		return $mods;
	}
	
	public function onInstall(){
		
		$module=str_replace("/","",get_post('inmodule','h'));
		$d=ROOT_PATH."module/$module";
		if(file_exists($d."/install.lock")){
			$this->goAll("该模块已经安装",1);
		}
		@require_once($d."/config.php");
		
		//加入模型
		$model_id=M("module")->insert(array(
			"title"=>$config['title'],
			"tablename"=>$config["module"],
			"data"=>$config['info'],
			"module"=>$config['module']		
		));
	 	//写入配置
	 	$str=file_get_contents(ROOT_PATH."module/{$module}/module.php");		 
		$MM=strtoupper($module);
		$str=preg_replace("/define\(\"{$MM}_MODEL_ID\",(\d+)\)/iUs",'define("'.$MM.'_MODEL_ID",'.$model_id.')',$str);	 
		file_put_contents(ROOT_PATH."module/{$module}/module.php",$str);
		//处理sql
		@define(strtoupper($module)."_MODEL_ID",$model_id);
		$this->dosql($d."/"."install.sql.php",$config['table_pre']);
		//添加已经安装文件
		file_put_contents($d."/install.lock","");
		$this->goall("安装成功",0,0,APPADMIN."?m=module&a=default");
	}
	
	public function onUninstall(){
		$module=str_replace("/","",get_post('inmodule','h'));
		
		//删除文件
		$d=ROOT_PATH."module/$module";
		@require_once($d."/config.php");
		//处理sql
		$this->dosql($d."/"."uninstall.sql.php",$config['table_pre']);
		@unlink($d."/install.lock");
		M("module")->delete("module='".$module."'");
		$this->gomsg("卸载成功",APPADMIN."?m=module&a=default");
	}
	
	
	public function onDelete(){
		$module=str_replace("/","",get_post('inmodule','h'));
		
		//删除文件
		$d=ROOT_PATH."module/$module";
		@require_once($d."/config.php");
		//处理sql
		$this->dosql($d."/"."uninstall.sql.php",$config['table_pre']);
		@unlink($d."/install.lock");
		M("module")->delete("module='".$module."'");
		$this->removedir(ROOT_PATH."module/$module");
		$this->gomsg("删除成功",APPADMIN."?m=module&a=default");
	}
	
	public function dosql($dbfile,$table_pre=""){
		//$content=require($dbfile);
		require($dbfile);
		//获取创建的数据
		//去掉注释
		$content=preg_replace("/--.*\n/iU","",$content);
		//替换前缀
		if($table_pre){
			$content=str_replace($table_pre,TABLE_PRE,$content);
		}
		$carr=array();
		$iarr=array();
		//提取create
		preg_match_all("/Create table .*\(.*\).*\;[\n]*/iUs",$content,$carr);
		if(!empty($carr)){
			$carr=$carr[0];
			
			foreach($carr as $c)
			{
				M("module")->query($c);
			}
		}
		//提取insert
		preg_match_all("/INSERT INTO .*\(.*\)\;[\n]*/iUs",$content,$iarr);
		if(!empty($iarr)){
			$iarr=$iarr[0];
			//插入数据
			foreach($iarr as $c)
			{
				M("module")->query($c);
			}
		}
		//提取update
		preg_match_all("/UPDATE .*\(.*\)\;[\n]*/iUs",$content,$iarr);
		if(!empty($iarr)){
			$iarr=$iarr[0];
			//插入数据
			foreach($iarr as $c)
			{
				M("module")->query($c);
			}
		}
		//提取删除
		preg_match_all("/drop table.*\;/iUs",$content,$iarr);
		$iarr=$iarr[0];
		//插入数据
		if(!empty($iarr)){
			foreach($iarr as $c)
			{
				M("module")->query($c);
			}
		}
		
	}
	
	public function removedir($dir){
		$dh=opendir($dir);
		while(false !==($file=readdir($dh))){
			if($file!="." && $file!=".." ){
				if(is_dir($dir."/".$file)){
					self::removedir($dir."/".$file);
					@rmdir($dir."/".$file);
				}else{
					@unlink($dir."/".$file);
				}
			}
		}
		@rmdir($dir);
		closedir($dh);
	}
	
	public function movedir($from,$to){
		$dh=opendir($from);
		@mkdir($to);
		while(false !==($file=readdir($dh))){
			if($file!="." && $file!=".." ){
				if(is_dir($from."/".$file)){
					self::movedir($from."/".$file,$to."/".$file);
				}else{
					if(!in_array($file,array("config.php","install.lock","install.sql","uninstall.sql"))){
						copy($from."/$file",$to."/".$file);
					}
				}
			}
		}
		
		closedir($dh);
	}
	
	
	
}

?>