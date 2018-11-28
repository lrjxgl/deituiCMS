<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('imgdiy/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   
   <td>名称</td>
   <td>描述</td>
   <td>创建时间</td>
	 <td>状态</td>
   
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
  
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
	 <td><?php if ($this->_var['c']['status'] == 1): ?>显示<?php else: ?>隐藏<?php endif; ?></td>

   
<td><a href="/moduleadmin.php?m=imgdiy&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 

<a href="/moduleadmin.php?m=imgdiy&a=design&id=<?php echo $this->_var['c']['id']; ?>">设计</a> 
<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=imgdiy&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
 
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>