<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('table/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>tableid</td>
   <td>名称</td>
   <td>表名称</td>
   <td>描述</td>
   <td>status</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['tableid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['tablename']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
<td>
	<a href="/admin.php?m=table_data&tableid=<?php echo $this->_var['c']['tableid']; ?>">数据列表</a>
	<a href="/admin.php?m=table_fields&a=table&tableid=<?php echo $this->_var['c']['tableid']; ?>">字段列表</a>
	<a href="admin.php?m=table&a=add&tableid=<?php echo $this->_var['c']['tableid']; ?>">编辑</a> 
<a href="admin.php?m=table&a=show&tableid=<?php echo $this->_var['c']['tableid']; ?>">查看</a> 
<a href="javascript:;" class="js-delete" url="admin.php?m=table&a=delete&ajax=1&tableid=<?php echo $this->_var['c']['tableid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>