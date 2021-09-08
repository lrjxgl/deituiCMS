<?php
class pushTpl{
 
	public static function wxList($key=""){
		$option=array(
			//新订单
			"neworder"=>"QP8FgA400IFGM2uPlf7UM6oFg4pLVLFnXVKmQ1CmtAM",
			//订单更新
			"updateorder"=>"QP8FgA400IFGM2uPlf7UM6oFg4pLVLFnXVKmQ1CmtAM",
			//新用户
			"newuser"=>"XKpjqwevkoRZOskCs8PMb0HlGG3IlNN9G6Lx6QR-zKQ",
			//留言评论提醒
			"comment"=>"0AFm_oQiQUK1SoZrSNiXzJKkt_9y5th2k4_KokiFCWI"
		);
		if(!empty($key)){
			return $option[$key];
		}else{
			return $option;
		}
		
	}
	
	public static function wxAppList($key=""){
		$option=array(
			//新订单
			"neworder"=>"QP8FgA400IFGM2uPlf7UM6oFg4pLVLFnXVKmQ1CmtAM",
			//订单更新
			"updateorder"=>"QP8FgA400IFGM2uPlf7UM6oFg4pLVLFnXVKmQ1CmtAM",
			//新用户
			"newuser"=>"XKpjqwevkoRZOskCs8PMb0HlGG3IlNN9G6Lx6QR-zKQ",
			//留言评论提醒
			"comment"=>"0AFm_oQiQUK1SoZrSNiXzJKkt_9y5th2k4_KokiFCWI"
		);
		if(!empty($key)){
			return $option[$key];
		}else{
			return $option;
		}
		
	}
}
?>