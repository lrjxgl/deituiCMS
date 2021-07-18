<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('im_gift/nav.html'); ?>
		<div class="main-body">
			<table class="tbs">
				<thead>
					<tr>
						<td>giftid</td>
						 
						<td>名称</td>
						 
					 
						<td>图片</td>
						<td>状态</td>
						<td>推荐</td>
						<td>价格</td>
						<td>操作</td>
					</tr>
					</tr>
				</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<tr>
					<td><?php echo $this->_var['c']['giftid']; ?></td>
					 
					<td><?php echo $this->_var['c']['title']; ?></td>
					 
					 
					<td><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>" class="wh-60" /> </td>
					<td>
						<div url="/moduleadmin.php?m=im_gift&a=status&ajax=1&giftid=<?php echo $this->_var['c']['giftid']; ?>" class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status"></div>
					</td>
					<td>
						<div url="/moduleadmin.php?m=im_gift&a=recommend&ajax=1&giftid=<?php echo $this->_var['c']['giftid']; ?>" class="<?php if ($this->_var['c']['isrecommend'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status"></div>
					</td>
					<td><?php echo $this->_var['c']['price']; ?></td>
					<td><a href="/moduleadmin.php?m=im_gift&a=add&giftid=<?php echo $this->_var['c']['giftid']; ?>">编辑</a> 
					
					
						<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=im_gift&a=delete&giftid=<?php echo $this->_var['c']['giftid']; ?>">删除</a></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
			<div><?php echo $this->_var['pagelist']; ?></div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
