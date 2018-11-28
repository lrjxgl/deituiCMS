<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		 
		<view class="header">
			<view class="header-back"></view>
			<view class="header-title">我的消息</view>
		</view>
		<view class="header-row"></view>
		<view class="main-body">
			<view class="list ">
				<?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<view class="row-box mgb-5">
					<view class="cl3 bd-mp-5"><?php echo $this->_var['c']['content']; ?></view>
					<view class="flex">
					<view class="flex-1 cl2"><?php echo $this->_var['c']['timeago']; ?></view>
					<view gourl="<?php echo $this->_var['c']['linkurl']; ?>" class="btn-mini btn-outline-primary">去查看</view>
					</view>
				</view>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				 
			</view>
		</view>
		
	<?php echo $this->fetch('footer.html'); ?> 
	</body>
</html>
