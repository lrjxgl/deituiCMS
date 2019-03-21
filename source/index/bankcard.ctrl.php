<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class bankcardControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		public function onInit(){
			M("login")->checkLogin();
		}
		public function onDefault(){
			$userid=M("login")->userid;
			$where="status in(0,1,2) AND userid=".$userid;
			$url="/index.php?m=bankcard&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("bankcard")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("bankcard/index.html");
		}
		
		public function onAdd(){

			$bankList=M("bankcard")->bankList();
			$userid=M("login")->userid;
			$user=M("user")->selectRow(array(
				"where"=>" userid=".$userid,
				"fields"=>"userid,telephone"
			));
			if(empty($user["telephone"])){
				$this->goAll("请先绑定手机号码",1,0,"/index.php?m=user&a=BindMobile");
			}
			$this->smarty->goassign(array(
				"data"=>$data,
				"bankList"=>$bankList,
				"user"=>$user
			));
			$this->smarty->display("bankcard/add.html");
		}
		
		public function onsendsms(){
			$userid=M("login")->userid;
			$user=M("user")->selectRow(array(
				"where"=>" userid=".$userid,
				"fields"=>"userid,telephone"
			));
			$telephone=$user["telephone"];
			$t=cache()->get("bankcardAdd".$telephone);
			if($t){
				$this->goall("请过".(60-(time()-$t))."秒再发送",1);
			}
			$yzm=rand(111111,999999);
			 
			$content="【".SMS_QIANMING."】你正在绑定银行卡，验证码：".$yzm."，请您5分钟内完成验证";
			$content=array(
				"code"=>$yzm,
				"tpl"=>"code",
				"content"=>$content
			);
			$res=M("sms")->sendSms($telephone,$content);
			$key="bankcardAdd_sms".$telephone.$yzm;
			
			if($res){
				cache()->set($key,1,300);
				cache()->set("bankcardAdd".$telephone,time(),60);
				$this->goAll("短信已发送，请在5分钟内验证注册");
			}else{
				$this->goAll("短信发送失败",1);
			}
		}
		
		public function onSave(){
			$yzm=get_post('yzm','h');
			$userid=M("login")->userid;
			$user=M("user")->selectRow(array(
				"where"=>" userid=".$userid,
				"fields"=>"userid,telephone"
			));
			$telephone=$user["telephone"];
			$key="bankcardAdd_sms".$telephone.$yzm;
			
			if(cache()->get($key)){
				$data=M("bankcard")->postData();
				$chk=array("yhk_name","yhk_haoma","yhk_huming","yhk_address");
				foreach($chk as $k){
					if(empty($data[$k])){
						$this->goAll("请完善银行资料",1);
					}
				}
				$data["userid"]=$userid;
				M("bankcard")->insert($data);
				$this->goAll("银行卡添加成功");
			}else{
				$this->goAll("短信验证码认证失败",1);
			}
			 
			
			 
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("bankcard")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("bankcard")->update(array("status"=>11),"id=$id");
			$this->goall("删除成功",0);
		}
		
		
	}

?>