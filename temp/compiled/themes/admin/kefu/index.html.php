<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div class="item active">客服咨询</div>
		</div>
		<div class="main-body">
			<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<a href="/admin.php?m=kefu&a=user&userid=<?php echo $this->_var['c']['userid']; ?>" class="row-item">
				<div class="mgr-5">
				<div class="cl2"><?php echo $this->_var['c']['nickname']; ?></div>
				<div class="cl3 f12 mgr-5"><?php echo $this->_var['c']['timeago']; ?></div>
				</div>
				<div class="flex-1 cl2"><?php echo $this->_var['c']['content']; ?></div>
			</a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
