<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a class="item active" href="/admin.php?m=category">分类列表</a>
		<a class="item" href="/admin.php?m=category&a=add">添加</a>
	</div>
<div class="main-body"> 

<div class="tabs-border tabs-border-inner"> 
<?php $_from = $this->_var['modellist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
<a class="item  <?php if ($this->_var['tablename'] == $this->_var['c']['tablename']): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=category&tablename=<?php echo $this->_var['c']['tablename']; ?>"><?php echo $this->_var['c']['title']; ?></a>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<a class="item fr" href="<?php echo $this->_var['appadmin']; ?>?m=category&pid=<?php echo $this->_var['nextpid']; ?>&tablename=<?php echo $this->_var['tablename']; ?>">&lt;&lt; 上级分类</a>

</div>

 
<table  class="tbs">
	<thead>
<tr>
<td width="82" align="center">分类ID</td>
<td  >名称</td>
<td width="97" align="center">层级</td>
 
<td width="100" align="center">表名</td>
<td width="90" align="center">排序</td>
<td width="71" align="center">状态</td>
<td width="323" align="center">操作</td>
</tr>
</thead>
<?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
  <td align="center"><?php echo $this->_var['c']['catid']; ?></td>
  <td align="left"><a href="<?php echo $this->_var['appadmin']; ?>?m=category&pid=<?php echo $this->_var['c']['catid']; ?>&tablename=<?php echo $this->_var['c']['tablename']; ?>"><?php echo $this->_var['c']['cname']; ?></a>  </td>
  <td align="center"><?php echo $this->_var['c']['level']; ?></td>
  
  <td align="center"><?php echo $this->_var['c']['tablename']; ?></td>
  <td align="center"><input type="text" class="w50 blur_update" value="<?php echo $this->_var['c']['orderindex']; ?>" size="6"   url="<?php echo $this->_var['appadmin']; ?>?m=category&a=orderindex&catid=<?php echo $this->_var['c']['catid']; ?>&tablename=<?php echo $this->_var['c']['tablename']; ?>" /></td>
  <td align="center"><?php if ($this->_var['c']['status'] == 1): ?><img class="ajax_no" src="static/images/yes.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=2" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=1" /><?php else: ?><img class="ajax_yes" src="static/images/no.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=1" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=2" /><?php endif; ?></td>
  <td align="center"> 
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&pid=<?php echo $this->_var['c']['catid']; ?>&tablename=<?php echo $this->_var['c']['tablename']; ?>" style="color:red;">添加子类</a>
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=addmore&catid=<?php echo $this->_var['c']['catid']; ?>&tablename=<?php echo $this->_var['c']['tablename']; ?>" style="color:red;">批量添加</a>  
  <br>
  
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&catid=<?php echo $this->_var['c']['catid']; ?>&tablename=<?php echo $this->_var['c']['tablename']; ?>">编辑</a> 
  <a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=delete&catid=<?php echo $this->_var['c']['catid']; ?>">删除</a></td>
</tr>
<?php if ($this->_var['c']['child']): ?>
<?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'cc');if (count($_from)):
    foreach ($_from AS $this->_var['cc']):
?>
<tr>
  <td align="center"><?php echo $this->_var['cc']['catid']; ?></td>
  <td align="left">|__<a href="<?php echo $this->_var['appadmin']; ?>?m=category&pid=<?php echo $this->_var['cc']['catid']; ?>&tablename=<?php echo $this->_var['cc']['tablename']; ?>"><?php echo $this->_var['cc']['cname']; ?></a></td>
  <td align="center"><?php echo $this->_var['cc']['level']; ?></td>
 
  <td align="center"><?php echo $this->_var['cc']['tablename']; ?></td>
  <td align="center"><input type="text" class="w50 blur_update" value="<?php echo $this->_var['cc']['orderindex']; ?>" size="6"   url="<?php echo $this->_var['appadmin']; ?>?m=category&a=orderindex&catid=<?php echo $this->_var['cc']['catid']; ?>&tablename=<?php echo $this->_var['cc']['tablename']; ?>" /></td>
  <td align="center"><?php if ($this->_var['cc']['status'] == 1): ?><img class="ajax_no" src="static/images/yes.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=2" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=1" /><?php else: ?><img class="ajax_yes" src="static/images/no.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=1" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=2" /><?php endif; ?></td>
  <td align="center">
   <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&pid=<?php echo $this->_var['cc']['catid']; ?>&tablename=<?php echo $this->_var['cc']['tablename']; ?>" style="color:red;">添加子类</a>
   <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=addmore&catid=<?php echo $this->_var['cc']['catid']; ?>&tablename=<?php echo $this->_var['cc']['tablename']; ?>" style="color:red;">批量添加</a>  
 
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&catid=<?php echo $this->_var['cc']['catid']; ?>&tablename=<?php echo $this->_var['cc']['tablename']; ?>">编辑</a>
  <a href="javascript:;" class="del" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=delete&catid=<?php echo $this->_var['cc']['catid']; ?>&tablename=<?php echo $this->_var['cc']['tablename']; ?>">删除</a>
  </td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 

<?php endif; ?>

<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
</table>

</div>

<?php echo $this->fetch('footer.html'); ?>