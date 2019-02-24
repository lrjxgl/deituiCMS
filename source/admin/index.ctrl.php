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
		if($res){
			foreach($res as $v){
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
	
	
}

?>