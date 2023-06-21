<?php
	
	if(!empty($mdScrollPicList)){
?>
<style>
	.mdScrollPic-item {
		width: 4rem;

		margin-right: 0.8rem;
	}

	.mdScrollPic-item-img {
		width: 100%;
	}
</style>
<div class="row-box mgb-5">

	<div id="mdScrollPic" class="swiper" style="overflow: auto;">
		<div  class="flex swiper-wrapper">
			 
			<?php
				foreach($mdScrollPicList as $item):
			?>
			<div gourl="<?=$item["link1"]?>" class="mdScrollPic-item swiper-slide">
				<img src="<?=$item["imgurl"]?>" class="mdScrollPic-item-img" />
			</div>
			<?php
				endforeach;
			?>

		</div>
	</div>

</div>

<script>
	window.onload=function(){
		lazyJs(["/plugin/swiper/js/swiper.min.js"],0,function(){
			 var swiper = new Swiper("#mdScrollPic", {
			        slidesPerView: 5,
			        spaceBetween: 10,
			        freeMode: true
			         
			      });
		})
		
	}
</script>

<?php
}
?>
