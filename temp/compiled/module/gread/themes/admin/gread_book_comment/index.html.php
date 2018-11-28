<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_book_comment/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>bookid</td>
   <td>userid</td>
   <td>createtime</td>
   <td>raty</td>
   <td>content</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['bookid']; ?></td>
   <td><?php echo $this->_var['c']['userid']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['raty']; ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
<td><a href="/module.php?m=gread_book_comment&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> <a href="/module.php?m=gread_book_comment&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_book_comment&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>