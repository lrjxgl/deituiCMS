<?php
class weixin_commandModel extends model{
	 
	public $type_list;
	public $fun_list;
	public function __construct (){
		parent::__construct ();
		 
		$this->table="weixin_command";
		$this->type_list=array(
			1=>"普通",
			2=>"用户注册",
			3=>"用户登录",
			4=>"用户绑定",
			5=>"加入购物车",
			6=>"下订单",
			7=>"默认帮助",
			8=>"欢迎词",			
		);
		
		$this->fun_list=array(
			"article"=>"文章",
			//"zufang"=>"房屋出租",
			//"hunsha"=>"婚纱摄影",
			//"meifa"=>"发型设计",
			//"jiaju"=>"家居装饰",
			"product"=>"产品",
			"picture"=>"图片欣赏",
			"caipu"=>"菜谱",
			//"jiemeng"=>"解梦",
			//"xitie"=>"喜帖",
		);
	}
}

?>