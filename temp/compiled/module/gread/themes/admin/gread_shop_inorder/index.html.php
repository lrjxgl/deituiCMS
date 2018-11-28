<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_shop_inorder/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>orderid</td>
   <td>shopid</td>
   <td>createtime</td>
   <td>money</td>
   <td>telephone</td>
   <td>address</td>
   <td>nickname</td>
   <td>bookmoney</td>
   <td>status</td>
   <td>isrecived</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['orderid']; ?></td>
   <td><?php echo $this->_var['c']['shopid']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['money']; ?></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['bookmoney']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
   <td><?php echo $this->_var['c']['isrecived']; ?></td>
<td><a href="/module.php?m=gread_shop_inorder&a=add&orderid=<?php echo $this->_var['c']['orderid']; ?>">编辑</a> <a href="/module.php?m=gread_shop_inorder&a=show&orderid=<?php echo $this->_var['c']['orderid']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_shop_inorder&a=delete&orderid=<?php echo $this->_var['c']['orderid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>