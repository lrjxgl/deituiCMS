<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="admin.php?m=user">用户管理</a>
	<a class="item" href="admin.php?m=user&a=add">用户添加</a>
</div>
<div class="main-body"> 
<form method="post" id="form" action="/admin.php?m=user&a=passwordsave">
<input type="hidden" name="userid" value="<?php echo $this->_var['data']['userid']; ?>">
<table class="table-add">

<tr>
    	<td width="90">账号：</td>
        <td width=""><?php echo $this->_var['data']['username']; ?></td>
    </tr>
	<tr>
    	<td >密码：</td>
        <td><input type="text" name="password" value="<?php echo $this->_var['data']['password']; ?>"></td>
    </tr>
    
     
    
    <tr>
	  <td>重复密码：</td>
	  <td><input name="password2" type="text"  value="<?php echo $this->_var['data']['password2']; ?>"></td>
	  </tr>
	<tr>
 
 
 
    
</table>
<div class="btn-row-submit js-submit">保存</div>
</form>

</div>
<?php echo $this->fetch('footer.html'); ?>
 
</body>
</html>