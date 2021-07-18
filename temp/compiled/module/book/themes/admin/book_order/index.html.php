<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		 
		<div class="tabs-border">
			<a class="item active" href="/moduleadmin.php?m=book_order">订单列表</a>
			<a class="item" href="/moduleadmin.php?m=book_order&a=add">添加订单</a>
		</div>
		<div class="main-body">
		    <table class="tbs">
		    	<thead>
		    		<tr>
		    			<td>ID</td>
		    			<td>书名</td>
		    			<td>客户</td>
		    			<td>时间</td>
		    			<td>操作</td>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		<?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		    		<tr class="item">
		    			<td><?php echo $this->_var['c']['orderid']; ?></td>
		    			<td><?php echo $this->_var['c']['title']; ?></td>
		    			<td><?php echo $this->_var['c']['nickname']; ?></td>
		    			<td><?php echo $this->_var['c']['createtime']; ?></td>
		    			<td>
		    				<a href="JavaScript:;" class="js-delete" url="/moduleadmin.php?m=book_order&a=delete&ajax=1&orderid=<?php echo $this->_var['c']['orderid']; ?>">删除订单</a> 
		    				
		    			</td>
		    		</tr>
		    		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		    	</tbody>
		    </table>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
