<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">邀请奖励</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			 
			<?php if (! $this->_var['rscount']): ?>
				<div class="emptyData">暂无消费记录</div>
			 
			<?php else: ?>
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
				<div class="row-box mgb-5">
					<div class="flex bd-mp-5">
						<div class="cl1"><?php echo $this->_var['item']['timeago']; ?></div>
						<div class="flex-1"></div>
						<div class="cl-money">￥<?php echo $this->_var['item']['money']; ?></div>
					</div>
					<div class="cl3"><?php echo $this->_var['item']['content']; ?></div>

				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php endif; ?>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
