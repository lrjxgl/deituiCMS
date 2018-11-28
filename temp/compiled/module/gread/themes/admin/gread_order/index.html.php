<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_order/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>orderid</td>
   <td>userid</td>
   <td>shopid</td>
   <td>createtime</td>
   <td>是否配送</td>
   <td>配送费用</td>
   <td>地址</td>
   <td>手机</td>
   <td>昵称</td>
   <td>备注</td>
   <td>status</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['orderid']; ?></td>
   <td><?php echo $this->_var['c']['userid']; ?></td>
   <td><?php echo $this->_var['c']['shopid']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['issend']; ?></td>
   <td><?php echo $this->_var['c']['sendmoney']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
<td><a href="/module.php?m=gread_order&a=add&orderid=<?php echo $this->_var['c']['orderid']; ?>">编辑</a> <a href="/module.php?m=gread_order&a=show&orderid=<?php echo $this->_var['c']['orderid']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_order&a=delete&orderid=<?php echo $this->_var['c']['orderid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>