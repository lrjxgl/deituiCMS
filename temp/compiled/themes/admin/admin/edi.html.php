<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a href="/admin.php?m=admin" class="item">管理员列表</a>
		<a href="/admin.php?m=admin&a=add" class="item">添加</a>
		<a class="item  active">编辑</a>
	</div>
<div class="main-body">
<form action="<?php echo $this->_var['appadmin']; ?>?m=admin&a=edit&op=db&id=<?php echo $this->_var['data']['id']; ?>" method="post" autocomplete="off">
<table class="table-add">
  <tr>
    <td  align="right">用户名：</td>
    <td  ><input name="adminname" type="text" id="adminname" value="<?php echo $this->_var['data']['username']; ?>" size="40" readonly /></td>
  </tr>
  <tr>
    <td  align="right">密码：</td>
    <td><input name="password" type="password" id="pwd1" size="40" /></td>
  </tr>
  <tr>
    <td  align="right">确认密码：</td>
    <td><input name="password2" type="password" id="pwd2" size="40" /></td>
  </tr>
  
    <tr>
    <td  align="right">所属组：</td>
    <td><select name="group_id" id="zuid">
    <?php $_from = $this->_var['grouplist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'z');if (count($_from)):
    foreach ($_from AS $this->_var['z']):
?>
    <option value="<?php echo $this->_var['z']['id']; ?>" <?php if ($this->_var['data']['group_id'] == $this->_var['z']['id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['z']['title']; ?></option>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </select></td>
  </tr>
  
  
  
  
</table>
	<div class="btn-row-submit js-submit">保存</div> 
</form>
</div> 

<?php echo $this->fetch('footer.html'); ?>
</boody>
</html>