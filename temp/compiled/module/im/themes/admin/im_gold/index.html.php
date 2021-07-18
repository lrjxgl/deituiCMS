<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('im_gold/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>金币</td>
   <td>价格</td>
   <td>状态</td>
   <td>创建时间</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['gold']; ?></td>
   <td><?php echo $this->_var['c']['price']; ?></td>
   <td><?php if ($this->_var['c']['status'] == 1): ?>上线<?php else: ?>下线<?php endif; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
<td><a href="/moduleadmin.php?m=im_gold&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=im_gold&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>