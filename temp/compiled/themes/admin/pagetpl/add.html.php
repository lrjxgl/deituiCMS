<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a class="item" href="?m=pagetpl">模板列表</a>
	<a class="item active" href="?m=pagetpl&a=add">模板添加</a>
</div> 
<div class="main-body">
	<form method="post" action="admin.php?m=pagetpl&a=save">
		<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
		<table class="table table-bordered">
			<tr>
				<td width="100">m：</td>
				<td><input type="text" name="m" id="m" value="<?php echo $this->_var['data']['m']; ?>"></td>
			</tr>
			<tr>
				<td>a：</td>
				<td><input type="text" name="a" id="a" value="<?php echo $this->_var['data']['a']; ?>"></td>
			</tr>
			<tr>
				<td>tpl：</td>
				<td><input type="text" name="tpl" id="tpl" value="<?php echo $this->_var['data']['tpl']; ?>"></td>
			</tr>
			 
		</table>
		<div class="btn-row-submit js-submit">保存</div>
	</form>
</div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>