<?php
/***阿里云直传**/
function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
}	
class ossuploadControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onInit(){
		if(empty($_SESSION['ssuser']) &&   empty($_SESSION['ssupload']) && empty($_SESSION['ssadmin']) && empty($_SESSION['ssshopadmin'])){
			if(get('a')=='auth'){
				$this->goall("die access",1);
			}
			
		}
	}
	
	public function onDefault(){
		
	}
	
	public function onAuth(){
		/***config****/
		$config=M("open_alioss")->selectRow("status=1");
		$id= $config['appid'];
		$key= $config['appkey'];
		$url="https://".$config['bucket'].".".$config['endpoint'];
		$bucket=$config['bucket'];
		 
		$callbackUrl = HTTP_HOST."index.php/ossupload/callback";
		/**end config**/
		$dir=isset($_GET['dir'])?str_replace("/","",$_GET['dir'])."/":"video/";
		$options = array();
		$options['expiration'] = gmt_iso8601(time()+300); /// 授权过期时间
		$conditions = array();
		array_push($conditions, array('bucket'=>$bucket));
		$content_length_range = array();
		array_push($content_length_range, 'content-length-range');
		array_push($content_length_range, 0);
		array_push($content_length_range, 1048575000);
		array_push($conditions, $content_length_range);
		$options['conditions'] = $conditions;
		$policy = base64_encode(stripslashes(json_encode($options)));
		$sign = base64_encode(hash_hmac('sha1',$policy,$key, true));
		
		
		$callback_param = array('callbackUrl'=>$callbackUrl, 
		             'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}', 
		             'callbackBodyType'=>"application/x-www-form-urlencoded");
		$callback_string = json_encode($callback_param);
		
		$callbackbody = base64_encode($callback_string);
		$json=array(
			"accessid"=>$id,
			"policy"=>$policy,
			"sign"=>$sign,
			"key"=>$dir.date("Y/m/d/").time().session_id(),
			"callback"=>$callbackbody,
			"url"=>$url
		);
		echo json_encode($json);
	}
	
	public function onCallback(){
		/***config****/
		$config=M("open_alioss")->selectRow("status=1");
		$id= $config['appid'];
		$key= $config['appkey'];
		$url="https://".$config['bucket'].".".$config['endpoint'];
		$bucket=$config['bucket'];
		$callbackUrl = HTTP_HOST."/index.php/ossupload/callback";
		/**end config**/
		// 1.获取OSS的签名header和公钥url header
		$authorizationBase64 = "";
		$pubKeyUrlBase64 = "";
		/*
		 * 注意：如果要使用HTTP_AUTHORIZATION头，你需要先在apache或者nginx中设置rewrite，以apache为例，修改
		 * 配置文件/etc/httpd/conf/httpd.conf(以你的apache安装路径为准)，在DirectoryIndex index.php这行下面增加以下两行
		    RewriteEngine On
		    RewriteRule .* - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization},last]
		 * */
		if (isset($_SERVER['HTTP_AUTHORIZATION']))
		{
		    $authorizationBase64 = $_SERVER['HTTP_AUTHORIZATION'];
		}
		if (isset($_SERVER['HTTP_X_OSS_PUB_KEY_URL']))
		{
		    $pubKeyUrlBase64 = $_SERVER['HTTP_X_OSS_PUB_KEY_URL'];
		}
		
		if ($authorizationBase64 == '' || $pubKeyUrlBase64 == '')
		{
		    header("http/1.1 403 Forbidden");
		    exit();
		}
		
		// 2.获取OSS的签名
		$authorization = base64_decode($authorizationBase64);
		
		// 3.获取公钥
		$pubKeyUrl = base64_decode($pubKeyUrlBase64);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $pubKeyUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$pubKey = curl_exec($ch);
		if ($pubKey == "")
		{
		    //header("http/1.1 403 Forbidden");
		    exit();
		}
		
		// 4.获取回调body
		$body = file_get_contents('php://input');
		
		// 5.拼接待签名字符串
		$authStr = '';
		$path = $_SERVER['REQUEST_URI'];
		$pos = strpos($path, '?');
		if ($pos === false)
		{
		    $authStr = urldecode($path)."\n".$body;
		}
		else
		{
		    $authStr = urldecode(substr($path, 0, $pos)).substr($path, $pos, strlen($path) - $pos)."\n".$body;
		}
		
		// 6.验证签名
		$ok = openssl_verify($authStr, $authorization, $pubKey, OPENSSL_ALGO_MD5);
		if ($ok == 1)
		{
		    header("Content-Type: application/json");
		    parse_str($body,$p);
			
		    $data = array("Status"=>"Ok","filename"=>$p['filename'],"truename"=>$url."/".$p['filename'],"size"=>$p['size']);
		    M("attach")->add(array(
				"file_url"=>$p['filename'],
				"file_size"=>$p['size']
			));
			echo json_encode($data);
		}
		else
		{
			$data = array("Status"=>"fail");
		    echo json_encode($data);
		    //header("http/1.1 403 Forbidden");
		    exit();
		}
	}
	
}
?>