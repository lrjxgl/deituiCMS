<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class b2c_categoryControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" status in(0,1,2)";
			$url="/moduleadmin.php?m=b2c_category&a=default";
			$limit=200000;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" orderindex ASC",
				"where"=>$where
			);
			$rscount=true;
			$rss=M("mod_b2c_category")->select($option,$rscount);
			if($rss){
				foreach($rss as $rs){
					if($rs["pid"]==0){
						$catlist[]=$rs;
					}else{
						$child[$rs["pid"]][]=$rs;
					}
				}
				foreach($catlist as $k=>$v){
					$v["child"]=$child[$v["catid"]];
					$catlist[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"catlist"=>$catlist,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("b2c_category/index.html");
		}
		
		public function onAdd(){
			$catid=get_post("catid","i");
			if($catid){
				$data=M("mod_b2c_category")->selectRow(array("where"=>"catid={$catid}"));	
			}
			
			$catlist=M("mod_b2c_category")->select(array(
				"where"=>" status=1 AND pid=0"
			));
			//表单扩展
			$tableList=M("table")->select(array(
				"where"=>" status<3"
			));
			$this->smarty->goassign(array(
				"data"=>$data,
				"catlist"=>$catlist,
				"tableList"=>$tableList
			));
			$this->smarty->display("b2c_category/add.html");
		}
		
		public function onSave(){
			$catid=get_post("catid","i");
			$data=M("mod_b2c_category")->postData();
			if($catid==$data["pid"]){
				$data["pid"]=0;
			}
			if($catid){
				M("mod_b2c_category")->update($data,"catid='$catid'");
			}else{
				M("mod_b2c_category")->insert($data);
			}
			$this->goall("保存成功");
		}
		
		public function onAddmore(){
			$catid=get('catid','i');
			 
			$data=M("mod_b2c_category")->selectRow(array("where"=>"catid=".$catid));
			if(empty($data)) $this->goall("数据出错",1);
			$this->smarty->assign(array(
				"data"=>$data,
				 
			));
			$this->smarty->display("b2c_category/addmore.html");
		}
		public function onSaveMore(){
			$catid=get_post('catid','i');
			$data=M("mod_b2c_category")->selectRow(array("where"=>"catid=".$catid));
			if(empty($data)) $this->goall("数据出错",1);
			$content=post('content');
			$arr=explode("\r\n",$content);
			if($arr){
				foreach($arr as $v){
					$v=trim($v);
					if(!empty($v)){
						$t_d=array(
							 
							"title"=>$v,
							 
							"description"=>$v,
							"pid"=>$data['catid'],
						 
							 
						);
						M("mod_b2c_category")->insert($t_d);
					}
				}
			}
			$this->goall("添加成功");
		}
		public function onStatus(){
			$catid=get_post('catid',"i");
			$row=M("mod_b2c_category")->selectRow("catid=".$catid);
			$status=1;
			if($row["status"]==1){
				$status=2;
			}
			M("mod_b2c_category")->update(array(
				"status"=>$status
			),"catid=".$catid);
			$this->goAll("success",0,$status);
		}
		
		public function onDelete(){
			$catid=get_post('catid',"i");
			$child=M("mod_b2c_category")->selectRow("pid=".$catid." AND status<4");
			if($child){
				$this->goAll("有下级分类不能删除",1);
			}
			M("mod_b2c_category")->update(array("status"=>11),"catid=$catid");
			$this->goAll("删除成功");
			 
		}
		
		
	}

?>