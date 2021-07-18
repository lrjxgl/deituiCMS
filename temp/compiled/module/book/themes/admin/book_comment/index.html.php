<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('book_comment/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td width="100">id</td>
  
 
  <td>内容</td>
   
  <td width="100">状态</td>
     
     
  <td width="100">操作</td>
 </tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   
  
   
   <td><?php echo $this->_var['c']['content']; ?></td>
    <td>
		<div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?>"></div>
	</td>
<td>
		 
		<a target="_blank" href="/module.php?m=book_comment&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> 
		<a href="javascript:;" class="js-delete" url="moduleadmin.php?m=book_comment&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>