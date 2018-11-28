<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_book/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>bookid</td>
   <td>分类</td>
   <td>书名</td>
   <td>简介</td>
   <td>图片</td>
   <td>价格</td>
   <td>createtime</td>
   <td>status</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['bookid']; ?></td>
   <td><?php echo $this->_var['c']['catid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php echo $this->_var['c']['imgurl']; ?></td>
   <td><?php echo $this->_var['c']['price']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
<td><a href="/module.php?m=gread_book&a=add&bookid=<?php echo $this->_var['c']['bookid']; ?>">编辑</a> <a href="/module.php?m=gread_book&a=show&bookid=<?php echo $this->_var['c']['bookid']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_book&a=delete&bookid=<?php echo $this->_var['c']['bookid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>