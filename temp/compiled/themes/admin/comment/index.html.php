<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
<div class="tabs-border">
	<a class="item active" href="/admin.php?m=comment">文章评论</a>
</div> 
<div class="main-body">
	<table class="tbs">
		<colgroup>
			<col width="100">
			<col />
			<col width="100">
		</colgroup>
		<thead>
			<tr>
				<td>发布时间</td>
				<td>内容</td>
				<td>操作</td>
			</tr>
		</thead>
		<?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		<tr>
			<td><?php echo $this->_var['c']['createtime']; ?></td>
			<td><?php echo $this->_var['c']['content']; ?></td>
			<td>
				删除
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		
	</table>
</div>

</body>
</html>