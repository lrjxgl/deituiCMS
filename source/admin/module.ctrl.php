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
					$cms=cmsVersion::get();
					if(isset($cms["mds"]) && !in_array($config["module"],$cms["mds"])){
						$mods[]=$config;
					}
					 
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
	
	public function onNavAdd(){
		$url=post("url","x");
		$title=post("title","h");
		M("navbar")->insert(array(
			"link_url"=>sql($url),
			"title"=>$title,
			"group_id"=>1
		));
		$this->goAll("success");
	}
	
}

?>