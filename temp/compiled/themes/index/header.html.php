<div class="header">
	<div class="header-box">

		<img src="<?php echo $this->_var['site']['logo']; ?>" class="header-logo" alt="deituiCMS">

		<div class="header-navbar">
			<a href="/" class="header-navbar-item header-navbar-active">首页</a>
			<a href="/index.php?m=fangan" class="header-navbar-item">解决方案</a>
			<a href="/module.php?m=down" class="header-navbar-item">应用中心</a>
			<a href="/module.php?m=ask" class="header-navbar-item">交流论坛</a>
			<a href="/module.php?m=cylm" class="header-navbar-item">创业联盟</a>
 

		</div>
		<?php $this->_var["ssuser"]=$_SESSION["ssuser"];;?>
		<?php if ($this->_var['ssuser']): ?>
		<div gourl="/index.php?m=user" class="header-user">
			<div class="header-user-nick"><?php echo $this->_var['ssuser']['nickname']; ?></div>
			<img class="header-user-head" src="<?php echo images_site($this->_var['ssuser']['user_head']); ?>.100x100.jpg">
		</div>
		<?php else: ?>
		<div class="header-login">
			<div gourl="/index.php?m=login">登录</div>
			<div gourl="/index.php?m=register">注册</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="header-navbar-action" style="left: 367.025px;"></div>
</div>
