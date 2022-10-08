<?php
return [
	['GET','/index',[indexControl::class,'onDefault']],
	['GET','/test',[test::class,'index']],
	['GET','/article/show',[articleControl::class,'onShow']],
	['GET','/forum/index',[app\forum\index\forum::class,'index']],
	['GET','/forum/show',[app\forum\index\forum::class,'show']]
];