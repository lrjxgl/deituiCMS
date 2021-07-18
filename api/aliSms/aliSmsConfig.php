<?php
class aliSmsConfig{
	public static $accessKeyId="";
	public static $accessKeySecret="";
	public static $SignName="福鼎生活网";
	public static $RegionId="cn-hangzhou";
	public static $tpls=array(
		"reg"=>"SMS_180345739",
		"findpwd"=>"SMS_181868613",
		"shop_apply"=>"SMS_142948931",
		"bank_bind"=>"SMS_142948941",
		"bank_unbind"=>"SMS_142953878",
		"change_telephone_old"=>"SMS_142954539",
		"change_telephone_new"=>"SMS_142954540",
		"shopapply_pass"=>"SMS_142954902",
		"apply_forbid"=>"SMS_142954896",
		"code"=>"SMS_180340966",//通用验证码
	);
}
?>