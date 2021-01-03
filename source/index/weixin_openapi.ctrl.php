<?php
class weixin_openapiControl extends skymvc{
	public $wx;
	public $fromUsername;
	public $toUsername;
	public $MsgId;
	public $MsgType;
	public $reply_id=0;
	public function __construct(){
		parent::__construct();
		$wid=get_post('wid','i');
		if($wid){
			$where=" id=".$wid;
		}else{
			$where="";
		}
		 
		$this->wx=M("weixin")->selectRow(array("where"=>$where,"order"=>"id DESC"));
		define("WID",2);
		define("WXTOKEN",$this->wx['token']);
	}
	
	
	public function onDefault(){
		 
		if($this->wx['status']){
			 
 			$this->responseMsg();
		}else{
			$this->valid();
		}
		
	}
	/*素材显示*/
	function wx_sucai($id){
		$data=M("weixin_sucai")->selectRow("id=".$id." ");
		 
		if($data){
			$child=M("weixin_sucai")->getAll("SELECT * FROM ".table('weixin_sucai')." WHERE pid=".$id." ");
			$content="<item>
		<Title><![CDATA[".$data['title']."]]></Title> 
		<Description><![CDATA[".$data['description']."]]></Description>
		<PicUrl><![CDATA[".IMAGES_SITE.$data['imgurl']."]]></PicUrl>
		<Url><![CDATA[".($data['linkurl']?$data['linkurl']:"http://".$_SERVER['HTTP_HOST']."/index.php?m=weixin_sucai&a=show&id=".$data['id'])."]]></Url>
		</item>";
			if($child){
				foreach($child as $r){
					$content.="<item>
		<Title><![CDATA[".$r['title']."]]></Title> 
		<Description><![CDATA[".$r['description']."]]></Description>
		<PicUrl><![CDATA[".IMAGES_SITE.$r['imgurl']."]]></PicUrl>
		<Url><![CDATA[".($r['linkurl']?$r['linkurl']:"http://".$_SERVER['HTTP_HOST']."/index.php?m=weixin_sucai&a=show&id=".$r['id'])."]]></Url>
		</item>\n";
				}
			}
				$textTpl = "<xml>
						<ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName>
						<FromUserName><![CDATA[".$this->toUsername."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>".(count($child)+1)."</ArticleCount>
						<Articles>".$content."</Articles>				 
					</xml>";
			echo $textTpl;
			exit;		
		}else{
			wx_error();
		}
	}
	
	
	/*图文显示*/
	
	function wx_tuwen($data){
		if(empty($data) or !is_array($data)){
			if(empty($data)){
				return false;
				$data="无法回复您的问题";
			}
			$textTpl = "<xml>
								<ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName>
								<FromUserName><![CDATA[".$this->toUsername."]]></FromUserName>
								<CreateTime>".time()."</CreateTime>
								<MsgType><![CDATA[text]]></MsgType>
								<Content><![CDATA[".$data."]]></Content> 
								<FuncFlag>0</FuncFlag>
								</xml>"; 
			echo  $textTpl;
			exit;
		}
		$content="";
		foreach($data as $r){
				  $content.="<item>
		<Title><![CDATA[".$r['title']."]]></Title> 
		<Description><![CDATA[".$r['description']."]]></Description>
		<PicUrl><![CDATA[".$r['imgurl']."]]></PicUrl>
		<Url><![CDATA[".$r['url']."]]></Url>
		</item>\n";
				}
	 
		$textTpl = "<xml>
						<ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName>
						<FromUserName><![CDATA[".$this->toUsername."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>".count($data)."</ArticleCount>
						<Articles>".$content."</Articles>				 
					</xml>";
		echo  $textTpl;
		exit;
	}

	
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
	
	public function post(){
		$textTpl="<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName> 
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[%s]]></MsgType>
 <Content><![CDATA[%s]]></Content>
 <MsgId>0</MsgId>
 </xml>";
	}

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = file_get_contents("php://input");
		$this->slog($postStr);
		 
      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $this->fromUsername=$fromUsername = $postObj->FromUserName;
                $this->toUsername=$toUsername = $postObj->ToUserName;
                $keyword=$content = trim($postObj->Content);
				$this->MsgId=$MsgId=$postObj->MsgId;
				$this->MsgType=$MsgType=$postObj->MsgType;
				$picurl=$postObj->PicUrl;
				$MediaId=$postObj->MediaId;
				$ThumbMediaId=$postObj->ThumbMediaId;
				$format=$postObj->Format;
				$location_x=$postObj->Location_X;
				$location_y=$postObj->Location_y;
				$scale=$postObj->Scale;
				$label=$postObj->Label;
				$title=$postObj->Title;
				$descripton=$postObj->Description;
				$url=$postObj->Url;
				$event=$postObj->Event;
				$EventKey=$postObj->EventKey;
				//插入响应数据
				$redata=array(
					"openid"=>$toUsername,
					"msgtype"=>$MsgType,
					"content"=>$content,
					"msgid"=>$MsgId,
					"picurl"=>$picurl,
					"mediaid"=>$MediaId,
					"thumbmediaid"=>$ThumbMediaId,
					"format"=>$format,
					"location_x"=>$location_x,
					"location_y"=>$location_y,
					"scale"=>$scale,
					"label"=>$label,
					"title"=>$title,
					"description"=>$descripton,
					"url"=>$url,
					"createtime"=>time(),
					
					"wid"=>WID,
					"fromusername"=>$fromUsername,
					"tousername"=>$toUsername,
					
				);
				
				$this->reply_id=M("weixin_reply")->insert($redata);
				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>";  
				//处理订阅与取消订阅
				if($MsgType=='event'){
					$user=M("weixin_user")->selectRow(array("where"=>"openid='".$toUsername."' AND wid=".$this->wx['id']));
					if($event=='subscribe'){
						if($user){
							M("weixin_user")->update(array(
								"openid"=>$toUsername,
								"add_time"=>time(),
								"last_time"=>time(),
								"status"=>1,
							),"openid='".$toUsername."' AND wid=".$this->wx['id']);
						}else{
							M("weixin_user")->insert(array(
								"openid"=>$toUsername,
								"dateline"=>time(),
								"add_time"=>time(),
								"last_time"=>time(),
								"status"=>1,
								
								"wid"=>$this->wx['id']
							));
						}
						//回复订阅
						$row=M("weixin_command")->selectRow(array("where"=>" type_id=8 AND wid=".$this->wx['id']));
						if($row['sc_id']){
							$this->wx_sucai($row['sc_id']);
						}elseif($row['content']){
							$this->wx_tuwen($row['content']);
						}else{
							$this->wx_tuwen("感谢您的关注！");
						
						}
					}elseif($event=='unsubscribe'){
						if($user){
							M("weixin_user")->update(array(
								"openid"=>$toUsername,
								"del_time"=>time(),
								"last_time"=>time(),
								"status"=>0,
							),"openid='".$toUsername."' AND wid=".$this->wx['id']);
						}else{
							M("weixin_user")->insert(array(
								"openid"=>$toUsername,
								"dateline"=>time(),
								"del_time"=>time(),
								"last_time"=>time(),
								"status"=>0,
								
								"wid"=>$this->wx['id']
							));
						}
					}elseif($event=='CLICK'){
						$this->ClickReply($EventKey,$fromUsername, $toUsername);
						
					}elseif($event=='SCAN'){//二维码扫描
						$ticket=$postObj->Ticket;
						$this->qrsceneReply($EventKey,$ticket,$fromUsername,$toUsername);				
					} 
					$row=M("weixin_command")->selectRow(array("where"=>" type_id=8  AND wid=".$this->wx['id']));
					if($row['sc_id']) $this->wx_sucai($row['sc_id']);
					$this->wx_tuwen($row['content']);
					exit;
						
				}elseif($MsgType=='location'){
					$lat=$postObj->lat;
					$lng=$postObj->lng;
					$this->locationReply($lat,$lng,$fromUsername,$toUsername);
				}elseif($MsgType=='voice'){
					$this->voiceReply($MediaId,$fromUsername,$toUsername);
				}elseif($MsgType=='video'){
					$this->videoReply($MsgId,$ThumbMediaId,$fromUsername,$toUsername);
				}elseif($MsgType=='picture'){
					$this->pictureReply($picurl,$MediaId,$fromUsername,$toUsername);
				}
				//End
				
				//处理用户
				$user=M("weixin_user")->selectRow(array("where"=>"openid='".$toUsername."' AND wid=".$this->wx['id']));
				if(empty($user)){
					M("weixin_user")->insert(array(
						"openid"=>$toUsername,
						"dateline"=>time(),
						"last_time"=>time(),
						"reply_num"=>1,
						"wid"=>$this->wx['id'], 
						
					));
				
				}else{
					M("weixin_user")->update(array(
						"last_time"=>time(),
						"reply_num"=>$user['reply_num']+1,
					),"openid='".$toUsername."' AND wid=".$this->wx['id']);
				}
				//插入回复
			 	
                $time = time();
                           
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$arr = $this->getContent($keyword);
					$contentStr=$arr['content'];
					if($arr['error']==0){
						M("weixin_reply")->update(array("status"=>1)," id=".$this->reply_id);
					}
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);
					$resultStr=str_replace("[@content@]",$contentStr,$resultStr);
					$resultStr=str_replace(array("性交","乱伦","性欲望"),"",$resultStr);
                	echo $resultStr;
					exit;
                }else{
					$row=M("weixin_command")->selectRow(array("where"=>" type_id=8 AND wid=".$this->wx['id']));
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);
					$contentStr="<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[".$row['content']."]]></Content>";
					$resultStr=str_replace("[@content@]",$contentStr,$resultStr);
					exit;
                }
				

        }else {
        	echo "";
        	exit;
        }
    }
	/*菜单点击事件*/
	public function clickReply($EventKey,$fromUsername, $toUsername){
		$row=M("weixin_menu")->selectRow("wid=".$this->wx['id']." AND w_key='".addslashes($EventKey)."'");
		if(!$row['sc_id']){
			$this->wx_tuwen($row['content']);
		}else{
			$this->wx_sucai($row['sc_id']);
		}
		
	}
	
	/*图片消息*/
	public function pictureReply($PicUrl,$MediaId,$fromUsername, $toUsername){
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>".time()."</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>"; 
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername);
						$contentStr="<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[这是图片消息".$EventKey."]]></Content>";
		echo $resultStr=str_replace("[@content@]",$contentStr,$resultStr);
		exit;
	}
	/*语音*/
	public function voiceReply($MsgID,$fromUsername, $toUsername){
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>".time()."</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>"; 
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername);
						$contentStr="<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[这是语音消息".$EventKey."]]></Content>";
		echo $resultStr=str_replace("[@content@]",$contentStr,$resultStr);
		exit;
	}
	
	/*视频*/
	public function videoReply($MsgID,$ThumbMediaId,$fromUsername, $toUsername){
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>".time()."</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>"; 
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername);
						$contentStr="<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[这是视频消息".$EventKey."]]></Content>";
		echo $resultStr=str_replace("[@content@]",$contentStr,$resultStr);
		exit;
	}
	
	/*二维码扫描*/
	public function qrsceneReply($EventKey,$Ticket,$fromUsername, $toUsername){
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>".time()."</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>"; 
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername);
						$contentStr="<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[这是二维码扫描事件".$EventKey."]]></Content>";
		echo $resultStr=str_replace("[@content@]",$contentStr,$resultStr);
		exit;
	}
	
	/*地理位置事件*/
	public function locationReply($lat,$lng,$fromUsername, $toUsername){
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>".time()."</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>"; 
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername);
						$contentStr="<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[这是地理位置事件]]></Content>";
		echo $resultStr=str_replace("[@content@]",$contentStr,$resultStr);
		exit;
	}
	
	public function reply($config=array()){
		$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							[@content@]
							<FuncFlag>0</FuncFlag>
							</xml>"; 
	}
	public function getContent($keyword){
		$s=explode(":",$keyword);
		$row=M("weixin_command")->selectRow(array("where"=>" command='".$s[0]."' AND wid=".$this->wx['id']));
		if($row['fun'] && method_exists("weixin_openapiControl",$row['fun'])){
			
			return $this->$row['fun'](str_replace($s[0].":","",$keyword));
			
			exit;
		}
		switch($row['type_id']){
			case 1:
			case 7:
			case 8:
					if($row['sc_id']) $this->wx_sucai($row['sc_id']);
					if($row["command"]=='我要红包'){
						$token=md5(date("Y-m-d"));
						
						$this->wx_tuwen("https://www.fd175.com/module.php?m=hongbao_day&token=".$token);
					}else{
						$this->wx_tuwen($row['content']);
					}
					
				break;
				
			
			
			default:
					$row=M("weixin_command")->selectRow(array("where"=>" isdefault=1 AND wid=".$this->wx['id']));
					if($row['fun'] && method_exists("weixin_openapiControl",$row['fun'])){
						return $this->$row['fun'](str_replace($s[0].":","",$keyword));
						exit;
					}
					if($row['sc_id']) $this->wx_sucai($row['sc_id']);
					$this->wx_tuwen($row['content']);
				break;
		}
		 
		
	}
	
	/*默认回复*/
	public function defaultReply($keyword){
		$row=M("weixin_command")->selectRow(array("where"=>" type_id=7 AND wid=".$this->wx['id']));
		if($row['fun'] && method_exists("weixin_openapiControl",$row['fun'])){
			return $this->$row['fun'](str_replace($s[0].":","",$keyword));
			exit;
		}
		if($row['sc_id']) $this->wx_sucai($row['sc_id']);
		$this->wx_tuwen($row['content']);
	}
	 
	
	 
	public function article($keyword=""){
		 
		$limit=10;
		$row=M("article")->select(array("where"=>" title='".$keyword."' AND is_img=1 ","order"=>"id DESC","limit"=>$limit));
		if(empty($row)){
			$row=M("article")->select(array("where"=>" title like '%".$keyword."%'  AND is_img=1  ","order"=>"id DESC","limit"=>$limit));
		}

		if(!empty($row)){
			$data=array();
			foreach($row as $r){
				$data[]=array(
					"title"=>$r['title'],
					
					"imgurl"=>IMAGES_SITE.$r['imgurl'].".middle.jpg",
					"url"=>"http://".$_SERVER['HTTP_HOST'].R("/index.php?m=show&id=".$r['id'])
				);
			}
			M("weixin_reply")->update(array("status"=>1)," id=".$this->reply_id);
			$this->wx_tuwen($data);
		}else{
			$this->defaultReply($keyword);
		}
	}
	
	 
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = WXTOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		$this->slog($token);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	function slog($cc){
		file_put_contents("log.txt",$cc,FILE_APPEND);
	}
	
}
?>