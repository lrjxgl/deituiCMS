<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
<div class="tabs-border">
	<a class="item active" href="/admin.php?m=dataapi">单页管理</a>
	<a class="item" href="/admin.php?m=dataapi&a=add">单页添加</a>
</div> 
<div class="main-body">
	<table class="tbs">
 <thead>
  <tr>
   <td>id</td>
   <td>标题</td>
   <td>唯一代号</td>
   <td>添加时间</td>
   <td>数据类型</td>
   <td>调用方法</td>
    
   <td>状态</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['word']; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td><?php echo $this->_var['type_list'][$this->_var['c']['type_id']]; ?></td>
   <td><?php echo $this->_var['c']['equation']; ?></td>
    
   <td><?php if ($this->_var['c']['status'] == 2): ?>
           <img src="/static/images/yes.gif" class="ajax_no"  rurl="<?php echo $this->_var['appadmin']; ?>?m=dataapi&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=2" url="<?php echo $this->_var['appadmin']; ?>?m=dataapi&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=1" />
           <?php else: ?>
           <img src="/static/images/no.gif"  class="ajax_yes" url="<?php echo $this->_var['appadmin']; ?>?m=dataapi&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=2" rurl="<?php echo $this->_var['appadmin']; ?>?m=dataapi&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=1" />  
          <?php endif; ?></td>
<td><a href="admin.php?m=dataapi&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> <a href="admin.php?m=dataapi&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> <a href="javascript:;" class="js-delete" url="admin.php?m=dataapi&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>

<?php echo $this->fetch('footer.html'); ?>
</body>
</html>