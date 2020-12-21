<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<link href="/plugin/swiper/css/swiper.min.css" rel="stylesheet" />
	<link href="<?php echo $this->_var['skins']; ?>b2c/index.css?v1" rel="stylesheet" />
	<body>
		<div class="header">
			<img src="<?php echo $this->_var['site']['logo']; ?>.100x100.jpg" class="header-logo" />
			<div class="header-search-box">
				<input id="keyword" type="search" class="header-search pdl-5" />
				<div id="searchBtn" class="header-search-btn  iconfont icon-search"></div>
			</div>
			 
		</div>
		<div class="header-row"></div>
		
		<div class="main-body">
			<div class="scale-swiper-box" style="padding-bottom: 50%;">
				<div class="swiper-container scale-swiper-container" id="indexFlash">
					<div class="swiper-wrapper" >
						<?php $_from = $this->_var['flashList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
						<div class="swiper-slide scale-swiper-slide">
							<img class="wmax" src="<?php echo $this->_var['c']['imgurl']; ?>" />
							 
						</div>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
					 
					<div class="swiper-pagination"></div>
				 
				</div>
			</div>
			<?php if ($this->_var['navList']): ?>
			<div class="m-navPic">
			    <?php $_from = $this->_var['navList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			    <a href="<?php echo $this->_var['c']['link1']; ?>" class="m-navPic-item">
					  <img class="m-navPic-img" src="<?php echo images_site($this->_var['c']['imgurl']); ?>" />
					  <div class="m-navPic-title"><?php echo $this->_var['c']['title']; ?></div>
					   
			    </a>
				
			    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_var['adList']): ?>
			<div class="adBox">
				<?php $_from = $this->_var['adList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<div class="adBox-item">
					<img gourl="<?php echo $this->_var['c']['link1']; ?>" src="<?php echo $this->_var['c']['imgurl']; ?>" class="adBox-img" />
				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						 
			</div>
			<?php endif; ?>
			<div class="row-box-hd  pdl-10" >
				<div class="iconfont mgr-10 icon-likefill cl-f30 f22"></div>
				<div class="flex-1 ">
					<div class="f14">必买好货</div>
					<div class="cl3 f12">大家都会心动的产品</div>
					</div>
				<div gourl="/module.php?m=b2c_group_product&gkey=bimai" class="row-box-more"></div>
			</div>
			<div class="">
			<div class="mtlist">
			 
				<?php $_from = $this->_var['bmList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<a href="/module.php?m=b2c_product&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="mtlist-item">
					<div class="mtlist-item-bd">
						<div class="mtlist-bgimg-box">
							<div class="mtlist-bgimg" style="background-image:url(<?php echo $this->_var['c']['imgurl']; ?>.small.jpg)" ></div>
						</div>
						<div class="mtlist-item-pd">
							<div class="mtlist-item-money">
								<div class="mtlist-item-money-flex">￥
									<text class="mtlist-item-money_money"><?php echo $this->_var['c']['price']; ?></text>
								</div>
								<div class="mtlist-item-money_num">月销<?php echo $this->_var['c']['buy_num']; ?>件</div>
							</div>
							<div class="mtlist-title"><?php echo $this->_var['c']['title']; ?></div>
							 
						</div>
					</div>
				</a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			</div>
			<div class="row-box-hd  pdl-10" >
				<div class="iconfont mgr-10 icon-moneybag cl-f30 f20"></div>
				<div class="flex-1 ">
					<div class="f14">猜你喜欢</div>
					<div class="cl3 f12">Guess You Like It</div>
					</div>
				<div gourl="/module.php?m=b2c_product&type=recommend" class="row-box-more"></div>
			</div>
			<div class="">
			<div class="mtlist">
				<?php $_from = $this->_var['recList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<a href="/module.php?m=b2c_product&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="mtlist-item">
					<div class="mtlist-item-bd">
						<div class="mtlist-bgimg-box">
							<div class="mtlist-bgimg" style="background-image:url(<?php echo $this->_var['c']['imgurl']; ?>.small.jpg)" ></div>
						</div>
						<div class="mtlist-item-pd">
							<div class="mtlist-item-money">
								<div class="mtlist-item-money-flex">￥
									<text class="mtlist-item-money_money"><?php echo $this->_var['c']['price']; ?></text>
								</div>
								<div class="mtlist-item-money_num">月销<?php echo $this->_var['c']['buy_num']; ?>件</div>
							</div>
							<div class="mtlist-title"><?php echo $this->_var['c']['title']; ?></div>
							 
						</div>
					</div>
				</a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			</div>
			<div class="row-box-hd  pdl-10 mtt10" >
				<div class="iconfont mgr-10 icon-hot_light cl-f30 f20"></div>
				<div class="flex-1 ">
					<div class="f14">热销商品</div>
					<div class="cl3 f12">Hot Goods</div>
					</div>
				<div gourl="/module.php?m=b2c_product&type=hot" class="row-box-more"></div>
			</div>
			<div class="">
			 
			<div class="mtlist">
				<?php $_from = $this->_var['hotList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<a href="/module.php?m=b2c_product&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="mtlist-item">
					<div class="mtlist-item-bd">
						<div class="mtlist-bgimg-box">
							<div class="mtlist-bgimg" style="background-image:url(<?php echo $this->_var['c']['imgurl']; ?>.small.jpg)" ></div>
						</div>
						<div class="mtlist-item-pd">
							<div class="mtlist-item-money">
								<div class="mtlist-item-money-flex">￥
									<text class="mtlist-item-money_money"><?php echo $this->_var['c']['price']; ?></text>
								</div>
								<div class="mtlist-item-money_num">月销<?php echo $this->_var['c']['buy_num']; ?>件</div>
							</div>
							<div class="mtlist-title"><?php echo $this->_var['c']['title']; ?></div>
							 
						</div>
					</div>
				</a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			</div>
		</div>
		 <?php $this->assign('ftnav','b2c_home'); ?>
		<?php echo $this->fetch('ftnav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/swiper/js/swiper.min.js"></script>
		<script>
			$(function(){
				var flash=new Swiper("#indexFlash",{
					loop: true,
					pagination: {
					  el: '.swiper-pagination'
					},
				});
				$(document).on("click","#searchBtn",function(){
					var keyword=$("#keyword").val();
					window.location="/module.php?m=b2c_search&keyword="+encodeURIComponent(keyword);
				})
			})
			
		</script>
		 
	</body>
</html>
