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
					<div class="mgb-10 f16 flex">
						<div><?php echo $this->_var['user']['nickname']; ?></div>
						<div class="flex-1"></div>
						<?php if ($this->_var['invitecode']): ?>
						<div class="cl2 mgr-5">邀请码</div>
						<div gourl="/index.php?m=invite&a=my" class="cl-num"><?php echo $this->_var['invitecode']; ?></div>
						<?php endif; ?>
					</div>
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
			 
		
		<div class="row-box mgb-5">
			 
			 
			<div gourl="/index.php?m=notice&a=my" class="row-item">
				<div class="row-item-icon icon-notice  cl-u"></div>
				<div class="row-item-title">我的消息</div>
			</div>
		
			<div gourl="/index.php?m=recharge&a=my" class="row-item">
				<div class="row-item-icon icon-moneybag  cl-u"></div>
				<div class="row-item-title">支付记录</div>
			</div>
		
		
			<div gourl="/index.php?m=user_address&a=my" class="row-item">
				<div class="row-item-icon icon-addressbook  cl-u"></div>
				<div class="row-item-title">收货地址</div>
			</div>
		
			<div gourl="/index.php?m=kefu" class="row-item">
				<div class="row-item-icon icon-service  cl-u"></div>
				<div class="row-item-title">联系客服</div>
			</div>
			<div gourl="/index.php?m=html&a=aboutus" class="row-item">
				<div class="row-item-icon icon-info  cl-u"></div>
				<div class="row-item-title">关于我们</div>
			</div>
		</div>
		</div>	
		</div>
		<?php echo $this->fetch('footer-nav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>	
	</body>
</html>
