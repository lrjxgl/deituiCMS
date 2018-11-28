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
			<div class="header-back"></div>
			<div class="header-title">个人中心</div>
			 
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="uhead" v-if="pageLoad">

				<image class="uhead-img" src="http://img.deitui.com/?w=200&h=200&text=Logo&fontsize=36&textcolor=fff&bgcolor=ed6d53"></image>

				<div class="uhead-box">
					<div class="uhead-nick">老雷</div>
					<div class="uhead-rnum flex">
						余额 ￥
						<text class="f14 cl-money mgl-5">10</text>
					</div>
					<div class="uhead-rnum flex">
						金币
						<text class="cl-money mgl-5 mgr-5">10</text>

						积分
						<text class="cl-money mgl-5">10</text>

					</div>
				</div>
				<navigator gourl="/index.php?m=user&a=set" class="flex-center btn-small btn-link iconfont icon-settings"></navigator>
			</div>
			<div class=" bg-fff mgb-5">
				<div gourl="/index.php?m=notice&a=my" class="row-item"> 
					<div class="row-item-icon icon-text f18"></div>
					<div class="flex-1 f16">我的消息</div>
				</div>
				<div gourl="/index.php?m=notice&a=my" class="row-item"> 
					<div class="row-item-icon icon-text f18"></div>
					<div class="flex-1 f16">我的消息</div>
				</div>
			</div> 
		</div>
		<?php echo $this->fetch('footer-nav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>	
	</body>
</html>
