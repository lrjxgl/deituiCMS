<?php
class categoryControl extends skymvc{
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function onDefault(){
		$pid=get('pid','i');
		$where= " status in(0,1,2,3,4) AND pid=$pid  ";
		$tablename=get('tablename','h');
		if(empty($tablename)){
			$tablename="article";
		} 
		$where.=" AND tablename='".$tablename."'";
		$url=APPADMIN."?m=category&tablename=".$tablename;
		 
		$start=get('per_page','i');
		$option=array(
			"where"=>$where,
			"order"=>" orderindex ASC",
			"start"=>$start,
			"limit"=>100,
		);
		 
		$catlist=M("category")->getlist($option,true);
		if($pid){
			$parent=M("category")->selectRow(array("where"=>array("catid"=>$pid)));
			$nextpid=$parent['pid'];
		}
		$pagelist=$this->pagelist($rscount,100,$url);
	 
		$this->smarty->assign(
			array(
				"catlist"=>$catlist,
				"modellist"=>$modellist=M("model")->select(array("where"=>"status=1")),
				"nextpid"=>$nextpid,
				"pagelist"=>$pagelist,
				"tablename"=>$tablename
			)
		);
		$this->smarty->display("category/index.html");
	}
	
	public function onAdd(){
		$tablename=max(1,get_post('tablename','i'));
		$modellist=M("model")->select(array("where"=>"status=1"));
		$pid=get('pid','i');
		if($pid){
			$parent=M("category")->selectRow(array("where"=>array("catid"=>$pid)));
			$tablename=$parent['tablename'];
			$this->smarty->assign(
				"parent",$parent
			);
		}
		$catid=get('catid','i');
		if($catid){
			$data=M("category")->selectRow(array("where"=>array("catid"=>$catid)));
			$tablename=$data['tablename'];
			$this->smarty->assign("data",$data);
			if($data){
				$catlist=M("category")->children(0,$data['tablename']);
			}
			
		}
		
		$this->smarty->assign(
			array(
				"modellist"=>$modellist,
				"catlist"=>$catlist,
				 
				"tablename"=>$tablename
			)
		);
		$this->smarty->display("category/add.html");
	}
	
	
	public function onSave(){
		$catid=get_post('catid','i');
		$data=M("category")->postData();
		 
		if($data['pid']){
			$parent=M("category")->selectRow(array("where"=>array("catid"=>$data['pid'])));
			$data['tablename']=$parent['tablename'];
			$data['level']=$parent['level']+1;
			 
		}else{
			$model=M("model")->selectRow(array("where"=>array("id"=>$data['tablename'])));
			
			if(!$catid){
				$data['level']=1;
			}
			
		}
		
		
		if($catid){
			unset($data['tablename']);
			unset($data['parent_id']);
			
			unset($data['level']);
			M("category")->update($data,array("catid"=>$catid));
		}else{
				 				
			M("category")->insert($data);
		}
		$this->onLevel(1);
		$this->goAll("保存成功");
	}
	
	/*批量子分类添加*/
	public function onAddmore(){
		$catid=get('catid','i');
		$tablename=max(1,get_post('tablename','i'));
		$data=M("category")->selectRow(array("where"=>"catid=".$catid));
		if(empty($data)) $this->goall("数据出错",1);
		$this->smarty->assign(array(
			"data"=>$data,
			"tablename"=>$tablename
		));
		$this->smarty->display("category/addmore.html");
	}
	
	public function onSaveMore(){
		$catid=get_post('catid','i');
		$data=M("category")->selectRow(array("where"=>"catid=".$catid));
		if(empty($data)) $this->goall("数据出错",1);
		$content=post('content');
		$arr=explode("\r\n",$content);
		if($arr){
			foreach($arr as $v){
				$v=trim($v);
				if(!empty($v)){
					$t_d=array(
						"cname"=>$v,
						"title"=>$v,
						"keywords"=>$v,
						"description"=>$v,
						"pid"=>$data['catid'],
						"type_id"=>$data['type_id'],
						"level"=>$data['level']+1, 
						"tablename"=>$data['tablename']
					);
					M("category")->insert($t_d);
				}
			}
		}
		$this->goall("添加成功");
	}
	
	public function OnChangestatus(){
		$status=get('status','i');
		$catid=get('catid','i');
		M("category")->update(array("status"=>$status),array("catid"=>$catid));
		$this->goAll("保存成功");
	}
	public function onOrderindex(){
		$catid=get('catid','i');
		$orderindex=get('data','i');
		M("category")->update(array("orderindex"=>$orderindex),array("catid"=>$catid));
		$this->goAll("保存成功");
	}
	
	
	public function onDelete(){
		$catid=get('catid','i');
		M("category")->update(array("status"=>99),array("catid"=>$catid));
		$this->goAll("删除成功");	
	}
	
	public function onAjax_getchild(){
		$pid=get('pid','i');
		
		$data=M("category")->select(array("where"=>array("pid"=>$pid),"order"=>" orderindex asc"));
		
		echo "<option value=0>{$this->lang['please_select']}</option>";
		if($data){
			foreach($data as $k=>$v){
				echo "<option value='{$v['catid']}'>{$v['cname']}</option>";
			}
		}
		exit;
	}
	
	public function onLevel($res=false){
		M("category")->update(array("level"=>99),"1");
		M("category")->update(array("level"=>1),"pid=0");
		$this->level(1);
		$this->level(2);
		$this->level(3);
		$this->level(4);
		$this->level(5);
		$this->level(6);
		$this->level(7);
		$this->level(8);
		$this->level(9);
		if($res) return true;
		$this->goall("分类修复成功");
	}
	
	public function level($level=1){
		$ids=M("category")->selectCols(array(
			"where"=>"level=".$level,
			"fields"=>"catid",
			"limit"=>100000
		));
		$ids && M("category")->update(array("level"=>$level+1),"pid in("._implode($ids).")");
	}
	
}
?>