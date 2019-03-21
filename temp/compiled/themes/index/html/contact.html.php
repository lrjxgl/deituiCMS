<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">联系我们</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="d-content pd-5"><?php echo $this->_var['data']['content']; ?></div>
			
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
