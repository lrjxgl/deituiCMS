<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_user/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>userid</td>
   <td>昵称</td>
   <td>头像</td>
   <td>手机</td>
   <td>createtime</td>
   <td>保证金</td>
   <td>会员到期时间</td>
   <td>订单状态</td>
   <td>shopid</td>
   <td>address</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['userid']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['user_head']; ?></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['bond']; ?></td>
   <td><?php echo $this->_var['c']['endtime']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
   <td><?php echo $this->_var['c']['shopid']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
<td><a href="/module.php?m=gread_user&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> <a href="/module.php?m=gread_user&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_user&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>