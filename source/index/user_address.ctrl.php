<?php
	if(!defined("ROOT_PATH")) exit("die Access ");
	class user_addressControl extends skymvc{
		
		public function __construct(){
			parent::__construct();	
		}
		
		public function onInit(){
			M("login")->checkLogin();
			$this->userid=M("login")->userid;
		}
		
		public function onDefault(){
			$this->onMy();
		}
		public function onMy(){
			$where=" status=2 AND  userid=".$this->userid;
			$url="/index.php?m=user_address&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("user_address")->select($option,$rscount);
			
			if($data){
				foreach($data as $v){
					$d_ids[]=$v['province_id'];
					$d_ids[]=$v['city_id'];
					$d_ids[]=$v['town_id'];
				}
				 
				foreach($data as $k=>$v){
				 
					$data[$k]=$v;
				} 
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
					"dist_list"=>$dist_list
				)
			);
			$this->smarty->display("user_address/my.html");
		}
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("user_address")->selectRow("id={$id}");
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("user_address/add.html");
		}
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("user_address")->selectRow("id={$id} AND userid=".M("login")->userid);
				if(empty($data)) $this->goall("数据不存在",1);
				$city_list=M("district")->dist_list(array("where"=>"upid=".$data['province_id']." "));
				$town_list=M("district")->dist_list(array("where"=>"upid=".$data['city_id']." "));
				
				$ids=array($data['province_id'],$data['city_id'],$data['town_id']);
				$rss=M("district")->dist_list(array(
					"where"=>" id in("._implode($ids).") "
				));
				$pct="";
				if(isset($rss[$data['province_id']])){
					$pct.=$rss[$data['province_id']];
				}
				if(isset($rss[$data['city_id']])){
					$pct.=$rss[$data['city_id']];
				}
				if(isset($rss[$data['town_id']])){
					$pct.=$rss[$data['town_id']];
				}
				
			}
			$province_list=M("district")->dist_list(array("where"=>"upid=".DISTRICTID,"start"=>0,"limit"=>1000000));
			
			$this->smarty->goassign(array(
				"data"=>$data,
				"province_list"=>$province_list,
				"city_list"=>$city_list,
				"town_list"=>$town_list,
				"pct"=>$pct
			));
			$this->smarty->display("user_address/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$data["userid"]=$this->userid;
			$data["address"]=get_post("address","h");
			$data["telephone"]=get_post("telephone","h");
			$data["truename"]=get_post("truename","h");
		 	checkEmpty($data['address'],"地址不能为空");
		 	checkEmpty($data['telephone'],"联系电话不能为空");
		 	checkEmpty($data['truename'],"联系人不能为空");
			$data["province_id"]=get_post("province_id","i");
			/*
			if(empty($data['province_id'])){
				$this->goall("省份不能为空",1);
			}
			*/
			$data["city_id"]=get_post("city_id","i");
			$data["town_id"]=get_post("town_id","i");
			$data["dateline"]=time();
			$province=$city=$town="";
			$data['province_id'] && $province=M("district")->selectOne(array("where"=>"id=".$data['province_id'],"fields"=>"name")); 
			$data['city_id'] && $city=M("district")->selectOne(array("where"=>"id=".$data['city_id'],"fields"=>"name")); 
			$data['town_id'] && $town=M("district")->selectOne(array("where"=>"id=".$data['town_id'],"fields"=>"name")); 
			$data['pct_address']=$province.$city.$town.$data['address'];
			//获取位置信息
			$address=get("address","h");
			$c=file_get_contents("https://api.map.baidu.com/geocoder/v2/?address={$data['pct_address']}&output=json&ak=524fAYtg9vGGhZjIIMEHGsgpk9HQPhBQ");
			$arr=json_decode($c,true);
			if(isset($arr['result']['location']['lat'])){
				$lat=$arr['result']['location']['lat'];
				$lng=$arr['result']['location']['lng'];
				$data['lat']=$lat;
				$data['lng']=$lng;
			}
			
			$data['isdefault']=post("isdefault","i");
			$data['status']=2;
			if($data['isdefault']){
				M("user_address")->update(array(
					"isdefault"=>0
				)," userid=".M("login")->userid);
			}
			if($id){
				$row=M("user_address")->selectRow("id={$id} AND userid=".M("login")->userid);
				if(empty($row)){
					$this->goall("数据出错",1);				
				}
				M("user_address")->update($data,array('id'=>$id));
			}else{
				$id=M("user_address")->insert($data);
			}
			$data['id']=$id;
			 
			$this->goall("保存成功",0,$data);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("user_address")->update(array(
				"status"=>11
			),"id=".$id);
		 
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		
	}

?>