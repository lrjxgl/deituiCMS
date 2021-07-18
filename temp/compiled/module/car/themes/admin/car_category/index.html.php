<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('car_category/nav.html'); ?>
		<div class="main-body">
		<table class="tbs">
			<thead>
				<tr>
					<td>catid</td>
					<td>分类名称</td>
					<td>图片</td>
				 
					<td>排序</td>
					<td>状态</td>
					<td>操作</td>
				</tr>
				</tr>
			</thead> 
			<?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<tr>
				<td><?php echo $this->_var['c']['catid']; ?></td>
				<td><?php echo $this->_var['c']['title']; ?></td>
				<td><?php if ($this->_var['c']['imgurl']): ?><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg" width="50" /><?php endif; ?></td>
				 
				<td><?php echo $this->_var['c']['orderindex']; ?></td>
				<td><div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=car_category&a=status&catid=<?php echo $this->_var['c']['catid']; ?>&ajax=1" ></div></td>
				<td>
					<a href="/moduleadmin.php?m=car_category&a=add&catid=<?php echo $this->_var['c']['catid']; ?>">编辑</a>
					<a href="/moduleadmin.php?m=car_category&a=addmore&catid=<?php echo $this->_var['c']['catid']; ?>">下级添加</a>
					<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=car_category&a=delete&catid=<?php echo $this->_var['c']['catid']; ?>">删除</a>
					<a href="/module.php?m=car_product&a=list&catid=<?php echo $this->_var['c']['catid']; ?>" target="_blank">查看</a>
				</td>
			</tr>
				<?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'cc');if (count($_from)):
    foreach ($_from AS $this->_var['cc']):
?>
				<tr>
					<td><?php echo $this->_var['cc']['catid']; ?></td>
					<td>|--<?php echo $this->_var['cc']['title']; ?></td>
					<td><?php if ($this->_var['cc']['imgurl']): ?><img src="<?php echo images_site($this->_var['cc']['imgurl']); ?>.100x100.jpg" width="50" /><?php endif; ?></td>
				 
					<td><?php echo $this->_var['cc']['orderindex']; ?></td>
					<td><div class="<?php if ($this->_var['cc']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=car_category&a=status&catid=<?php echo $this->_var['cc']['catid']; ?>&ajax=1" ></div></td>
					<td><a href="/moduleadmin.php?m=car_category&a=add&catid=<?php echo $this->_var['cc']['catid']; ?>">编辑</a>
 
						<a href="javascript:;" class="js-delete"te" url="/moduleadmin.php?m=car_category&a=delete&catid=<?php echo $this->_var['cc']['catid']; ?>">删除</a>
						<a href="/module.php?m=car_product&a=list&catid=<?php echo $this->_var['cc']['catid']; ?>" target="_blank">查看</a>
						</td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</table>
		<div><?php echo $this->_var['pagelist']; ?></div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		 
		
	</body>
</html>
