<?php
	class zblive_configControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$data=M("mod_zblive_config")->selectRow();
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("zblive_config/index.html");
		}
		
		public function onSave(){
			$data=M("mod_zblive_config")->postData();
			$row=M("mod_zblive_config")->selectRow();
			if($row){
				M("mod_zblive_config")->update($data,"id=".$row['id']);
			}else{
				M("mod_zblive_config")->insert($data);
			}
			$this->goAll("保存成功");
		}
		
	}
?>