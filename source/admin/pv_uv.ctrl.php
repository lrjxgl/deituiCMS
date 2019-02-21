<?php
class pv_uvControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$this->smarty->goAssign(array(
			"statType"=>"pv"
		));
		$this->smarty->display("pv/index.html");
	}
	public function onStatHour(){
		//$labels="";
		//$moneys=array(123,1234);
		
		$url=get("url",'h'); 
		$time=strtotime(date("Y-m-d H:i:00"));
		for($i=60;$i>=0;$i--){
			$labels[]=date("H时i",$time-$i*60);
		}
		$total=0;
		for($i=60;$i>=0;$i--){
			$h=date("Y-m-d H:i",$time-$i*60);
			$w="";
			if($url){
				$w=" url like '".$url."%' AND ";
			}
			$sql="select COUNT(distinct(ssid)) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$moneys[]=$count=M("pv")->getOne($sql);
			$total+=$count;
		}
		$this->smarty->goAssign(array(
			"labels"=>$labels,
			"moneys"=>$moneys,
			"total"=>$total
		));
	}
	public function onStatDay(){
		//$labels="";
		//$moneys=array(123,1234);
		
		$url=get("url",'h'); 
		$time=strtotime(date("Y-m-d H:00:00"));
		for($i=24;$i>=0;$i--){
			$labels[]=date("H时",$time-$i*3600);
		}
		$total=0;
		for($i=24;$i>=0;$i--){
			$h=date("Y-m-d H",$time-$i*3600);
			$w="";
			if($url){
				$w=" url like '".$url."%' AND ";
			}
			$sql="select COUNT(distinct(ssid)) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$moneys[]=$count=M("pv")->getOne($sql);
			$total+=$count;
		}
		$this->smarty->goAssign(array(
			"labels"=>$labels,
			"moneys"=>$moneys,
			"total"=>$total
		));
	}
	
	public function onStatWeek(){
		//$labels="";
		//$moneys=array(123,1234);
		
		$url=get("url",'h'); 
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
			$sql="select COUNT(distinct(ssid)) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$moneys[]=$count=M("pv")->getOne($sql);
			$total+=$count;
		}
		$this->smarty->goAssign(array(
			"labels"=>$labels,
			"moneys"=>$moneys,
			"total"=>$total
		));
	}
	public function onStatMonth(){
		//$labels="";
		//$moneys=array(123,1234);
		
		$url=get("url",'h'); 
		$time=strtotime(date("Y-m-01 00:00:00"));
		for($i=12;$i>=0;$i--){
			$labels[]=date("y年m",strtotime("-$i month",$time));
		}
		$total=0;
		for($i=12;$i>=0;$i--){
			$h=date("Y-m",strtotime("-$i month",$time));
			$w="";
			if($url){
				$w=" url like '".$url."%' AND ";
			}
			$sql="select COUNT(distinct(ssid)) from ".table('pv')." where ".$w." createtime like '".$h."%'";
			 
			$moneys[]=$count=M("pv")->getOne($sql);
			$total+=$count;
		}
		$this->smarty->goAssign(array(
			"labels"=>$labels,
			"moneys"=>$moneys,
			"total"=>$total
		));
	}
 
}
?>