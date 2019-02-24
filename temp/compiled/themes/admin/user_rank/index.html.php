<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	 <a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=user_rank">等级管理</a> 
   <a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=user_rank&a=add">等级添加</a> 
</div>
<div class="main-body">
 <table class="tbs">
 	<thead>
  <tr>
   <td>id</td>
   <td>等级名称</td>
   <td>等级标识</td>
   <td>最低积分</td>
   <td>最高积分</td>
   <td>折扣</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['rank_name']; ?></td>
   <td><img src="<?php echo IMAGES_SITE($this->_var['c']['logo']); ?>" width="30" /></td>
   <td><?php echo $this->_var['c']['min_grade']; ?></td>
   <td><?php echo $this->_var['c']['max_grade']; ?></td>
   <td><?php echo $this->_var['c']['discount']; ?>%</td>
<td><a href="admin.php?m=user_rank&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> <a href="admin.php?m=user_rank&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> <a href="javascript:;" class="delete" url="admin.php?m=user_rank&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 </div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>