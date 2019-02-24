<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<style>
		.uhead {
			display: flex;
			flex-direction: row;
			padding: 10px;
			background-color: #fff;
			margin-bottom: 5px;
		}
	
		.uhead-img {
			width: 80px;
			height: 80px;
			margin-right: 10px;
			display: block;
			border-radius: 50%;
		}
	
		.uhead-box {
			flex: 1;
		}
	
		.uhead-nick {
			margin-bottom: 5px;
			font-size: 16px;
		}
	
		.uhead-rnum {
			color: #999;
			margin-bottom: 10px;
			line-height: 14px;
			display: flex;
			font-size: 14px;
		}
		 
	</style>
	<body>
		<div class="header">
			<a href="/" class="header-back"></a>
			<div class="header-title">个人中心</div>
			 
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="uhead" v-if="pageLoad">

				<image gourl="/index.php?m=user&a=user_head" class="uhead-img" src="<?php echo $this->_var['data']['user_head']; ?>.100x100.jpg"></image>

				<div class="uhead-box">
					<div class="uhead-nick"><?php echo $this->_var['data']['nickname']; ?></div>
					<div class="uhead-rnum flex flex-ai-center">
						余额 ￥
						<text class="f14 cl-money mgl-5"><?php echo $this->_var['data']['money']; ?></text>
					</div>
					<div class="uhead-rnum flex  flex-ai-center">
						金币
						<text class="cl-money mgl-5 mgr-5"><?php echo $this->_var['data']['gold']; ?></text>

						积分
						<text class="cl-money mgl-5"><?php echo $this->_var['data']['grade']; ?></text>

					</div>
				</div>
				<div gourl="/index.php?m=user&a=set" class="flex-center btn-small btn-link iconfont icon-settings"></div>
			</div>
		 
		<?php $_from = $this->_var['navList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<div class="m-navPic mgb-10">
				<?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'cc');if (count($_from)):
    foreach ($_from AS $this->_var['cc']):
?>
				<div gourl="<?php echo $this->_var['cc']['link_url']; ?>" class="m-navPic-item">
					<div class="m-navPic-icon <?php echo $this->_var['cc']['icon']; ?>"></div>
					<div class="m-navPic-title"><?php echo $this->_var['cc']['title']; ?></div>
				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
			
		</div>
		<?php echo $this->fetch('footer-nav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>	
	</body>
</html>
