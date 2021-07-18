<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<link href="/plugin/swiper/css/swiper.min.css" rel="stylesheet" />
	 
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title"><?php echo $this->_var['data']['title']; ?></div>
		</div>
		<div class="header-row"></div>
		<div class="main-body mgb-10"> 
			<?php if ($this->_var['data']['videourl'] != ''): ?>
			<video 
				style="width: 100%;margin-bottom: 10px;"
				src="<?php echo $this->_var['data']['videourl']; ?>" 
				x5-playsinline="true"
				x-webkit-airplay="true"
				 playsinline="true" 
				 webkit-playsinline="true" 
			  controls="controls" autoplay=""></video>
			<?php endif; ?>
			<div class="swiper-container" style="width: 100%;" id="indexFlash">
				<div class="swiper-wrapper" >
					<?php $_from = $this->_var['imgsdata']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
					<div class="swiper-slide">
						<img class="imgWidth" src="<?php echo $this->_var['c']['trueimgurl']; ?>" />
					</div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</div>
				 
				<div class="swiper-pagination flex flex-jc-center"></div>
			 
			</div>
			<div class="row-box">
				<div class="d-title"><?php echo $this->_var['data']['title']; ?></div>
				<div class="d-tool bg-white">
					<?php echo $this->_var['data']['author']; ?>  <?php echo $this->cutstr($this->_var['data']['createtime'],11,''); ?>
				</div>
			</div>
			
			<div class="pd-10 bg-fff">
				<div class="d-content"> <?php echo $this->_var['data']['content']; ?> </div>
			</div>
		</div>
		<?php echo $this->fetch('inc/comment.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="<?php echo $this->_var['skins']; ?>inc/comment.js?<?php echo JS_VERSION; ?>"></script>
		<?php wx_jssdk();?> 
		<script type="text/javascript">
			wxshare_title="<?php echo $this->_var['data']['title']; ?>";
			<?php if ($this->_var['data']['imgurl']): ?> 
			 wxshare_imgUrl="<?php echo images_site($this->_var['data']['imgurl']); ?>.100x100.jpg";
			 <?php endif; ?>
		</script>
		<script>
			setTimeout(function(){
				$.get("/index.php?m=article&a=addclick&id=<?php echo $this->_var['data']['id']; ?>&ajax=1")
			},3000);
			
		</script>
		<script src="/plugin/swiper/js/swiper.min.js"></script>
		<script>
			$(function(){
				if($("#indexFlash .swiper-slide").length>0){
					var flash = new Swiper("#indexFlash", {
						pagination: {
							el: '.swiper-pagination',
						}
					});
				}else{
					$("#indexFlash").hide();
				}
				
			})
			
		</script>
	</body>
	
</html>