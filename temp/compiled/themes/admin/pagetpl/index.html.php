<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a class="item active" href="?m=pagetpl">模板列表</a>
	<a class="item" href="?m=pagetpl&a=add">模板添加</a>
</div> 
 
<div class="main-body"> 
 
 <table class="tbs">
 	<thead>
  <tr>
   <td>id</td>
   <td>m</td>
   <td>a</td>
   <td>tpl</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['m']; ?></td>
   <td><?php echo $this->_var['c']['a']; ?></td>
   <td><?php echo $this->_var['c']['tpl']; ?></td>
<td><a href="admin.php?m=pagetpl&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
	
	<a href="javascript:;" class="js-delete" url="admin.php?m=pagetpl&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>