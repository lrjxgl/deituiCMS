<?php
if(empty($mdPubuList) && !empty($diyData)){
	$mdPubuList=$diyData;
}
if(!empty($mdPubuList)):
$list1=[];
$list2=[];
$len=count($mdPubuList);
for($i=0;$i<$len;$i++){
	if($i%2==0){
		$list1[]=$mdPubuList[$i];
	}else{
		$list2[]=$mdPubuList[$i];
	}
}
?>
<div class="flex">
	<div class="flex-1 mgr-5">
		<?php 
			foreach($list1 as $item):
		?>
			<a href="/module.php?m=b2c_product&a=show&id=<?=$item["id"]?>" class="mgb-10 flex-col bg-white">
				<img src="<?=$item["imgurl"]?>" class="wmax" />
				<div class="pd-10">
					<div class="mgb-5"><?=$item["title"]?></div>
					<div class="flex flex-ai-center">
						<div class="mgr-5 cl-money">￥</div>
						<div class="cl-money"><?=$item["price"]?></div>
						<div class="flex-1"></div>
						<div class="cl3 f12">市场价</div>
						<div class="market-price"><?=$item["market_price"]?></div>
					</div>
				</div>
				
			</a>
		<?php
			endforeach;
		?>
	</div>
	<div class="flex-1">
		<?php
			foreach($list2 as $item):
		?>
			<a href="/module.php?m=b2c_product&a=show&id=<?=$item["id"]?>" class="mgb-10 flex-col bg-white">
				<img src="<?=$item["imgurl"]?>" class="wmax" />
				<div class="pd-10">
					<div class="mgb-5"><?=$item["title"]?></div>
					<div class="flex flex-ai-center">
						<div class="mgr-5 cl-money">￥</div>
						<div class="cl-money"><?=$item["price"]?></div>
						<div class="flex-1"></div>
						<div class="cl3 f12">市场价</div>
						<div class="market-price"><?=$item["market_price"]?></div>
					</div>
				</div>
				
			</a>
		<?php
			endforeach;
		?>
		
	</div>
</div>
<?php
endif;
?>