<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_book_category/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>catid</td>
   <td>title</td>
   <td>pid</td>
   <td>orderindex</td>
   <td>status</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['catid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['pid']; ?></td>
   <td><?php echo $this->_var['c']['orderindex']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
<td><a href="/module.php?m=gread_book_category&a=add&catid=<?php echo $this->_var['c']['catid']; ?>">编辑</a> <a href="/module.php?m=gread_book_category&a=show&catid=<?php echo $this->_var['c']['catid']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_book_category&a=delete&catid=<?php echo $this->_var['c']['catid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>