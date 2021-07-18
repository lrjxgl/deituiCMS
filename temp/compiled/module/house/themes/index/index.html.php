<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<link href="/plugin/swiper/css/swiper.min.css" rel="stylesheet" />
	<body>
		<div class="header">
			<a href="/" class="header-back"></a>
			<div class="header-title">福鼎买房</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="scale-swiper-box">
				<div class="swiper-container scale-swiper-container" id="indexFlash">
					<div class="swiper-wrapper">
						<?php $_from = $this->_var['flashList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
						<div class="swiper-slide scale-swiper-slide">
							<div gourl="<?php echo $this->_var['c']['link1']; ?>" class="scale-swiper-bgimg" style="background-image:url(<?php echo $this->_var['c']['imgurl']; ?>);" ></div>
						</div>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
				
					<div class="swiper-pagination"></div>			
				</div>
			</div>
			<div class="f18 cl1 pd-10">楼盘推荐</div>
			<div class="flexlist">
				<?php $_from = $this->_var['loupanList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<a href="/module.php?m=house_loupan&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="flexlist-item">
					<img class="flexlist-img" src="<?php echo $this->_var['c']['imgurl']; ?>.100x100.jpg">
					<div class="flex-1">
						<div class="flexlist-title"><?php echo $this->_var['c']['title']; ?></div>
						<div class="flex mgb-5">
							<span class="cl-num"><?php if ($this->_var['c']['isbuy'] == 1): ?>在售<?php else: ?>未售<?php endif; ?></span>
							<div class="flex-1"></div>
							<span class="cl2"><?php echo $this->_var['c']['price']; ?>元/平</span>
						</div>
						<div class="cl3 f12"><?php echo $this->_var['c']['address']; ?></div>
					</div>
				</a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			<div class="f18 cl1 pd-10">房源推荐</div>
			 
			 <?php $_from = $this->_var['recList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			 <a href="/module.php?m=house_resource&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="sglist-item js-item">
			 	<div class="sglist-title"><?php echo $this->_var['c']['description']; ?></div>
			 	 
			 	<div class="sglist-imglist">
			 		<?php $_from = $this->_var['c']['imgslist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['img']):
?>
			 		<img src="<?php echo $this->_var['img']; ?>.100x100.jpg" class="sglist-imglist-img" />
			 		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 	</div>
			 	<div class="flex">
			 		<div class="mgr-10 cl2">总价</div>
			 		<div class="mgb-5 cl-money">￥<?php echo $this->_var['c']['total_money']; ?></div>
			 		<div class="cl2">万元</div>
			 	</div>   
			 </a>
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 
			<div class="f18 cl1 pd-10">最新房源</div>
			<?php $_from = $this->_var['newList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			 <a href="/module.php?m=house_resource&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="sglist-item js-item">
			 	<div class="sglist-title"><?php echo $this->_var['c']['description']; ?></div>
			 	 
			 	<div class="sglist-imglist">
			 		<?php $_from = $this->_var['c']['imgslist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['img']):
?>
			 		<img src="<?php echo $this->_var['img']; ?>.100x100.jpg" class="sglist-imglist-img" />
			 		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 	</div>
			 	<div class="flex">
			 		<div class="mgr-10 cl2">总价</div>
			 		<div class="mgb-5 cl-money">￥<?php echo $this->_var['c']['total_money']; ?></div>
			 		<div class="cl2">万元</div>
			 	</div>   
			 </a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		<?php $this->assign('ftnav','home'); ?>
		<?php echo $this->fetch('ftnav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/swiper/js/swiper.min.js"></script>
		<script>
			$(function() {
				var flash = new Swiper("#indexFlash");
			})
		</script>
		<?php wx_jssdk();?>
		<script type="text/javascript">
			wxshare_title="<?php echo $this->_var['seo']['title']; ?>";
			<?php if ($this->_var['site']['logo']): ?> 
			 wxshare_imgUrl="<?php echo $this->_var['site']['logo']; ?>.100x100.jpg";
			 <?php endif; ?>
		</script>
	</body>
</html>
