<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class attachControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where="status in(0,1,2)";
			$url="/admin.php?m=attach&a=default";
			$limit=20;
			$start=get("per_page","i");
			$type=get("type","h");
			switch($type){
				case "new":
					$where=" status=0 ";
					break;
				case "pass":
					$where=" status=1 ";
					break;
				default:
					$_GET["type"]="all";
					break;
			}
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("attach")->select($option,$rscount);
			if($data){
				foreach($data as $v){
					$uids[]=$v["userid"];
				}
				$us=M("user")->getUserByIds($uids,"userid,nickname");
				foreach($data as $k=>$v){
					if($v["userid"]){
						$v["nickname"]=$us[$v["userid"]]["nickname"];
					}
					
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("attach/index.html");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=1;
			M("attach")->update(array("status"=>$status),"id=".$id);
			$this->goall("状态修改成功",0,$status);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			$row=M("attach")->selectRow("id=".$id);
			if(file_exists($row["file_url"])){
				@unlink($row["file_url"]);
			}
			if($row["file_group"]=='img'){
				$res=array(
					$row["file_url"].".100x100.jpg",
					$row["file_url"].".small.jpg",
					$row["file_url"].".middle.jpg",
				);
				foreach($res as $v){
					if(file_exists($v)){
						@unlink($v);
					}
				}
			}
			if(UPLOAD_OSS){
				include_once(ROOT_PATH."api/ossapi/ossapi.php");
				$res=OSS_delete_Object(OSS_BUCKET,$row["file_url"]);
				if($row["file_group"]=='img'){
					$res=array(
						$row["file_url"].".100x100.jpg",
						$row["file_url"].".small.jpg",
						$row["file_url"].".middle.jpg",
					);
					
					foreach($res as $v){
						$res=OSS_delete_Object(OSS_BUCKET,$v);
					}
				}
				 
			}
			M("attach")->update(array("status"=>11),"id=".$id);
			$this->goall("删除成功",0);
		}
		
		
	}

?>