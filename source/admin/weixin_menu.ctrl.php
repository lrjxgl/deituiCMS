<?php
class weixin_menuControl extends skymvc{
	public $wx;
	public function __construct(){
			parent::__construct();			
		}
		
		public function onInit(){
			$wid=get_post('wid','i');
			$wid=intval($_SESSION['ssweixinid']);
			$this->wx=$weixin=M("weixin")->selectRow("id=".$wid);
			
			if(empty($weixin)){
				$this->goall("请选择微信",1);
			}
			$this->smarty->assign("weixin",$weixin);
		}
	
	public function onDefault(){
		$where=" 1=1  ";
		if($this->weixin){
			$where.=" AND wid=".$this->wx['id']." ";
		}
		$op=array(
			"where"=>$where,
			"order"=>" pid ASC,orderindex ASC"
		);
		$data=M("weixin_menu")->select($op);
		foreach($data  as $k=>$v){
			if($v['pid']==0){
				$ndata[$v['id']]=$v;
			}else{
				$ndata[$v['pid']]['child'][]=$v;
			}
		}
		 
		$this->smarty->assign(array(
			"data"=>$ndata,
			"w_type_list"=>M("weixin_menu")->w_type_list()
		));
		$this->smarty->display("weixin_menu/index.html");
	}
	
	public function onAdd(){
		$id=get_post("id","i");
		$data=M("weixin_menu")->selectRow("id=".$id);
		$op=array(
			"where"=>"  wid=".$this->wx['id']." AND pid=0 ",
			"order"=>" pid ASC,orderindex ASC"
		);
		$pid_list=M("weixin_menu")->id_title($op);
		$this->smarty->assign(array(
			"data"=>$data,
			"pid_list"=>$pid_list,
			"w_type_list"=>M("weixin_menu")->w_type_list()
		));
		$this->smarty->display("weixin_menu/add.html");
	}
	
	public function onSave(){
		$id=get_post("id","i");
		$data["wid"]=$this->wx['id'];
		$data["pid"]=get_post("pid","i");
		$data["orderindex"]=get_post("orderindex","i");
		$data["title"]=get_post("title","h");
		$data['w_type']=get_post('w_type','h');
		$data['w_key']=post('w_key','h');
		$data['w_url']=post('w_url','x');
		$data['sc_id']=post('sc_id','i');
		$data['content']=post("content","x");
		if($id){
			M("weixin_menu")->update($data,array('id'=>$id));
		}else{
			M("weixin_menu")->insert($data);
		}
		$this->goall("保存成功");
	}
	
	public function onOrder(){
		
	}
	//生成菜单
	public function onCreateMenu(){
		/*$c=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->wx['appid']."&secret=".$this->wx['appkey']."");
		 
		//$data=json_decode($c,true);
		*/
		$data=get_weixin_access_token();
		$token=$data['access_token'];
		$op=array(
			"where"=>"  wid=".$this->wx['id']." ",
			"order"=>" pid ASC,orderindex ASC"
		);
		$data=M("weixin_menu")->select($op);
		if($data){
			foreach($data  as $k=>$v){
				if($v['pid']==0){
					$ndata[$v['id']]=array("type"=>$v['w_type'],"name"=>$v['title'],"key"=>$v['w_key'],"url"=>$v['w_url']);
				}else{
					$ndata[$v['pid']]['sub_button'][]=array("type"=>$v['w_type'],"name"=>$v['title'],"key"=>$v['w_key'],"url"=>$v['w_url']);
				}
			}
		}
		$menu=array();
		if($ndata){
			foreach($ndata as $v){
				$menu[]=$v;
			}
		}
		$menu=zh_json_encode(array("button"=>$menu));
		 
		$res=curl_post("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token,$menu);
		//{"errcode":0,"errmsg":"ok"}
		echo $res;
	}
	
	public function onDeleteMenu(){
		$c=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->wx['appid']."&secret=".$this->wx['appkey']."");
		 
		$data=json_decode($c,true);
		$token=$data['access_token'];
		$res=file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$token);
		//{"errcode":0,"errmsg":"ok"}
		echo $res;
	}
	
	public function onDelete(){
		$id=get_post('id',"i");
		M("weixin_menu")->delete("id={$id}");
		exit(json_encode(array("error"=>0,"message"=>"删除成功")));
	}
	
}
?>