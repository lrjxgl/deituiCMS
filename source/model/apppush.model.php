<?php
class apppushModel extends model{
	 
	public $oc_where;
	public function __construct (){
		parent::__construct ();
		 
		$this->table="apppush";
	}
	
	 
	
	public function getListByIds($shopids,$fields=""){
		if(!empty($shopids)){
			$option['where']=" id in(".implode(",",$shopids).")";
			$fields && $option['fields']=$fields;
			$data=parent::select($option);
			if($data){
				$shoplist=array();
				foreach($data as $k=>$v){
					$shoplist[$v['id']]=$v;
				}
				return $shoplist;
			}
		}
		return false;
	}
	
	/**
	*增加客户端推送 add("ymdian");
	*/
	public function Add($col,$admin=array()){
		 
		//处理推送相关
		$data=M("apppush")->postData();
		//file_put_contents("log.txt",json_encode($data));
		if($data['appname']=='weixin'){
			$apppush=M("apppush")->selectRow(array(
			"where"=>"   appname='".$data['appname']."' AND openid='".$data['openid']."' "
		));
		}else{
			$apppush=M("apppush")->selectRow(array(
				"where"=>" token='".$data['token']."' AND appname='".$data['appname']."' AND clientid='".$data['clientid']."' AND appid='".$data['appid']."' AND appkey='".$data['appkey']."' AND openid='".$data['openid']."' "
			));
		}
		if($col=="userid"){
			$admin['adminid']=$admin['userid'];
		}
		$data['dateline']=time();
		if(($data['token'] && $data['clientid'])  or $data['openid']){
			if(!$apppush  ){
				$data[$col]=$admin['adminid'];
				M("apppush")->insert($data);
			}else{
				if($apppush[$col]!=$admin['adminid']){
					M("apppush")->update(array(
						$col=>$admin['adminid']
					),"id=".$apppush['id']);
				}
			}
		}
			
	}
	
	/**
	**增加商家通知操作
		$option
			array(
				"table"=>"koudai",
				"content"=>$content,
				"shopid"=>$shopid,
				"typeid"=>1	
			)
	*/
	public function sendShop($option){
		$table=$option['table'];
		if(is_array($option['content'])){
			$content=$option['content']['content'];
			$con=$option['content'];
		}else{
			$content=$option['content'];
		}
		if(isset($option['title'])){
			$title=$option['title'];
		}else{
			$title="通知";
		}
		$shopid=$option['shopid'];
		if(isset($option['retable'])){
			$retable=$option['retable'];
		}
		//发送推送信息
		$table_admin=$table."_admin";
		if($table=='shop'){
			$table_admin='shopadmin';
		}
		$adminids=M($table_admin)->selectCols(array(
			"where"=>" shopid=".$shopid."  ".($option['typeid']?" AND typeid=".$option['typeid']:""),
			"fields"=>" adminid "
		));
		 
		if($adminids){
			//发送通知
			foreach($adminids as $adminid){
				M($table."_notice")->insert(array(
						"dateline"=>time(),
						"content"=>$content, 
						"adminid"=>$adminid,
						"shopid"=>$shopid,
						"linkurl"=>arr2str($option['linkurl']),
						"title"=>$title
				));
			}
			$pushlist=M("apppush")->select(array(
				"where"=>"  ".$table."admin in("._implode($adminids).") "
			));
			if($pushlist){
				 
				foreach($pushlist as $v){
					$pdata=array(
						"pid"=>$v['id'],
						"typeid"=>1,
						"dateline"=>time(),
						"content"=>arr2str($option['content']),
						"template_id"=>$option['template_id'],
						"url"=>$option['url']
					);
					M("apppush_plan")->insert($pdata);
				}
			}
			
		}
		//End 推送信息
		
	}
	
	
	 
	
	
	
}

?>