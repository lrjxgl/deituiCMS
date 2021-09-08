<?php
class statControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
		session_write_close();
	}
	public function onDefault(){
		
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
			$sql="select count(*) from ".table('pv_day')." where ".$w." createtime like '".$h."%'";
			 
			$pvMoneys[]=$count=M("pv")->getOne($sql);
			 
		}
		//uv
		/*
		$total=0;
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
			$w="";
			 
			$sql="select COUNT(*) from ".table('pv_uv')." where   createtime like '".$h."%'";
			 
			$uvMoneys[]=$count=M("pv")->getOne($sql);
			 
		}
		*/
		//ip
		$total=0;
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
			 
			 
			$sql="select COUNT(*) from ".table('pv_ip')." where   createtime like '".$h."%'";
			 
			$ipMoneys[]=$count=M("pv")->getOne($sql);
			 
		}
		
		$this->smarty->goAssign(array(
			"labels"=>$labels,
			"pvMoneys"=>$pvMoneys,
			"ipMoneys"=>$ipMoneys,
			//"uvMoneys"=>$uvMoneys,
			 
			"total"=>$total
		));
		
	}
	
	public function onWeekUser(){
		$time=strtotime(date("Y-m-d 00:00:00"));
		for($i=7;$i>=0;$i--){
			$labels[]=date("m月d",$time-$i*3600*24);
		}
		$list=array();
		for($i=7;$i>=0;$i--){
			$h=date("Y-m-d",$time-$i*3600*24);
		 
			$sql="select COUNT(*) from ".table('user')." where   createtime like '".$h."%'";
			 
			$num=M("user")->getOne($sql);
			$list[]=$num==null?0:$num;
			 
		}
		$this->goAll("success",0,array(
			"labels"=>$labels,
			"list"=>$list
		));
	}
	
	public function onWeekRecharge(){
		$time=strtotime(date("Y-m-d 00:00:00"));
		for($i=7;$i>=0;$i--){
			$labels[]=date("m月d",$time-$i*3600*24);
		}
		$list=array();
		for($i=7;$i>=0;$i--){
			 
			$stime=$time-$i*3600*24;
			$etime=$stime+3600*24;
			$sql="select sum(money) from ".table('recharge')." where status=1 AND dateline>=".$stime." AND dateline<".$etime."   ";
			$num=M("recharge")->getOne($sql); 
			 
			$list[]=$num==null?0:$num;
			 
		}
		$this->goAll("success",0,array(
			"labels"=>$labels,
			"list"=>$list
		));
	}
	
}
?>