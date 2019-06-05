<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<a href="/" class="header-back pos-relative"></a>
			<div class="header-search-box">
				 
				<input id="search-word" class="header-search pdl-5" placeholder="搜你想要的" type="text">
				<div id="search-btn" class="header-search-btn bg-primary cl-white iconfont icon-search"></div>
			</div>
			 
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="row-box mgb-5">
				<div class="row-box-hd">
					<div class="flex-1 mgl-10 f16">推荐版块</div>
					<div gourl="/module.php?m=forum_group" class="row-box-more">更多</div>
				</div>
				<div class="flexlist">
					<?php $_from = $this->_var['grouplist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
						<div class="flexlist-item" gourl="/module.php?m=forum&a=list&gid=<?php echo $this->_var['c']['gid']; ?>">
							<img  src="<?php echo $this->_var['c']['imgurl']; ?>.100x100.jpg" class="flexlist-img" />
							<div class="flex-1">
								<div class="flexlist-title"><?php echo $this->_var['c']['title']; ?></div>
								<div class="flexlist-row">
									主题数
									<text class="cl-num mgl-5 mgr-10"><?php echo $this->_var['c']['topic_num']; ?></text> 
									 
									评论数
									<text class="cl-num  mgl-5"><?php echo $this->_var['c']['comment_num']; ?></text>
								</div>
								<div class="flexlist-desc"><?php echo $this->_var['c']['description']; ?></div>
							</div>
						</div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</div>
			</div>
			
			<div class="row-box-hd bg-white">
				<div class="flex-1 mgl-10 f16">推荐帖子</div>					 
			</div>
			<div class="sglist">
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<a href="/module.php?m=forum&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="sglist-item">
					<div class="sglist-title"><?php echo $this->_var['c']['title']; ?></div>
					<div class="sglist-desc"><?php echo $this->_var['c']['description']; ?></div>
					<div class="sglist-imglist">
						<?php $_from = $this->_var['c']['imgslist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['img']):
?>
						<img src="<?php echo $this->_var['img']; ?>.100x100.jpg" class="sglist-imglist-img" />
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
					<div class="sglist-ft">
						<div class="sglist-ft-love"><?php echo $this->_var['c']['love_num']; ?></div>
						<div class="sglist-ft-cm"><?php echo $this->_var['c']['comment_num']; ?></div>
						<div class="sglist-ft-view"><?php echo $this->_var['c']['view_num']; ?></div>
					</div> 
				</a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			
		</div>
		<?php echo $this->fetch('ftnav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			$(document).on("click","#search-btn",function(){
				var word=$("#search-word").val();
				window.location="/module.php?m=forum&a=search&keyword="+encodeURI(word)
			})
		</script>
	</body>
</html>
