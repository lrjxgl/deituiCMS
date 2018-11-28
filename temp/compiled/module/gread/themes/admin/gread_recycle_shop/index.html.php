<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_recycle_shop/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>店名</td>
  
  
   <td>地址</td>
    
   <td>手机</td>
   <td>店主</td>
 
   <td>状态</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
 
   <td><?php echo $this->_var['c']['address']; ?></td>
   
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
  
   <td><?php echo $this->_var['c']['status']; ?></td>
<td><a href="/moduleadmin.php?m=gread_recycle_shop&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
<a href="/module.php?m=gread_recycle_shop&a=show&id=<?php echo $this->_var['c']['id']; ?>" target="_blank">查看</a>
 <a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=gread_recycle_shop&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>