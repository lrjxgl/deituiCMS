<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a href="/admin.php?m=admin" class="item active">管理员列表</a>
	<a href="/admin.php?m=admin&a=add" class="item">添加</a>
</div>
<div class="main-body">
 

<table class="tbs">
	<thead>
  <tr>
    <td width="92" height="30" align="center">ID</td>
    <td width="231" align="center">用户名</td>
    <td width="213" align="center">所数组</td>
    <td width="204" align="center">操作</td>
  </tr>
	</thead>
  <?php $_from = $this->_var['adminlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['id']; ?></td>
    <td align="center"><?php echo $this->_var['t']['username']; ?></td>
    <td align="center"><?php echo $this->_var['grouplist'][$this->_var['t']['group_id']]; ?></td>
    <td align="center"><a href="<?php echo $this->_var['appadmin']; ?>?m=admin&a=edit&id=<?php echo $this->_var['t']['id']; ?>">编辑</a> 
		<?php if (! $this->_var['t']['isfounder']): ?><a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=admin&a=del&id=<?php echo $this->_var['t']['id']; ?>">删除</a><?php endif; ?></td>
  </tr><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 
  
</table>

<?php echo $this->_var['pagelist']; ?>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>