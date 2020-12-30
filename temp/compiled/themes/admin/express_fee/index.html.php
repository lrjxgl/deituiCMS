<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="?m=express_fee">费用列表</a>
	<a class="item" href="?m=express_fee&a=add">添加</a>
</div>	
<div class="main-body">
 <table class="tbs">
  <tr>
   <td>id</td>
   <td>标题</td>
   <td>首重</td>
   <td>加重</td>
  
<td>操作</td>
  </tr>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['fmoney']; ?></td>
   <td><?php echo $this->_var['c']['amoney']; ?></td>
 
<td><a href="/admin.php?m=express_fee&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>
 
 <a href="javascript:;" class="js-delete" url="admin.php?m=express_fee&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>