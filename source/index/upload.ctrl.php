<?php
class uploadControl extends skymvc{
	public $sitedir;
	private $oss=NULL;
	public $w1="160";
	public $w2="440";
	public $w3="750";
	public function __construct(){
		parent::__construct();	
	}
	 
	public function onInit(){
		//检验table是否合法
		$tablename=get_post("tablename","h");
		if(!empty($tablename)){
			if(preg_match("/[^\w]+/",$tablename)){
				exit("出错了");
			}
		}
		$this->loadClass("image");
		$this->loadClass("upload");

		$this->upload->uploaddir="attach/".$this->sitedir; 
	 
		if(empty($_SESSION['ssuser']) &&   empty($_SESSION['ssupload']) && empty($_SESSION['ssadmin']) && empty($_SESSION['ssshopadmin'])){
			$this->goall("die access",1);
		}
		session_write_close();
		set_time_limit(300);
		 
		include_once(ROOT_PATH."api/ossapi/ossapi.php");
		 
	}
	
	public function onDefault(){
		
	}
	
	public function upload_oss($files,$delFile=true){
		if(!UPLOAD_OSS) return false;
		if(empty($files)) return false;
		$arr=array("",".100x100.jpg",".small.jpg",".middle.jpg");
		foreach($arr as $a){		
			if(file_exists(ROOT_PATH.$files.$a)){
				$to=str_replace("//","/",$files.$a);
				$from=ROOT_PATH.$files.$a;
				 
				$response = oss_upload_file(array("bucket"=>OSS_BUCKET,"to"=>$to,"from"=>$from));
				 
				if(defined("UPLOAD_DEL") && UPLOAD_DEL && $delFile){
					@unlink($from);
				}
			}
		}
	}
	 
	public function onUpload(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->uploaddir="attach/".$dir; 
		$data=$this->upload->uploadfile("upimg");
		M("attach")->add(array(
			"url"=>$data["filename"]
		));
		$this->upload_oss($data['filename']);
		$data=array("error"=>$data['err'],"name"=>basename($data["filename"]),"imgurl"=>$data['filename'],"trueimgurl"=>IMAGES_SITE($data['filename']),"msg"=>$data['err']);
		$this->upload_oss($data['imgurl']);
		echo json_encode($data);
	}
	
	public function onUploadFile(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->upimg=false;
		$this->upload->allowtype=$this->upload->sysallowtype;
		$this->upload->uploaddir="attach/".$dir; 
		$data=$this->upload->uploadfile("upimg");
		$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"trueimgurl"=>IMAGES_SITE($data['filename']),"msg"=>$data['err']);
		
		$this->upload_oss($data['imgurl']);
		
		echo json_encode($data);
	}
	public function onUploadCert(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->upimg=false;
		$this->upload->allowtype=$this->upload->sysallowtype=array(
			"pem","p12","txt","crt"
		);
		$this->upload->uploaddir="attach/".$dir; 
		$data=$this->upload->uploadfile("upimg");
		M("attach")->add(array(
			"url"=>$data["filename"]
		));
		$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"trueimgurl"=>IMAGES_SITE($data['filename']),"msg"=>$data['err']);
		
		$this->upload_oss($data['imgurl'],false);
		
		echo json_encode($data);
	}
	
	
	public function onswfUpload(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->upimg=false;
		$this->upload->allowtype=$this->upload->sysallowtype;
		$this->upload->uploaddir="attach/".$dir; 
		$data=$this->upload->uploadfile("Filedata");
		M("attach")->add(array(
			"url"=>$data["filename"]
		));
		$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"trueimgurl"=>IMAGES_SITE($data['filename']),"msg"=>$data['err']);
		$this->upload_oss($data['imgurl']);
		echo json_encode($data);
	}
	
	public function onUploadMp4(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->upimg=false;
		$this->upload->allowtype=array("mp4","mp3","mov","aac","webm");
		$this->upload->uploaddir="attach/".$dir; 
		$data=$this->upload->uploadfile("upimg");
		M("attach")->add(array(
			"url"=>$data["filename"]
		));
		$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"trueimgurl"=>IMAGES_SITE($data['filename']),"msg"=>$data['err']);
		$this->upload_oss($data['imgurl']);
		echo json_encode($data);		 
	}
	
	public function onuploadzip(){
			$dir=isset($_GET['dir'])?get('dir','h')."/":"";
			$this->upload->upimg=false;
			$this->upload->allowtype=$this->upload->sysallowtype;
			$this->upload->iddir=get('id','i');
			$this->upload->uploaddir="attach/".$dir; 
			$data=$this->upload->uploadfile("upzip");
			M("attach")->add(array(
				"url"=>$data["filename"]
			));
			$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"msg"=>$data['err']);
			$this->upload_oss($data['imgurl']);
			echo json_encode($data);
	}
	
	public function onuploadtao(){
			$dir=isset($_GET['dir'])?get('dir','h')."/":"";
			$this->upload->iddir=get('id','i');
			$this->upload->uploaddir="attach/".$dir; 
			$data=$this->upload->uploadfile("upimg");
			M("attach")->add(array(
				"url"=>$data["filename"]
			));
			if(empty($data['err'])){
				$this->loadClass("image",false,false);
				$img=new image();
				$imgurl=$data['filename'];
				if(WATER_ON){
					$this->loadControl("imageapi","source/index");
					 
					$this->imageapiControl->addwater($imgurl);
				}
				$img->makethumb($imgurl.".100x100.jpg",$imgurl,$this->w1,$this->w1,1);
				$img->makethumb($imgurl.".small.jpg",$imgurl,$this->w2);
				$img->makethumb($imgurl.".middle.jpg",$imgurl,$this->w3);
				$this->upload_oss($data['filename']);
			}
			$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"trueimgurl"=>IMAGES_SITE($data['filename']),"msg"=>$data['err']);
			echo json_encode($data);
	}
	
	public function onBase64_user_head(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$dir=str_replace(".","_",$dir);
		if(get('id','i')){
			$dir="attach/".$dir.$this->dirId(get('id','i'));
		}else{
			$dir="attach/".$dir.date("Y/m/d/").$this->dirId(get('id','i'));
		}
		umkdir($dir);
		$maxid=M("maxid")->insert(array("t"=>0));
		$file=$dir.$maxid.".jpg";
 		$content=substr(strstr( $_POST['content'] ,','),1);
		$content=base64_decode( $content);
		$im=@imagecreatefromstring($content);
		if(!$im){
			exit("图片不支持");
		}
		$w=imagesx($im);
		$h=imagesy($im);
		
		imagejpeg($im,$file);
		$this->loadClass("image",false,false);
		$img=new image();
		$imgurl=$file;
		M("attach")->add(array(
			"url"=>$imgurl
		));
		$img->makethumb($imgurl.".100x100.jpg",$imgurl,$this->w1,$this->w1,1);
		$img->makethumb($imgurl.".small.jpg",$imgurl,$this->w2);
		$img->makethumb($imgurl.".middle.jpg",$imgurl,$this->w3);
		$this->upload_oss($imgurl);
		$data=array("error"=>0,"imgurl"=>$file,"trueimgurl"=>images_site($file),"file"=>$file,"msg"=>"");
		echo json_encode($data);
	}
	
	public function onBase64(){
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$dir=str_replace(".","_",$dir);
		if(get('id','i')){
			$dir="attach/".$dir.$this->dirId(get('id','i'));
		}else{
			$dir="attach/".$dir.date("Y/m/d/").$this->dirId(get('id','i'));
		}
		umkdir($dir);
		$maxid=M("maxid")->insert(array("t"=>0));
		$file=$dir.$maxid.".jpg";
 
 		$content=substr(strstr( $_POST['content'] ,','),1);
		$content=base64_decode( $content);
		$im=@imagecreatefromstring($content);
		if(!$im){
			exit("图片不支持");
		}
		$w=imagesx($im);
		$h=imagesy($im);
		
		imagejpeg($im,$file);
		M("attach")->add(array(
			"url"=>$file
		));
		$this->loadClass("image",false,false);
		$img=new image();
		$imgurl=$file;
		$img->makethumb($imgurl.".100x100.jpg",$imgurl,$this->w1,$this->w1,1);
		$img->makethumb($imgurl.".small.jpg",$imgurl,$this->w2);
		$img->makethumb($imgurl.".middle.jpg",$imgurl,$this->w3);
		$this->upload_oss($imgurl);
		$data=array("error"=>0,"trueimgurl"=>images_site($file),"imgurl"=>$file,"file"=>$file,"msg"=>"");
		//直接插入imgs表
		$inimgs=get_post('inimgs','h');
		$inattach=get_post('inattach','h');
		if($inimgs){
			$object_id=get_post('object_id','i');
			$tablename=get_post('tablename','h');
			$data['imgid']=M("imgs")->insert(array(
				"object_id"=>$object_id,
				"tablename"=>$tablename,
				"imgurl"=>$imgurl,
				"userid"=>M("login")->userid,
			));		
		}elseif($inattach){
			$attach_id=M("attach")->insert(array(
				"imgurl"=>$data['imgurl'],
				"trueimgurl"=>$data['trueimgurl']
			));
			$data['attach_id']=$attach_id;
		}
		echo json_encode($data);
	}
	
 
	
		/*传广告图*/
	public function onuploadAd(){
			$dir=isset($_GET['dir'])?get('dir','h')."/":"";
			$this->upload->iddir=get('id','i');
			$this->upload->uploaddir="attach/".$dir; 
			$data=$this->upload->uploadfile("upimg");
			M("attach")->add(array(
				"url"=>$data["filename"]
			));
			if(empty($data['err'])){
				$this->loadClass("image",false,false);
				$img=new image();
				$imgurl=$data['filename'];
				$img->makethumb($imgurl.".100x100.jpg",$imgurl,"100","100",1);
				//$img->makethumb($imgurl,$imgurl,get_post('width'),get_post('height'),2);
				$this->upload_oss($data['filename']);
			}
			$data=array("error"=>$data['err'],"imgurl"=>$data['filename'],"msg"=>$data['err']);
			echo json_encode($data);
	}
	
	public function onImg(){
		$_GET['ajax']=1;
		
		$this->loadClass("upload");
		$dir=isset($_GET['dir'])?get('dir','h')."/":"";
		$this->upload->iddir=get('id','i');
		$this->upload->uploaddir="attach/".$dir; 
		$this->upload->upimg=true;
		$data=$this->upload->uploadfile("upimg");
		M("attach")->add(array(
			"url"=>$data["filename"]
		));
		if($data['err']==''){
			$this->loadClass("image",false,false);
			$img=new image();
			$data['imgurl']=$data['filename'];
			$data['trueimgurl']=$data['truefilename']=IMAGES_SITE($data['filename']);
			$cfs=$this->config_item("thumb");
			$imgurl=$data['imgurl'];
			$img->makethumb($imgurl.".100x100.jpg",$imgurl,$this->w1,$this->w1,1);
			$img->makethumb($imgurl.".small.jpg",$imgurl,$this->w2);
			$img->makethumb($imgurl.".middle.jpg",$imgurl,$this->w3);
			$this->upload_oss($imgurl);
			$this->goAll("success",0,$data);
		}
		$this->goAll($data['err'],1);
		
	} 
	 
	
	/*根据id来存储*/
	public function dirId($id){
		if(!$id) return false;
		return (($id/1000000)%100)."/".(($id/10000)%100)."/".(($id/100)%100)."/".($id%100)."/".$id."/";
	}
	
}
?>