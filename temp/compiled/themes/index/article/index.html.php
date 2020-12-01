<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">文章</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="pd-10 bg-fff">
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
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
		<?php echo $this->fetch('footer.html'); ?>
		
	</body>
</html>
