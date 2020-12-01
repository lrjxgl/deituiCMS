<?php
class indexControl extends skymvc
{
	function __construct()
	{
		parent::__construct();
	}
	
	

	public function onDefault()
	{
		$res=M("navbar")->select(array(
			"where"=>" group_id=2 AND status=1 ",
			"order"=>" orderindex ASC"
		));
		$a=$b=array();
		$permission=unserialize(M("admin_group")->selectOne(array("where"=>array("id"=>$_SESSION['ssadmin']['group_id']),"fields"=>"content")));
		if($res){
			foreach($res as $k=>$v){
				if(!$this->checkpermission($permission,$v['m'],$v['a'])){
					if( !$_SESSION['ssadmin']['isfounder']){
						unset($res[$k]);
						continue;
					} 
				}
				if($v['pid']==0){
					$a[]=$v;
				}else{
					$b[$v['pid']][]=$v;
				}
			}
			foreach($a as $k=>$v){
				if(isset($b[$v['id']])){
					$a[$k]['child']=$b[$v['id']];
				}
			}
		}
		$topNav=M("navbar")->select(array(
			"where"=>" group_id=1 AND status=1 ",
			"order"=>" orderindex ASC"
		));
		 $this->smarty->goAssign(array(
			"navList"=>$a,
			"topNav"=>$topNav
		 ));
		$this->smarty->display("index.html");
	}
	
	public function onMain(){
		$version=cmsVersion::get();
		$this->smarty->goAssign(array(
			"version"=>$version
		));
		$this->smarty->display("index/main.html");
	}
	
	public function onStatWeekAll(){
		//PV
		$time=strtotime(date("Y-m-d 00:00:00"));
		for($i=7;$i>=0;$i--){
			$labels[]=date("m月d",$time-$i*3600*24);
		}
		$total=0;
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
			$w="";
			if($url){
				$w=" url like '".$url."%' AND ";
			}
			$sql="select count(*) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$pvMoneys[]=$count=M("pv")->getOne($sql);
			 
		}
		//uv
		$total=0;
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
			$w="";
			if($url){
				$w=" url like '".$url."%' AND ";
			}
			$sql="select COUNT(distinct(ssid)) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$uvMoneys[]=$count=M("pv")->getOne($sql);
			 
		}
		//ip
		$total=0;
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
			$w="";
			if($url){
				$w=" url like '".$url."%' AND ";
			}
			$sql="select COUNT(distinct(ip)) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$ipMoneys[]=$count=M("pv")->getOne($sql);
			 
		}
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
		 
			$sql="select COUNT(*) from ".table('user')." where   createtime like '".$h."%'";
			 
			$userMoneys[]=$count=M("user")->getOne($sql);
			 
		}
		$this->smarty->goAssign(array(
			"labels"=>$labels,
			"pvMoneys"=>$pvMoneys,
			"ipMoneys"=>$ipMoneys,
			"uvMoneys"=>$uvMoneys,
			"userMoneys"=>$userMoneys,
			"total"=>$total
		));
		
	}
	/*****检测新版本*****/
	public function onCheckNewVersion(){
		$key="admin_CheckNewVersion";
		$version=cmsVersion::get();
		
		$data=file_get_contents($version["checkversion"]."&domain=".$_SERVER['HTTP_HOST']);
		 
		$res=json_decode($data,true);
		if($res["version"]>$version["version_num"]){
			$this->goAll("success",0,array(
				"isnew"=>1,
				"version_num"=>$res["version"],
				"desc"=>$res["desc"]
			));
		}else{
			$this->goAll("success",0,array(
				"isnew"=>0,
				"version_num"=>$res["version"],
				"desc"=>$res["desc"]
			));
		}
	}
	/***检测授权****/
	public function onshouquan(){
		$key="admin_iframe_shouquan";
		$version=cmsVersion::get();
	 
		$data=file_get_contents($version["checkshouquan"]."&domain=".$_SERVER['HTTP_HOST']);
		echo $data;
	}
	public function onUpdate(){
		set_time_limit(10000);
		$key="admin_iframe_update";
		$version=cmsVersion::get(); 
		$c=file_get_contents($version["onlineupdate"]."&domain=".$_SERVER['HTTP_HOST']);
		
		$v=json_decode($c,true);
		if(isset($v['error'])){
			exit(json_encode(array("error"=>1,"message"=>$v['message'])));
		} 
		$now=$version["version_num"];
		 
		if($v){
			foreach($v as $d){
				if($d['v']>$now){
					 
					$this->updateNow($d['f']);
					$now=$d['v'];
				}
			}
		}
		exit(json_encode(array("error"=>0,"message"=>"success")));
		 
	}
	 
	
	function updateNow($file){
		umkdir("update");
		$version=cmsVersion::get(); 
		file_put_contents(ROOT_PATH."update/update.zip",file_get_contents($file));
		 
		$this->loadClass("pclzip",false,false);
		$zip = new pclzip(ROOT_PATH."update/update.zip");
		$zip->extract(ROOT_PATH."update");
	 
		chmod(ROOT_PATH."update/index.php",0777);
		if(file_exists(ROOT_PATH."update/updatesql.php")){
			chmod(ROOT_PATH."update/updatesql.php",0777);
		}
		
		file_get_contents("http://".$_SERVER['HTTP_HOST']."/update/index.php?a=update");
		delfile(ROOT_PATH."update",1);
		return true;
	}
	
}

?>