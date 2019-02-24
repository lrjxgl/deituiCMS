<!DOCTYPE >
<html>
<?php echo $this->fetch('head.html'); ?>
<link href="/plugin/swiper/css/swiper.min.css" rel="stylesheet" />
<style>
	.swiper-container{
		width: 100%;
		padding-bottom: 62.5%;
		height: 0;
	}
	.swiper-wrapper{
		width: 100%;
		flex-direction: row;
	}
</style>
<body>
<div class="header">
	<div class="header-title">deituiCMS</div>
</div>
<div class="header-row"></div>
<div class="main-body">
	<div class="swiper-container" id="indexFlash">
		<div class="swiper-wrapper" >
			<?php $_from = $this->_var['flashList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<div class="swiper-slide">
				<img class="imgWidth" src="<?php echo $this->_var['c']['imgurl']; ?>" />
			</div>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		 
		<div class="swiper-pagination"></div>
	 
	</div>
	<div class="row-box-hd pdl-10">
		<div class="flex-1 f20">文章推荐</div>
		<div gourl="/index.php?m=article" class="row-box-more">更多</div>
	</div>
	<div class="row-box">
	
	<?php $_from = $this->_var['articleList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
	<a href="/index.php?m=article&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="sglist-item">
		<?php if ($this->_var['c']['imgurl']): ?>
		<div class="sglist-imgbox">
			<img class="sglist-img" src="<?php echo $this->_var['c']['imgurl']; ?>.middle.jpg" />
		</div>
		<?php endif; ?>
		<div class="sglist-title"><?php echo $this->_var['c']['title']; ?></div>
		<div class="sglist-desc"><?php echo $this->_var['c']['description']; ?></div>
		<div class="sglist-ft">
			<div class="sglist-ft-love"><?php echo $this->_var['c']['love_num']; ?></div>
			<div class="sglist-ft-cm"><?php echo $this->_var['c']['comment_num']; ?></div>
			<div class="sglist-ft-view"><?php echo $this->_var['c']['view_num']; ?></div>
		</div> 
	</a>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
	 
</div> 
<?php echo $this->fetch('footer-nav.html'); ?>
<?php echo $this->fetch('footer.html'); ?>
<script src="/plugin/swiper/js/swiper.min.js"></script>
<script>
	$(function(){
		var flash=new Swiper("#indexFlash");
	})
	
</script>
</body>

</html>