<?php
define("UEDITOR",ROOT_PATH."/plugin/ueditor/");
class ueditorControl extends skymvc{
	public $sitedir;
	private $oss;
	public function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		
		$this->loadClass("image");
		$this->loadClass("upload");

		$this->upload->uploaddir="attach/".$this->sitedir; 
		if(empty($_SESSION['ssuser']) && empty($_SESSION['ssupload']) && empty($_SESSION['ssadmin']) && empty($_SESSION['ssshopadmin'])) exit('die ACCESS');
		session_write_close();
		set_time_limit(0);
		include_once(ROOT_PATH."api/ossapi/ossapi.php");
	}
	
	public function upload_oss($files){
		if(!UPLOAD_OSS) return false;
		if(empty($files)) return false;
		$arr=array("",".100x100.jpg",".small.jpg",".middle.jpg");
		foreach($arr as $a){		
			if(file_exists(ROOT_PATH.$files.$a)){
				$to=str_replace("//","/",$files.$a);
				$from=ROOT_PATH.$files.$a;
				$response = oss_upload_file(array("bucket"=>OSS_BUCKET,"to"=>$to,"from"=>$from));
				if(defined("UPLOAD_DEL") && UPLOAD_DEL){
					@unlink($from);
				}
			}
		}
	}
	
	/*返回数据结构json
	return array(
            "state" => $this->stateInfo,
            "url" => $this->fullName,
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize
        );*/
	public function onDefault(){
		$action = $_GET['action'];

		switch ($action) {
			case 'config':
			 
				$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(UEDITOR."/php/config.json")), true);
				$result =  json_encode($CONFIG);
				break;
		
			/* 上传图片 */
			case 'uploadimage':
				
			/* 上传涂鸦 */
			case 'uploadscrawl':
				$result =$this->onUeImg();
				break;
			/* 上传视频 */
			case 'uploadvideo':
			/* 上传文件 */
			case 'uploadfile':
				$result =$this->onUeFile();
				break;
			/*抓起远程*/
			case 'catchimage':
				$result=$this->onUeRemote();
				break;
			/* 列出图片 */
			case 'listimage':
				$result = include(UEDITOR."/php/action_list.php");
				break;
			/* 列出文件 */
			case 'listfile':
				$result = include(UEDITOR."/php/action_list.php");
				break;
				 
		
			default:
				$result = json_encode(array(
					'state'=> '请求地址出错'
				));
				break;
		}
		
		/* 输出结果 */
		if (isset($_GET["callback"])) {
			if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
				echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
			} else {
				echo json_encode(array(
					'state'=> 'callback参数不合法'
				));
			}
		} else {
			echo $result;
		}

	}
	
	/**
	*百度ueditor上传图片
	*/
	/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */
	public function onUeImg(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->uploaddir="attach/".$dir.$this->sitedir; 
		
		$data=$this->upload->uploadfile('upfile');
		if($data['err']){
			$re=array(
				"state" => "error", 
				"url" =>"" ,
				"title" => "图片上传失败",
				 "original" => "" , 
				 "type" => "",
				"size" => 0
			);	
		}else{
			
			M("attach")->add(array(
				"url"=>$data["filename"]
			));
			$this->upload_oss($data["filename"]);
			$re=array(
			"state" => "SUCCESS", 
			"url" => UPLOAD_OSS?IMAGES_SITE.$data["filename"]:$data["filename"] ,
			"title" => "图片上传成功",
			 "original" => $data["original"] , 
			 "type" => $data['type'],
			"size" => $data['size']
			);	
		}
		return json_encode($re);
	}
	/*百度上传文件*/
	public function onUeFile(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->uploaddir="attach/".$dir;
		$this->upload->upimg=false;
		$this->upload->allowtype=$this->upload->sysallowtype;
		 
		$data=$this->upload->uploadfile('upfile');
		 
		if($data['err']){
			$re=array(
				"state" => "error", 
				"url" =>"" ,
				"title" => "文件上传失败",
				 "original" => "" , 
				 "type" => "",
				"size" => 0
			);	
		}else{
			M("attach")->add(array(
				"url"=>$data["filename"]
			));
			$this->upload_oss($data["filename"]);
			
			$re=array(
			"state" => "SUCCESS", 
			"url" => UPLOAD_OSS?IMAGES_SITE.$data["filename"]:$data["filename"] ,
			"title" => "文件上传成功",
			 "original" => $data["original"] , 
			 "type" => $data['type'],
			"size" => $data['size']
			);	
		}
		
		return json_encode($re);
	}
	/*远程文件保存本地*/
	public function onUeRemote(){
		error_reporting(E_ERROR|E_WARNING);
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		if(get('id','i')){
			$dir="attach/$dir".$this->dirId(get('id','i'));
			umkdir($dir);
		}else{
			$dir="attach/$dir".date("Y/m/d/");
			umkdir($dir);
		}
		 
		$source=$_POST['source'];
		$list = array();
		if($source){
			foreach ($source as $imgUrl) {
				$content=curl_get_contents($imgUrl);
				$ftype=strtolower(trim(substr(strrchr($imgUrl, '.'), 1)));
				if(!in_array($ftype,array("jpg","png","gif","bmp","webp"))){
					//continue;	
				}
				$im=@imagecreatefromstring($content);
				if(!$im){
					continue;
				}
				$maxid=M("maxid")->get();
				$img=$dir."/".$maxid.".jpg";
				$img=str_replace("//","/",$img);
				file_put_contents(ROOT_PATH.$img,$content);
				$file=ROOT_PATH.$img;
				$im=getimagesize($file);
				M("attach")->add(array(
					"url"=>$img
				));
				$this->upload_oss($img);
				array_push($list, array(
					"state" => 'SUCCESS',
					"url" => images_site($img),
					"size" => 1,
					"title" => " ",
					"original" => $img,
					"source" => htmlspecialchars($imgUrl)
				));
			}
			
		}
		
		echo json_encode(array(
			'state'=> count($list) ? 'SUCCESS':'ERROR',
			'list'=> $list
		));
	}
	
	 
	
	/*根据id来存储*/
	public function dirId($id){
		if(!$id) return false;
		return (($id/1000000)%100)."/".(($id/10000)%100)."/".(($id/100)%100)."/".($id%100)."/".$id."/";
	}
}
?>