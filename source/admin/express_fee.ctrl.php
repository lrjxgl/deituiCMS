<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class express_feeControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" 1 ";
			$url=APPADMIN."?m=express_fee&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("express_fee")->select($option,$rscount);
			if($data){
				foreach($data as $v){
					$shopids[]=$v['shopid'];
				}
				$shops=M("shop")->getShopByIds($shopids);
				foreach($data as $k=>$v){
					$v['shop_name']=$shops[$v['shopid']]['shopname'];
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("express_fee/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("express_fee")->selectRow(array("where"=>"id={$id}"));
				
			}
			$provincelist=M("district")->select(array("where"=>"upid=0"));
			if($id){
				$opt=array(
					"where"=>"pid=".$id
				);
				$cityids=M("express_fee_city")->getCityIds($opt);
				//选出其他配送方案的省份
				$oids=M("express_fee_city")->getCityIds(array(
					"where"=>"  pid!=".$id
				));
			}else{
				//选出其他配送方案的省份
				$oids=M("express_fee_city")->getCityIds(array(
					"where"=>" 1 "
				));
			}
			if($oids){
				foreach($provincelist as $k=>$v){
					if(in_array($provincelist[$k]['id'],$oids)){
						unset($provincelist[$k]);
					}
				}
			}
			if($provincelist && $cityids){
				foreach($provincelist as $k=>$v){
					if(in_array($v['id'],$cityids)){
						$v['selected']=1;
					}
					$provincelist[$k]=$v; 
				}
			}
			$this->smarty->goassign(array(
				"data"=>$data,
				"provincelist"=>$provincelist
			));
			$this->smarty->display("express_fee/add.html");
		}
		
		public function onSave(){
			$id=get_post("id","i");
			$data=M("express_fee")->postData();
			
			if($id){
				M("express_fee")->update($data,"id='$id'");
			}else{
				$id=M("express_fee")->insert($data);
			}
			$cityids=$_POST['cityids'];
			 
			$delids=$hvids=M("express_fee_city")->selectCols(array(
				"where"=>"pid=".$id,
				"fields"=>"id"
			));
			if($cityids){
				foreach($cityids as $c){
					if($c){
						$cids[]=intval($c);
					}
				}
				//删除
				$delids=array_diff($hvids,$cids);
				//添加
				$addids=array_diff($cids,$hvids);							
			}
			
			if($addids){
					foreach($addids as $areaid){
						if(!M("express_fee_city")->selectRow("pid=".$id." AND areaid=".$areaid)){
							M("express_fee_city")->insert(array(
								"pid"=>$id,
								"areaid"=>$areaid
							));
						}
					}
			}
			
			if($delids){
				foreach($delids as $areaid){
					M("express_fee_city")->delete("pid=".$id." AND areaid=".$areaid);
				}
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("express_fee")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("express_fee")->delete("id=".$id);
			$this->goall("删除成功",0);
		}
		
		
	}

?>