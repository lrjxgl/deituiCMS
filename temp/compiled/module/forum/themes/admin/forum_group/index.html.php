<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
<div class="tabs-border">
	<a class="item active" href="/moduleadmin.php?m=forum_group">版块列表</a>
	<a class="item" href="/moduleadmin.php?m=forum_group&a=add">添加</a>
</div>
<div class="main-body">
<table class="tbs" width="100%">
    	 	<thead>
  <tr>
   <td>gid</td>
   <td>图片</td>
   <td>名称</td>
   <td>状态</td>
   <td>排序</td>
   
    
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['gid']; ?></td>
    <td><?php if ($this->_var['c']['imgurl']): ?><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg" width="50" /><?php endif; ?> </td>
   <td><?php echo $this->_var['c']['title']; ?></td>
  <td>
   	<div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=forum_group&a=status&gid=<?php echo $this->_var['c']['gid']; ?>&ajax=1" ></div>
   </td>
   <td><?php echo $this->_var['c']['orderindex']; ?></td>
  
   
<td>
	<a href="/moduleadmin.php?m=forum_group&a=add&gid=<?php echo $this->_var['c']['gid']; ?>">编辑</a> 
	<a href="/module.php?m=forum&a=list&gid=<?php echo $this->_var['c']['gid']; ?>" target="_blank">查看</a><br />
	<a href="/moduleadmin.php?m=forum_category&gid=<?php echo $this->_var['c']['gid']; ?>">管理分类</a>
	<a href="javascript:;" class="delete" url="/moduleadmin.php?m=forum_group&a=delete&gid=<?php echo $this->_var['c']['gid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>