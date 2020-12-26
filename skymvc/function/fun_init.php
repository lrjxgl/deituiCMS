<?php
/*配置数据库*/
$_DBS=array();
$_MDS=array();
/**加载skymv loadfun 函数库 **/
function loadFun($files){
	if(is_array($files)){
		foreach($files as $file){
			if(file_exists(SKYMVC_ROOT."loadfun/fun_".$file.".php")){
				require_once(SKYMVC_ROOT."loadfun/fun_".$file.".php");
			}
			
		}
	}else{
		if(file_exists(SKYMVC_ROOT."loadfun/fun_".$files.".php")){
			require_once(SKYMVC_ROOT."loadfun/fun_".$files.".php");
		}
		
	}
	
}
/**处理分布式数据库**/
function in_VMDBS($table){
	global $VMDBS;
	
	if(isset($VMDBS[$table])){
		return $VMDBS[$table];
	}else{
		return false;
	}
}
function setDb($table='master'){
	global $dbconfig,$_DBS;
	if(isset($_DBS[$table])) return $_DBS[$table];
	if(isset($dbconfig[$table])){
		$_DBS[$table]=new mysql();
		$_DBS[$table]->connect($dbconfig[$table]);
		return $_DBS[$table];
	}elseif($tb=in_VMDBS($table)){
		if(isset($_DBS[$tb])) return $_DBS[$tb];
		$_DBS[$tb]=new mysql();
		$_DBS[$tb]->connect($dbconfig[$tb]);
		return $_DBS[$tb];
	}else{
		if(isset($_DBS['master'])){
			return $_DBS['master'];
		}else{
			if(isset($dbconfig['master'])){
				$_DBS['master']=new mysql();
				$_DBS['master']->connect($dbconfig['master']);				
				return $_DBS['master'];
			}
		}
	}
}

function closeDb(){
	global $_DBS,$_MDS;;
 
	if(!empty($_DBS)){
		foreach($_DBS as $k=>$v){
			if(isset($_DBS[$k]->db)){
				$_DBS[$k]->db=null;
			}
			$_DBS[$k]=null;
			unset($_DBS[$k]);
		}
	}
	if(!empty($_MDS)){
		foreach($_MDS as $k=>$v){
			if(isset($_MDS[$k]->db)){
				$_MDS[$k]->db=null;
			}
			$_MDS[$k]=null;
			unset($_MDS[$k]);
		}
	}
}
/*加载模型*/
function M($model){
	global $_MDS;
	$model=strtolower($model);
	 
	if(isset($_MDS[$model.'Model'])){
		 
		return $_MDS[$model.'Model'];
	}else{
		
		if(file_exists(	MODEL_DIR."/$model.model.php")){		
			require_once   MODEL_DIR."/$model.model.php";
			//controler  model调用
			$_model="{$model}Model";
					
			$m=new $_model();
			$m->setDb($model);
			 
			$_MDS[$model.'Model']=$m;	
			 	 
			return $_MDS[$model.'Model'];

		}else{
			//controler  model调用
			$_model="{$model}Model";
			 		
			$m=new model();
			
			$m->setDb($model);
		 
			$m->table=$model;			
			$_MDS[$model.'Model']=$m;	
			 
			return $_MDS[$model.'Model'];
		}
	}
}
/*加载模块的模型*/
function MM($module,$model){
	global $_MDS;
	if(isset($_MDS[$model.'MModel'])){
	 
		return $_MDS[$model.'MModel'];
	}else{
		if(file_exists(ROOT_PATH."module/".$module."/source/model/$model.model.php")){		
			require_once    ROOT_PATH."module/".$module."/source/model/$model.model.php";
			$_model="{$model}Model";
			$m=new $_model();
			$m->setDb($model);
			 
			$_MDS[$model.'MModel']=$m;		 
			return $_MDS[$model.'MModel'];
		}else{
			//controler  model调用
			$_model="{$model}Model";
			 			
			$m=new model();
			$m->setDb($model);
			$m->table=$model;			
			$_MDS[$model.'MModel']=$m;
			 		 
			return $_MDS[$model.'MModel'];
		}
	}
}
 
/*获取控制器*/
function C($ctrl='',$dir=false){
	$ctrl=strtolower($ctrl);
	if(empty($ctrl)){
		return $GLOBALS['control'];
	}else{
		if(isset($GLOBALS['control_'.$ctrl])){
			return $GLOBALS['control_'.$ctrl];
		}else{
			$dir=$dir?$dir:CONTROL_DIR;
			$file= $dir."/".$ctrl.".ctrl.php";
			 
			if(file_exists($file)){
				include_once $file;
				$ctrlClass= $ctrl."Control";
				$GLOBALS['control_'.$ctrl]=new $ctrlClass();
				if(method_exists($ctrlClass,'onInit')){
					$GLOBALS['control_'.$ctrl]->onInit();
				}
				return $GLOBALS['control_'.$ctrl];
			}else{
				exit($ctrl."不存在");
			}
		}
	}
	
}
/**/
function cc($module='',$ctrl='',$dir='index'){
	if(empty($ctrl)){
		return $GLOBALS[$module.'_control'];
	}else{
		if(isset($GLOBALS[$module.'_control_'.$ctrl])){
			return $GLOBALS[$module.'_control_'.$ctrl];
		}else{
			$file=ROOT_PATH."module/".$module."/source/$dir/$ctrl.ctrl.php";		 
			if(file_exists($file)){
				include_once $file;
				$ctrlClass= $ctrl."Control";
				return $GLOBALS[$module.'_control_'.$ctrl]=new $ctrlClass();
				
			}else{
				exit($ctrl."不存在");
			}
		}
	}
}

/**
	*缓存
*/

function cache(){
		global $cacheconfig;
		if(isset($GLOBALS['cache'])) return $GLOBALS['cache'];	
		$GLOBALS['cache']=new cache($cacheconfig);
		
		return $GLOBALS['cache'];
}
 
/*SESSION*/
function initsession(){
	if(defined("SESSION_USER") && SESSION_USER==1 ){
		$s = new session();
	}else{
		session_start();
	}
}
 
/*End Session*/
setDb();
initsession();