<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-title">我的</div>
		</div>
		<div class="header-row"></div>
		<div class="flex pd-10 mgb-10 bg-white flex-ai-center">
			<image class="wh-60 mgr-5 bd-radius-50" src="<?php echo $this->_var['user']['user_head']; ?>.100x100.jpg" />
			<div class="flex-1">
				<div class="mgb-10 f16"><?php echo $this->_var['user']['nickname']; ?></div>
				<div class="flex">
					<div class="mgr-10">帖子 <?php echo $this->_var['topic_num']; ?></div>
					<div>评论 <?php echo $this->_var['comment_num']; ?></div>
				</div>
			</div>
			
		</div>
		<div class="main-body">
			<div class="row-box">
				<div gourl="/module.php?m=forum&a=my" class="row-item">
					<div class="flex-1">我的帖子</div>
				</div>
				 
				<div gourl="/module.php?m=forum_comment&a=my" class="row-item">
					<div class="flex-1">我的评论</div>
				</div>
				<div gourl="/module.php?m=forum&a=myfav" class="row-item">
					<div class="flex-1">我的收藏</div>
				</div>
				 
			</div>
		</div>
		<?php echo $this->fetch('ftnav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
