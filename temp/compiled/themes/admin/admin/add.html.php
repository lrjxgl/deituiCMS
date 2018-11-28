<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a href="/admin.php?m=admin" class="item">管理员列表</a>
		<a href="/admin.php?m=admin&a=add" class="item active">添加</a>
	</div>
<div class="main-body">
<form action="<?php echo $this->_var['appadmin']; ?>?m=admin&a=save" method="post" autocomplete="off">
<table class="table-add">
  <tr>
    <td>管理员：</td>
    <td ><input name="username" type="text" id="username" value="<?php echo $this->_var['data']['username']; ?>" size="40" /></td>
  </tr>
   
  
  <tr>
    <td>密码：</td>
    <td><input name="password" type="password" id="password" size="40" /></td>
  </tr>
  <tr>
    <td >确认密码：</td>
    <td><input name="password2" type="password" id="password2" size="40" /></td>
  </tr>
  
  
  <tr>
    <td >所属组：</td>
    <td><select name="group_id" id="group_id">
    <?php $_from = $this->_var['grouplist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'z');if (count($_from)):
    foreach ($_from AS $this->_var['z']):
?>
    <option value="<?php echo $this->_var['z']['id']; ?>" <?php if ($this->_var['data']['groupid'] == $this->_var['z']['id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['z']['title']; ?></option>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </select></td>
  </tr>
   
   
</table>
<div class="btn-row-submit js-submit">保存</div> 
</form>
</div> 
<?php echo $this->fetch('footer.html'); ?>