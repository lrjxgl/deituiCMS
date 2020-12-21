<?php
/**
*Author 雷日锦 362606856@qq.com
*生成控制器文件
*/
require("config.php");
require("nav.php");
 
function getpost($Type,$field,$p="get_post"){
	if($field=='dateline') return "time()";
	if($field=='siteid') return 'SITEID';
	if($field=='userid') return '$this->login->userid';
	if($field=='status') return 0;
	$str=strtolower(substr($Type,0,strpos($Type,"(")));
	switch($str){
		case "int":
		case "smallint":
		case "tinyint":
		case "bigint":
			return $p.'("'.$field.'","i")';
		break;
		
		case "decimal":
			$d=explode(",",$Type);
			$d=intval($d[1]);
			return $p.'("'.$field.'","r",2)';
		default:
			return $p.'("'.$field.'","h")';
		break;
	}
} 
 
?>
<form method="get" action="modulecontrol.php">
  <p>文件名称：
    <input type="text" name="c" value="<?php echo $_GET['c'];?>" />
    model:<input type="text" name="model" value="<?php  echo $_GET['model'];?>" />
    表：<input type="text" name="table" value="<?php echo  $_GET['table'];?>" />
    <br>
    <br>
    模块：<input type="text" name="module" value="<?php echo $_GET['module'];?>" />
     目录：<input type="text" name="dir" value="<?php echo isset($_GET['dir'])?$_GET['dir']:"index";?>">
     模板: 
     <select name="tpl">
     	<?php
			$tpls=array("index.tpl","admin.tpl","user.tpl","shopadmin.tpl","wap.tpl");
        	foreach($tpls as $v){
				if($v==$_GET['tpl']){
					echo '<option value="'.$v.'" selected>'.$v.'</option>';
				}else{
					echo '<option value="'.$v.'">'.$v.'</option>';
				}
			}
		?>
     </select>
  </p>
  <p>
  <input name="list" type="checkbox" value="1" /> list
  <input name="show" type="checkbox" id="" value="1" > show
    <input name="add" type="checkbox" id="add" value="1" />
    add
   
   <input type="checkbox" name="status" value="1" /> status
    <input name="delete" type="checkbox" id="delete" value="1" />
    delete
    <input type="checkbox" name="istpl" value="1" />生成模板
    <input name="copy" type="checkbox" value="1">覆盖
    <input type="submit" value="生成" />
  </p>
</form>
<?php
$c=trim($_GET['c']);
$model=trim($_GET['model']);
$table=trim($_GET['table']);
$module=trim($_GET['module']);
$dir=trim($_GET['dir']);
$tpldir=str_replace($dir."_","",$c);
$tpl=trim($_GET['tpl']);
$istpl=intval($_GET['istpl']);
$list=intval($_GET['list']);
$show=intval($_GET['show']);
$add=intval($_GET['add']);
$status=intval($_GET['status']);
$delete=intval($_GET['delete']);
$copy=intval($_GET['copy']);
if(empty($_GET['c']) or empty($model) or empty($table)) exit();
$res=mysqli_query($link,"show columns from ".$tablepre.$table);
$insert_str="\r\n";
$p_key="";
$i=0;
define("MODULESKINS","module/".$module."/themes/");
$rootphp="module.php";
if($dir=="admin"){
	$rootphp="moduleadmin.php";
} 
while($rs=mysqli_fetch_array($res,MYSQLI_ASSOC)){
	if($i==0){
		$p_key=$rs['Field'];
		$i++;
		$insert_str.='			$'.$rs['Field'].'='.getpost($rs['Type'],$rs['Field']).";\r\n";
	}else{
		$insert_str.='			$data["'.$rs['Field'].'"]='.getpost($rs['Type'],$rs['Field'],"post").";\r\n";
	}
}
$str='<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class '.$c.'Control extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" status in(0,1,2)";
			$url="'.$rootphp.'?m='.$c.'&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" '.$p_key.' DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("'.$model.'")->select($option,$rscount);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("'.$tpldir.'/index.html");
		}
		';
		
		$list && $str.='
		public function onList(){
			$where=" status in(0,1,2)";
			$url="'.$rootphp.'?m='.$c.'&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" '.$p_key.' DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("'.$model.'")->select($option,$rscount);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("'.$tpldir.'/index.html");
		}
		';
		
		$show&& $str.='
		public function onShow(){
			$'.$p_key.'=get_post("'.$p_key.'","i");
			$data=M("'.$model.'")->selectRow(array("where"=>"'.$p_key.'=".$'.$p_key.'));
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("'.$tpldir.'/show.html");
		}';
		
		$add && $str.='
		public function onAdd(){
			$'.$p_key.'=get_post("'.$p_key.'","i");
			if($'.$p_key.'){
				$data=M("'.$model.'")->selectRow(array("where"=>"'.$p_key.'=".$'.$p_key.'));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("'.$tpldir.'/add.html");
		}
		
		public function onSave(){
			$'.$p_key.'=get_post("'.$p_key.'","i");
			$data=M("'.$model.'")->postData();
			if($'.$p_key.'){
				M("'.$model.'")->update($data,"'.$p_key.'=\'$'.$p_key.'\'");
			}else{
				M("'.$model.'")->insert($data);
			}
			$this->goall("保存成功");
		}
		';
		
		$status && $str.='
		public function onStatus(){
			$'.$p_key.'=get_post(\''.$p_key.'\',"i");
			$status=get_post("status","i");
			M("'.$model.'")->update(array("status"=>$status),"'.$p_key.'=$'.$p_key.'");
			$this->goall("状态修改成功");
		}
		';
		
		$delete && $str.='
		public function onDelete(){
			$'.$p_key.'=get_post(\''.$p_key.'\',"i");
			M("'.$model.'")->update(array("status"=>11),"'.$p_key.'=$'.$p_key.'");
			$this->goAll("删除成功");
			 
		}
		';
		$str.='
		
	}

?>';
if(!file_exists(ROOT_PATH."module/{$module}/source/{$dir}/{$c}.ctrl.php") or $copy){
	//生成控制器
	umkdir(ROOT_PATH."module/{$module}/source/{$dir}");
	file_put_contents(ROOT_PATH."module/{$module}/source/{$dir}/{$c}.ctrl.php",iconv("utf-8","utf-8",$str));
	//生成模板
	if($istpl){
		umkdir(ROOT_PATH.MODULESKINS."/{$dir}/{$tpldir}/");
		$defaulttpl=ROOT_PATH.MODULESKINS."/{$dir}/{$tpldir}/index.html";		
		$tplcontent=file_get_contents("tpl/$tpl");
		//生成列表页
		$con=file_get_contents("http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/sqllist.php?table=".$table."&data=list");
		preg_match("/<pre.*>(.*)<\/pre>/iUs",$con,$d);
		$content=str_replace(array("[nav]","[tpl]"),array("{include file='{$tpldir}/nav.html'}",html($d[1])),$tplcontent);
		$content=str_replace("[操作]",'<a href="'.$rootphp.'?m='.$c.'&a=add&'.$p_key.'={$c.'.$p_key.'}">编辑</a> <a href="/module.php?m='.$c.'&a=show&'.$p_key.'={$c.'.$p_key.'}">查看</a> <a href="javascript:;" class="js-delete" url="'.$rootphp.'?m='.$c.'&a=delete&ajax=1&'.$p_key.'={$c.'.$p_key.'}">删除</a>',$content);
		$content=str_replace("&quot;",'"',$content);
		file_put_contents($defaulttpl,$content);
		//生成nav
		
		$content=file_get_contents("tpl/nav.tpl");
		$content=str_replace("&quot;",'"',$content);
		$content=str_replace("[ctrl]",$c,$content);
		file_put_contents(ROOT_PATH."".MODULESKINS."/{$dir}/{$tpldir}/nav.html",$content);
		//生成add页
		if($add){
			$addtpl=ROOT_PATH."".MODULESKINS."/{$dir}/{$tpldir}/add.html";	
			$con=file_get_contents("http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/sqlform.php?table=".$table."&data=data");
			preg_match("/<pre.*>(.*)<\/pre>/iUs",$con,$d);
			$content=str_replace(array("[nav]","[tpl]"),array("{include file='{$tpldir}/nav.html'}",html($d[1])),$tplcontent);
			$content=str_replace("[action]",'/'.$rootphp.'?m='.$c."&a=save",$content);
			$content=str_replace("&quot;",'"',$content);
			file_put_contents($addtpl,$content);
		}
		//生成show也
		if($show){
			$addtpl=ROOT_PATH."".MODULESKINS."/{$dir}/{$tpldir}/show.html";	
			$con=file_get_contents("http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/sqlshow.php?table=".$table."&data=data");
			preg_match("/<pre.*>(.*)<\/pre>/iUs",$con,$d);
			$content=str_replace(array("[nav]","[tpl]"),array("{include file='{$tpldir}/nav.html'}",html($d[1])),$tplcontent);
			$content=str_replace("&quot;",'"',$content);
			file_put_contents($addtpl,$content);
		}
		
		
		
	}
	echo "生成成功";
}else{
	echo "文件已存在";
}
?>
 