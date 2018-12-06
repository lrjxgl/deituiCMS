<?php
class districtControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$dist=M("district")->select(array(
			"where"=>"upid=0",
			"fields"=>"id as value,name as text"
		));
		foreach($dist as $k=>$v){
			$child=M("district")->select(array(
				"where"=>"upid=".$v['value'],
				"fields"=>"id as value,name as text"
			));
			if($child){
				foreach($child as $ck=>$vk){
					$c2=M("district")->select(array(
						"where"=>"upid=".$vk['value'],
						"fields"=>"id as value,name as text"
					));
					$vk['children']=$c2;
					$child[$ck]=$vk;
				}
			}
			$v['children']=$child;
			$dist[$k]=$v;
		}
		$str=" var district=".json_encode($dist);
	 
		file_put_contents("static/district.js",$str);
		echo "生成成功";
	}
	
	public function onIosSelect(){
		$provinces=M("district")->select(array(
			"where"=>"upid=0 AND level=1 ",
			"fields"=>"id,name as value,upid as parentId"
		));
		$str.="\r\n var iosProvinces=".json_encode($provinces);
		$citys=M("district")->select(array(
			"where"=>"level=2 ",
			"fields"=>"id,name as value,upid as parentId"
		)); 
		$str.="\r\n var iosCitys=".json_encode($citys);
		$towns=M("district")->select(array(
			"where"=>"level=3",
			"fields"=>"id,name as value,upid as parentId"
		)); 
		$str.="\r\n var iosCountys=".json_encode($towns);
		file_put_contents("static/areaData.js",$str);
		echo "生成成功";
	}
	
}
?>