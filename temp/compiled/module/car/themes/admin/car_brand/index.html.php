<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('car_brand/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>brandid</td>
   <td>名称</td>
    <td>图片</td>
   <td>排序</td>
   <td>状态</td>
   
  
   
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['brandid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td>
   	   <img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg" class="wh-40" />
   
   
   </td>
   <td><?php echo $this->_var['c']['orderindex']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
    
   
   
<td><a href="moduleadmin.php?m=car_brand&a=add&brandid=<?php echo $this->_var['c']['brandid']; ?>">编辑</a> <a target="_blank" href="/module.php?m=car_brand&a=show&brandid=<?php echo $this->_var['c']['brandid']; ?>">查看</a> <a href="javascript:;" class="js-delete" url="moduleadmin.php?m=car_brand&a=delete&ajax=1&brandid=<?php echo $this->_var['c']['brandid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>