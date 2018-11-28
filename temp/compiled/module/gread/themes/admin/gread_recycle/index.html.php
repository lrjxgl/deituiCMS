<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_recycle/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>用户</td>
   <td>创建时间</td>
   <td>状态</td>
   <td>description</td>
   <td>书名</td>
   <td>金额</td>
   <td>书店</td>
   <td>昵称</td>
   <td>头像</td>
   <td>地址</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['userid']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php echo $this->_var['c']['num']; ?></td>
   <td><?php echo $this->_var['c']['money']; ?></td>
   <td><?php echo $this->_var['c']['shopid']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['user_head']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
<td><a href="/module.php?m=gread_recycle&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> <a href="/module.php?m=gread_recycle&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_recycle&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>