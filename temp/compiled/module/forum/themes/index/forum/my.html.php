<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">我的帖子</div>
			<div gourl="/module.php?m=forum&a=add" class="header-right-btn">发帖</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="list">
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<div class="sglist-item js-item">
					<div class="sglist-title"><?php echo $this->_var['c']['title']; ?></div>
					<div class="sglist-desc"><?php echo $this->_var['c']['description']; ?></div>
					<div class="sglist-imglist">
						<?php $_from = $this->_var['c']['imgslist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['img']):
?>
						<img src="<?php echo $this->_var['img']; ?>.100x100.jpg" class="sglist-imglist-img" />
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
					<div class="flex flex-jc-center mgt-5">
						<div gourl="/module.php?m=forum&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="btn-small mgr-10">查看</div>
						<div class="btn-small mgr-10" gourl="/module.php?m=forum&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</div>
						<div class="btn-small btn-danger js-delete" url="/module.php?m=forum&a=delete&id=<?php echo $this->_var['c']['id']; ?>&ajax=1">删除</div>
					</div>
				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
