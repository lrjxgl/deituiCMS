<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class zbliveControl extends skymvc{
		public $zbstatuslist=array(
			0=>"即将直播",
			1=>"正在直播",
			2=>"直播已结束"
		);
		public $tableList=array(
			"b2c_product"=>"B2C",
			"b2b_product"=>"B2B",
			"taoke"=>"淘客",
			"flk_product"=>"返利商城"
		);
		public function __construct(){
			parent::__construct();
			 
		}
		public function onInit(){
			 
			if(get('a')!='menu'){
				$row=M("mod_zblive_config")->selectRow();
				if(empty($row)){
					header("Location: moduleadmin.php?m=zblive_config");
					exit;
				}
				foreach($row as $k=>$v){
					define(strtoupper($k),$v);
				}
			}
			
		}
		
		public function onMenu(){
			$this->smarty->display("menu.html");
		}
		
		public function onDefault(){
				$url="/moduleadmin.php?m=zblive&a=default"; 
			$status=get_post('bstatus','i');
			if($status){
				$url.="&bstatus=".$status;
				$where=" bstatus=$status ";
			}else{
				$where=" bstatus<11 ";
			}
			 
			$id=intval(get('id','i'));
			if($id){
				$where.=" AND id=$id";
			}

			$title=get_post('title','h');
			if($title){
				$where.=" AND title like '%{$title}%' ";
				$url.="&title=".urlencode($title);
			}

			$s_index=get_post('s_index','i');
			if($s_index){
				$url.="&s_index=".$s_index;
				$where.=" AND isindex=".($s_index==1?1:0);
			}
			$s_recommend=get_post('s_recommend','i');
			if($s_recommend){
				$url.="&s_recommend=".$s_recommend;
				$where.=" AND is_recommend=".($s_recommend==1?1:0);
			}
			
			$s_new=get_post('s_new','i');
			if($s_new){
				$url.="&s_new=".$s_new;
				$where.=" AND isnew=".($s_new==1?1:0);
			}
			
			$s_hot=get_post('s_hot','i');
			if($s_hot){
				$url.="&s_hot=".$s_hot;
				$where.=" AND ishot=".($s_hot==1?1:0);
			}	
			$zbtype=get("zbtype","h");
			$url.="&zbtype=".$zbtype;
			switch($zbtype){
				case "unbegin":
						$where.=" AND zbstatus=0 AND starttime>".time();
					break;
				case "doing":
						$where.=" AND zbstatus=1";
					break;
				case "finish":
						$where.=" AND zbstatus=2 ";
					break;
			}
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_zblive")->select($option,$rscount);
			if($data){
				foreach($data as $k=>$v){
					$v['imgurl']=images_site($v['imgurl']);
					$v['zbstatus_name']=$this->zbstatuslist[$v['zbstatus']];
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
			$this->smarty->display("zblive/index.html");
		}
		
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("mod_zblive")->selectRow(array("where"=>"id={$id}"));
				
			}
			$config=M("mod_zblive_config")->selectRow();
			
			$this->smarty->goassign(array(
				"data"=>$data,
				"zconfig"=>$config,
				"tableList"=>$this->tableList
			));
			$this->smarty->display("zblive/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$starttime=strtotime(post('starttime'));
			$endtime=strtotime(post('endtime'));
			$data=M("mod_zblive")->postData();
			$data['starttime']=$starttime;
			$data['endtime']=$endtime;
			if($id){
				//$data['mp4url']=BACKHOST."zblive".$id.".mp4";
				M("mod_zblive")->update($data,"id='$id'");
			}else{
				
				$id=M("mod_zblive")->insert($data);
				$token=$this->getToken(ZBRTMP."zblive".$id."?vhost=".ZBVHOST);
				$token=str_replace(ZBRTMP,"",$token);
				M("mod_zblive")->update(array(
					"auth_key"=>$token,
					//"mp4url"=>BACKHOST."zblive".$id.".mp4"
				),"id=".$id);
			}
			$this->goall("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$bstatus=get_post("bstatus","i");
			M("mod_zblive")->update(array("bstatus"=>$bstatus),"id=$id");
			$this->goall("状态修改成功");
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("mod_zblive")->update(array("bstatus"=>11),"id=$id");
			$this->goAll("删除成功");
			 
		}
		
	public function getToken($url){
			$a=parse_url($url);
		 
			$path=$a['path'];
			$mkey=ZBKEY;
			$time=time()+3600*24;
			$hash=md5($path."-".$time."-0-0-".$mkey);
			$url=$url."?auth_key=".$time."-0-0-".$hash;
			return $url;
			 
		}
		
	public function onSetToken(){
		$id=get_post('id','i');
		if(!$id) exit("DIE ACCESS");
		$token=$this->getToken(ZBRTMP."zblive".$id);
		$token=str_replace(ZBRTMP,"",$token);
		M("mod_zblive")->update(array(
			"auth_key"=>$token
		),"id=".$id);
		$this->goAll("刷新成功",0,$token); 
	}
	
 
		
	public function onRecommend(){
			$id=get('id','i');
			$is_recommend=get('is_recommend','i');
			M("mod_zblive")->update(array("is_recommend"=>$is_recommend),array("id"=>$id));	
			echo json_encode(array("error"=>0,"message"=>$this->lang['save_success']));	 
		}
		 
		public function onnew(){
			$id=get('id','i');
			$isnew=get('isnew','i');
			M("mod_zblive")->update(array("isnew"=>$isnew),array("id"=>$id));	
			echo json_encode(array("error"=>0,"message"=>$this->lang['save_success']));	 
		}
		public function onisIndex(){
			$id=get('id','i');
			$isindex=get('isindex','i');
			M("mod_zblive")->update(array("isindex"=>$isindex),array("id"=>$id));	
			echo json_encode(array("error"=>0,"message"=>$this->lang['save_success']));	 
		}
		public function onhot(){
			$id=get('id','i');
			$ishot=get('ishot','i');
			M("mod_zblive")->update(array("ishot"=>$ishot),array("id"=>$id));	
			echo json_encode(array("error"=>0,"message"=>$this->lang['save_success']));	 
		}
	
	public function onGetTui(){
		$id=get('id','i');
		
		if($id){
			$token=$this->getToken(ZBRTMP."zblive".$id."?vhost=".ZBVHOST);
			$token=str_replace(ZBRTMP,"",$token);
			M("mod_zblive")->update(array(
				"auth_key"=>$token
			),"id=".$id);
			$row=M("mod_zblive")->selectRow("id=".$id);
		}else{
			$this->goAll("参数出错",1);
		}
		
		$config=M("mod_zblive_config")->selectRow("1=1");	
		$tuiurl=$config['zbrtmp'].$row['auth_key'];
		$this->smarty->goAssign(array(
			"tuiurl"=>$tuiurl,
			"mp4url"=>$this->getToken("rtmp://".ZBPATH."/zblive".$id."?"),
			"m3u8url"=>$this->getToken("http://".ZBPATH."/zblive".$id.".m3u8?"),
			"flvurl"=>$this->getToken("http://".ZBPATH."/zblive".$id.".flv?"),
		));
	}
	
	public function onSetType(){
			$id=get('id','i');
			$row=M("mod_zblive")->selectRow("id=".$id);
			switch(get('type')){
				case "start":
						M("mod_zblive")->update(array("zbstatus"=>0),"id=".$id);
					break;
				case "doing":
						M("mod_zblive")->update(array("zbstatus"=>1),"id=".$id);
					break;
				case "finish":
						if($row['endtime']<time()){
							M("mod_zblive")->update(array("zbstatus"=>2),"id=".$id);
						}else{
							M("mod_zblive")->update(array("zbstatus"=>0),"id=".$id);
						}
						
					break;
			}
			$this->goAll("success");
		}
		
	public function onGetRecordUrl(){
			/**
			 * https://live.aliyuncs.com/?Action=DescribeLiveStreamRecordIndexFiles&DomainName=live.aliyunlive.com&AppName=aliyuntest&StreamName=xxx&StartTime=xxx&EndTime=xxx&<公共请求参数>
			 */
			$id=get("id","i");
			$zblive=M("mod_zblive")->selectRow("id=".$id);
			if(!$zblive){
				$this->goAll("直播出错",1);
			}
			$StreamName="zblive".$id;
			$url="Action=DescribeLiveStreamRecordIndexFiles";
			$url.="&DomainName=".ZBVHOST;
			$url.="&AppName=".ZBAPPNAME;
			$url.="&StreamName=".$StreamName;
			$startTime=$this->gmt_iso8601($zblive["starttime"]);
			$endTime=$this->gmt_iso8601($zblive["endtime"]+600);
			$url.="&StartTime=".$startTime;
			$url.="&EndTime=".$endTime;
			$url.="&Order=desc";
			/**公共参数**/
			$url.="&Format=json&SignatureNonce=".microtime(true);
			$url.="&Version=2016-11-01&SignatureMethod=HMAC-SHA1&SignatureVersion=1.0";
			$url.="&AccessKeyId=".ACCESSKEYID;
			$url.="&Timestamp=".$this->gmt_iso8601(time());
			$url.="&Signature=".$this->getSign($url);
			/***end 公共参数*****/
			$url="https://live.aliyuncs.com/?".$url;
		 
			$c=curl_get_contents($url);
			$res=json_decode($c,true);
			 
			if($res['TotalNum']>0){
				$rs=$res['RecordIndexInfoList']['RecordIndexInfo'][0];
				M("mod_zblive")->update(array(
					"mp4url"=>str_replace("http://","https://",$rs['RecordUrl'])
				),"id=".$id);
				$this->goAll("success",0,$rs['RecordUrl'],$res);
			}else{
				$this->goAll("error",1,$res);
			}

		}
	
	public function gmt_iso8601($time) {
	 	$time=$time-3600*8;
        $dtStr = date("c", $time);
        
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
	}
	/***阿里云签名***/
	public function getSign($str){
		
	 	$signstr="GET&%2F&";		 	
		parse_str($str,$arr);			
		ksort($arr);		 	
		$i=0;
		foreach($arr as $k=>$v){
			if($i>0){
				$signstr.="%26";
			}	  
			$signstr.= "$k%3D".urlencode($v);
			$i++;				
		}
		$signstr=str_replace("%3A","%253A",$signstr);
		$signstr=str_replace("+","%20",$signstr);
		$signstr=str_replace("*","%2A",$signstr);
		$signstr=str_replace("~","%7E",$signstr);
		 
		$key=ACCESSKEYKEY."&";
		$signature = base64_encode(hash_hmac('sha1', $signstr, $key, true));
		$signature=urlencode($signature);
		return $signature;
	}			
}

?>