<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title"><?php echo $this->_var['data']['title']; ?></div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="pd-10 bg-fff">
				<div class="d-content"> <?php echo $this->_var['data']['content']; ?> </div>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<?php wx_jssdk();?>
		<script type="text/javascript">
			wxshare_title="<?php echo $this->_var['data']['title']; ?>";
			<?php if ($this->_var['data']['imgurl']): ?> 
			 wxshare_imgUrl="<?php echo images_site($this->_var['data']['imgurl']); ?>.100x100.jpg";
			 <?php endif; ?>
		</script>
	</body>
	
</html>