<?php
if(empty($a)){
	$a=[
		"link"=>"?a=1",
		"img"=>"http://img.deitui.com/?w=120&h=60&bgcolor=a50"
	];
	$b=[
		"link"=>"?a=2",
		"img"=>"http://img.deitui.com/?w=60&h=60&bgcolor=e50"
	];
	$c=[
		"link"=>"?a=3",
		"img"=>"http://img.deitui.com/?w=60&h=60&bgcolor=350"
	];
}
?>
<style>
	.md-tb{
		display: flex;
		flex-direction: column;
	}
	.md-tb-bc{
		display: flex;
		flex-direction: row;
	}
	.md-tb-img{
		width: 100%;
	}
	.md-tb-b,.md-tb-c{
		width: 50%;
	}
</style>
<div class="md-tb">
	
	<div class="md-tb-bc  md-tb-t">
		<div class="md-tb-b"><a href="<?=$b['link']?>"><img class="md-tb-img"  src="<?=$b['img']?>" /></a></div>
		<div class="md-tb-c"><a href="<?=$c['link']?>"><img class="md-tb-img"  src="<?=$c['img']?>" /></a></div>
	</div>
	<div class="md-tb-a"><a href="<?=$a['link']?>"><img class="md-tb-img" src="<?=$a['img']?>" /></a></div>
</div>