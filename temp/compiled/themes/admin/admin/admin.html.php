<?php echo $this->fetch('header.html'); ?>
<?php echo $this->fetch('admin/admin_nav.html'); ?>

<div class="rbox">
<form method="get" action="<?php echo $this->_var['appadmin']; ?>">
<input type="hidden" name="m" value="admin" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered">
  <tr>
    <td width="246" height="30" align="right">用户名:&nbsp;</td>
    <td width="179" align="left"><input type="text" name="adminname" id="adminname" value="<?php echo $_GET['adminname']; ?>" /></td>
    <td width="315" align="left"><input type="submit" name="button" id="button" valuse="快速搜索" class="btn" /></td>
    </tr>
  </table>

</form>

<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table table-bordered">
  <tr>
    <td width="92" height="30" align="center">ID</td>
    <td width="231" align="center">用户名</td>
    <td width="213" align="center">所数组</td>
    <td width="204" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['adminlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['id']; ?></td>
    <td align="center"><?php echo $this->_var['t']['username']; ?></td>
    <td align="center"><?php echo $this->_var['grouplist'][$this->_var['t']['group_id']]; ?></td>
    <td align="center"><a href="<?php echo $this->_var['appadmin']; ?>?m=admin&a=edit&id=<?php echo $this->_var['t']['id']; ?>">编辑</a> <?php if (! $this->_var['t']['isfounder']): ?><a href="javascript:;" class="delete" url="<?php echo $this->_var['appadmin']; ?>?m=admin&a=del&id=<?php echo $this->_var['t']['id']; ?>">删除</a><?php endif; ?></td>
  </tr><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="25" colspan="8" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
<?php endif; ?>
  
</table>


</div> 
<?php echo $this->fetch('footer.html'); ?>