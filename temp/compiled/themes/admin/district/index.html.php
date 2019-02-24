<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="?m=district">省市列表</a>
	<a class="item" href="?m=district&a=add">添加</a>
</div>	
<div class="main-body">
	<div class="pd-10"> 
<?php if ($this->_var['parent']): ?>
&lt;&lt;<a href="<?php echo $this->_var['appadmin']; ?>?m=district&upid=<?php echo $this->_var['parent']['upid']; ?>"><?php echo $this->_var['parent']['name']; ?></a>
<?php else: ?>
地区编辑
<?php endif; ?>
</div>
 <table class="tbs">
 	<thead>
  <tr>
   <td>id</td>
   <td>name</td>
   <td>level</td>
   <td>usetype</td>
   <td>upid</td>
   <td>displayorder</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><a href="<?php echo $this->_var['appadmin']; ?>?m=district&upid=<?php echo $this->_var['c']['id']; ?>"><?php echo $this->_var['c']['name']; ?></a></td>
   <td><?php echo $this->_var['c']['level']; ?></td>
   <td><?php echo $this->_var['c']['usetype']; ?></td>
   <td><?php echo $this->_var['c']['upid']; ?></td>
   <td><?php echo $this->_var['c']['displayorder']; ?></td>
<td>
<a href="<?php echo $this->_var['appadmin']; ?>?m=district&a=addchild&upid=<?php echo $this->_var['c']['id']; ?>">添加下级</a>
<a href="<?php echo $this->_var['appadmin']; ?>?m=district&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>  
<a href="javascript:;" class="delete" url="<?php echo $this->_var['appadmin']; ?>?m=district&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>