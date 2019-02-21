<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title"><?php echo $this->_var['data']['title']; ?></div>
		</div>
		<div class="header-row"></div>
		<div class="main-body mgb-10">
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
		<script src="<?php echo $this->_var['skins']; ?>inc/comment.js"></script>
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
	</body>
	
</html>