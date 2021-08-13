<?php
if(empty($arr)){
	$a=[
		"link"=>"?a=1",
		"img"=>"uicompent/img/md-abc-a/a.jpg"
	];
	$b=[
		"link"=>"?a=2",
		"img"=>"uicompent/img/md-abc-a/b.jpg"
	];
	$c=[
		"link"=>"?a=3",
		"img"=>"uicompent/img/md-abc-a/c.jpg"
	];
	$arr=[$a,$b,$c];
}
?>
<style>
	.md-abc{
		display: flex;
		flex-direction: row;
		margin-bottom: 5px;
		background-color: #fff;
	}
	.md-abc div{
		margin: 0;
		line-height: 0;
	}
	.md-abc-a{
		width: 50%;
	}
	.md-abc-bc{
		width: 50%;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.md-abc-img{
		width: 100%;
	}
	 
	
</style>
<div uiname="md-abc-a" api="ad" class="md-abc animated js-com-set">
	<div gourl="<?=$arr[0]['link']?>" class="md-abc-a"><img class="md-abc-img" src="<?=$arr[0]['img']?>" /></div>
	<div class="md-abc-bc md-abc-r">
		<div gourl="<?=$arr[1]['link']?>" class="md-b"><img class="md-abc-img"  src="<?=$arr[1]['img']?>" /></div>
		<div gourl="<?=$arr[2]['link']?>" class="md-c"><img class="md-abc-img"  src="<?=$arr[2]['img']?>" /></div>
	</div>
	
</div>