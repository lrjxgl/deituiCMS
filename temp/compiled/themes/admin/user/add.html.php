<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="admin.php?m=user">用户管理</a>
	<a class="item" href="admin.php?m=user&a=add">用户添加</a>
</div>
<div class="main-body"> 
<form method="post" id="form" action="<?php echo APPADMIN; ?>?m=user&a=save">
<input type="hidden" name="userid" value="<?php echo $this->_var['data']['userid']; ?>">
<table class="table-add">

<tr>
    	<td width="90">账号：</td>
        <td width=""><input type="text" name="username" value="<?php echo $this->_var['data']['username']; ?>"></td>
    </tr>
	<tr>
    	<td >昵称：</td>
        <td><input type="text" name="nickname" value="<?php echo $this->_var['data']['nickname']; ?>"></td>
    </tr>
    
     
    
    <tr>
	  <td>手机：</td>
	  <td><input name="telephone" type="text" id="telephone" value="<?php echo $this->_var['data']['telephone']; ?>"></td>
	  </tr>
	<tr>
     
    <tr>
    	<td>头像</td>
        <td>
					<div class="js-upload-item">
						<input type="file" id="upa" class="js-upload-file" style="display: none;" />
						<div class="upimg-btn js-upload-btn">+</div>
						<input type="hidden" name="user_head" class="js-imgurl" value="<?php echo $this->_var['data']['user_head']; ?>" />
						<div class="js-imgbox">
							<?php if ($this->_var['data']['user_head']): ?>
							<img src="<?php echo images_site($this->_var['data']['user_head']); ?>.100x100.jpg">
							<?php endif; ?>
						</div>
					</div>
				</td>
    </tr>
    
	 
	<tr>
	  <td>用户类型：</td>
	  <td><select name="user_type">
      	<?php $_from = $this->_var['user_type_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
        <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['user_type']): ?> selected<?php endif; ?>><?php echo $this->_var['c']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select></td>
	  </tr>
	<tr>
	  <td>账户状态：</td>
	  <td><select name="status">
      	<option  value="99" <?php if ($this->_var['data']['status'] == 99): ?> selected<?php endif; ?>>已禁止</option>
      	<option value="1" <?php if ($this->_var['data']['status'] == 1): ?> selected<?php endif; ?>>已通过</option>
        <option value="10"  <?php if ($this->_var['data']['status'] == 10): ?> selected<?php endif; ?>>待审核</option>
      </select></td>
	  </tr>
 
 
    
</table>
<div class="btn-row-submit js-submit">保存</div>
</form>

</div>
<?php echo $this->fetch('footer.html'); ?>
<script src="<?php echo $this->_var['skins']; ?>js/upload.js"></script>
</body>
</html>