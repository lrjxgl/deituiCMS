<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div gourl="?m=guest&type=new" class="item <?php if (get ( 'type' ) == 'new'): ?>active<?php endif; ?>">待审核</div>
			<div gourl="?m=guest&type=pass"  class="item <?php if (get ( 'type' ) == 'pass'): ?>active<?php endif; ?>">已通过</div>
			<div gourl="?m=guest&type=forbid"  class="item <?php if (get ( 'type' ) == 'forbid'): ?>active<?php endif; ?>">已禁止</div>
			<div gourl="?m=guest&type=all"  class="item <?php if (get ( 'type' ) == 'all'): ?>active<?php endif; ?>">全部</div>
		</div>
		 
		<div class="main-body">
			<table class="tbs">
				<thead>
					<tr>
						<td>id</td>
 
						<td>内容</td>
						<td>联系人</td>
						<td>电话</td>
						<td>状态</td>
						<td>发布时间</td>
						<td>操作</td>
					</tr>
				</thead>

				<?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<tr>
					<td><?php echo $this->_var['c']['id']; ?></td>
					<td>
						<div style="width:200px; overflow:auto;"><?php echo strip_tags($this->_var['c']['content']); ?></div>
					</td>
					<td><?php echo $this->_var['c']['nickname']; ?></td>
					<td><?php echo $this->_var['c']['telephone']; ?></td>
					<td>
						<div url="?m=guest&a=status&ajax=1&id=<?php echo $this->_var['c']['id']; ?>" class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status"></div>
					</td>
					<td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
					<td>
						<a href="<?php echo $this->_var['appadmin']; ?>?m=guest&a=add&id=<?php echo $this->_var['c']['id']; ?>">回复</a>
						<a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=guest&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
