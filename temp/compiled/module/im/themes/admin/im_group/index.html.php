<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('im_group/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>groupid</td>
   <td>名称</td>
   <td>logo</td>
   <td>类型</td>
   <td>描述</td>
  
   <td>状态</td>
   
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['groupid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
    <td><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>" class="wh-60" /> </td>
   <td><?php echo $this->_var['c']['typeid_title']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td>
	   <div url="/moduleadmin.php?m=im_group&a=status&ajax=1&groupid=<?php echo $this->_var['c']['groupid']; ?>" class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status"></div>
   </td>
  
<td><a href="/moduleadmin.php?m=im_group&a=add&groupid=<?php echo $this->_var['c']['groupid']; ?>">编辑</a> 
 
<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=im_group&a=delete&groupid=<?php echo $this->_var['c']['groupid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>