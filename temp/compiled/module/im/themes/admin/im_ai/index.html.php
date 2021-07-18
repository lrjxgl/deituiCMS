<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('im_ai/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>名称</td>
   <td>api名称</td>
   <td>appid</td>
   <td>appkey</td>
   <td>配置内容</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['apiname']; ?></td>
   <td><?php echo $this->_var['c']['appid']; ?></td>
   <td><?php echo $this->_var['c']['appkey']; ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
<td><a href="/moduleadmin.php?m=im_ai&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>
 
 <a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=im_ai&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>