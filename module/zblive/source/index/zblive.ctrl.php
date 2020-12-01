<?php
	class zbliveControl extends skymvc{
		public $zbstatuslist=array(
			0=>"即将直播",
			1=>"正在直播",
			2=>"直播已结束"
		);
		public function __construct(){
			parent::__construct();
		}
		
		 
		public function onInit(){
			 
			$row=M("mod_zblive_config")->selectRow();
			if(empty($row)){
				 
				exit("暂无启用");
			}
			foreach($row as $k=>$v){
				define(strtoupper($k),$v);
			}
		}
		
	 
		
		public function onDefault(){
			
 
			$where=" bstatus=2 ";
			$url="/module.php?m=zblive";
			$limit=20;
			$start=get("per_page","i");
			switch(get_post('type')){
				case "unbegin":
				case "start":
						$where.=" AND zbstatus=0 AND starttime>".time();
					break;
				case "doing":
						$where.=" AND zbstatus=1";
					break;
					
				case "finish":
						$where.=" AND zbstatus=2 ";
					break;
			}
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
					$v["stime"]=date("Y-m-d H:i:s",$v["starttime"]);
					$v["etime"]=date("Y-m-d H:i:s",$v["etime"]);
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>=$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url,
				)
			);
			$this->smarty->display("zblive/index.html");
		}
		
		
		
		public function onShow(){
			$id=get('id','i');
			$zblive=M("mod_zblive")->selectRow("id=".$id);
			if($zblive["bstatus"]!=2){
				$this->goAll("当前直播不存在",1);
			}
			$mp4url=$this->getToken("rtmp://".ZBPATH."/zblive".$id."?");
			if($zblive['zbstatus']==0){
				$zblive['zbstatus_name']="即将直播";
			}elseif($zblive['zbstatus']==1){
				$zblive['zbstatus_name']="正在直播";
			}else{
				$zblive['zbstatus_name']="直播已结束";
				$mp4url=$zblive['mp4url'];
			} 
			$zblive['imgurl']=images_site($zblive['imgurl']); 
			$this->smarty->goAssign(array(
				"zblive"=>$zblive,
				 
				"mp4url"=>$mp4url,
				"m3u8url"=>$this->getToken("https://".ZBPATH."/zblive".$id.".m3u8?"),
				"flvurl"=>$this->getToken("https://".ZBPATH."/zblive".$id.".flv?"),
				"wsclient"=>base64_encode($_SERVER['HTTP_HOST'].OC_SSID),
			));
			if($zblive["tablename"]=="taoke"){
				$this->smarty->display("zblive/show_taoke.html");
			}else{
				$this->smarty->display("zblive/show.html");
			} 
			
		}
		public function onGetRtmp(){
			$id=get("id","i");
			$zblive=M("mod_zblive")->selectRow("id=".$id);
			if($zblive["zbstatus"]!=1){
				echo json_encode(array(
					"error"=>1,
					"message"=>"还不能开始直播"
				));
				exit;
			}
			$config=M("mod_zblive_config")->selectRow("1=1");
			$token=$this->getToken($config['zbrtmp']."zblive".$id);
			$token=str_replace($config['zbrtmp'],"",$token);
			M("mod_zblive")->update(array(
				"auth_key"=>$token
			),"id=".$zblive['id']);
			$tuiurl=$config['zbrtmp'].$token;
			echo json_encode(array(
				"error"=>0,
				"message"=>"success",
				"data"=>array(
					"rtmp"=>$tuiurl
				)
			));
		}
		public function getToken($url){
			$a=parse_url($url); 
			$path=$a['path'];
			$mkey=ZBKEY;
			$time=time()+3600*24;
			$hash=md5($path."-".$time."-0-0-".$mkey);
			if(strpos($url,"?")>0){
				$url=$url."&auth_key=".$time."-0-0-".$hash;
			}else{
				$url=$url."?auth_key=".$time."-0-0-".$hash;
			}
			
			return $url;
			 
		}	
	 	
		public function onCallBackTui(){
			$app=get('app');
			$appname=get('appname');
			$ID=get('ID');
			$key=$app.$appname.$id;
			$action=get('action');
			 
			skyLog("zbliveTui",json_encode($_GET));
		}
		
		public function onCallBackRecord(){
			skyLog("zbliveRecord",json_encode($_GET));
			
		}
		
		public function onRecordList(){
			/**
			 * https://live.aliyuncs.com/?Action=DescribeLiveStreamRecordIndexFiles&DomainName=live.aliyunlive.com&AppName=aliyuntest&StreamName=xxx&StartTime=xxx&EndTime=xxx&<公共请求参数>
			 */
			$url="Action=DescribeLiveStreamRecordIndexFiles";
			$url.="&DomainName=zblive.fd175.com";
			$url.="&AppName=fd175";
			$url.="&StreamName=zblive13";
			$startTime=$this->gmt_iso8601(strtotime("2018-02-01 14:23:40"));
			$endTime=$this->gmt_iso8601(strtotime("2018-02-02 14:25:40"));
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
			$url="http://live.aliyuncs.com/?".$url;
			 
			$c=curl_get_contents($url);
			$res=json_decode($c,true);
			print_r($res);
			
			
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