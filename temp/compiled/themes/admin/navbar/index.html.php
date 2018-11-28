<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a href="<?php echo $this->_var['appadmin']; ?>?m=navbar" class="active item">导航管理</a>
		<a href="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=add" class="item">导航添加</a>
	</div>
 

<div class="main-body">
	<div class="tabs-border" > 
	<?php $_from = $this->_var['group_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['g']):
?>
	<a href="<?php echo $this->_var['appadmin']; ?>?m=navbar&group_id=<?php echo $this->_var['k']; ?>" class="item <?php if ($this->_var['group_id'] == $this->_var['k']): ?>active<?php endif; ?>"><?php echo $this->_var['g']; ?></a>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	
	</div>
<form action="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=order" method="post">
<table class="tbs">
	<thead>
  <tr>
    <td width="5%" align="center">ID</td>
    <td width="10%" align="center">名称</td>
    <td width="5%">状态</td>
    <td width="4%" align="center">m</td>
    <td width="4%" align="center">a</td>
    <td width="10%" height="30" align="center">位置</td>
    <td width="7%" align="center">目标</td>
    
    <td width="7%" height="30" align="center">排序</td>
    <td width="16%" height="30" align="center">操作</td>
  </tr>
	</thead>
  <?php $_from = $this->_var['navlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['t']['id']; ?></td>
  <td align="left"><a href="<?php echo $this->_var['t']['link_url']; ?>" target="_blank"><?php echo $this->_var['t']['title']; ?></a></td>
  <td><?php if ($this->_var['t']['status'] == 1): ?>
   <img src='/static/admin/img/yes.gif' class="ajax_no" url='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=0' rurl='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=1'>
    <?php else: ?>
    <img src='/static/admin/img/no.gif' class="ajax_yes" url='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=1' rurl='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=0'>
    <?php endif; ?></td>
  <td align="center"><?php echo $this->_var['t']['m']; ?></td>
  <td align="center"><?php echo $this->_var['t']['a']; ?></td>
    <td height="25" align="center"><?php echo $this->_var['group_list'][$this->_var['t']['group_id']]; ?></td>
    <td align="center"><?php echo $this->_var['t']['target']; ?></td>
    <input type="hidden" name="id[]" value="<?php echo $this->_var['t']['id']; ?>" />
    <td height="25" align="center"><input name="orderindex[]" type="text" value="<?php echo $this->_var['t']['orderindex']; ?>" class="input-small" /></td>
    <td height="25" align="center">
    <a href="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=add&pid=<?php echo $this->_var['t']['id']; ?>" >添加</a>
    <a href="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=add&id=<?php echo $this->_var['t']['id']; ?>">编辑</a> 
    <a href="javascript:;"  url="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=delete&id=<?php echo $this->_var['t']['id']; ?>" class="js-delete" >删除</a></td>
  </tr>
  <?php if ($this->_var['t']['child']): ?>
  <?php $_from = $this->_var['t']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
    <tr>
      <td align="center"><?php echo $this->_var['c']['id']; ?></td>
  <td align="left">|__<a href="<?php echo $this->_var['c']['link_url']; ?>" target="_blank"><?php echo $this->_var['c']['title']; ?></a> </td>
  <td><?php if ($this->_var['c']['status'] == 1): ?>
   <img src='/static/admin/img/yes.gif' class="ajax_no" url='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=0' rurl='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=1'>
    <?php else: ?>
    <img src='/static/admin/img/no.gif' class="ajax_yes" url='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=1' rurl='<?php echo $this->_var['appadmin']; ?>?m=navbar&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=0'>
    <?php endif; ?></td>
  <td align="center"><?php echo $this->_var['c']['m']; ?></td>
  <td align="center"><?php echo $this->_var['c']['a']; ?></td>
    <td height="25" align="center"><?php echo $this->_var['group_list'][$this->_var['c']['group_id']]; ?></td>
    <td align="center"><?php if ($this->_var['c']['target'] == '_blank'): ?><?php echo $this->_var['lang']['_blank']; ?><?php else: ?><?php echo $this->_var['lang']['_self']; ?><?php endif; ?></td>
    <input type="hidden" name="id[]" value="<?php echo $this->_var['c']['id']; ?>" />
    
    <td height="25" align="center"><input name="orderindex[]" type="text" value="<?php echo $this->_var['c']['orderindex']; ?>"  class="input-small" /></td>
    <td height="25" align="center">
    <a href="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
    <a href="javascript:;"  url="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=delete&id=<?php echo $this->_var['c']['id']; ?>" class="js-delete" >删除</a>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
 
</table>
<div class="pd-10 clearfix">
	<div class="btn js-submit fr" >更改排序</div>
</div>
 

</form>
</div>

<?php echo $this->fetch('footer.html'); ?>
</body>
</html>