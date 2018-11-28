<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('imgdiy/nav.html'); ?>
		<div class="main-body">
		<form method="post" action="/moduleadmin.php?m=imgdiy&a=save">
			<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
			<table class="table-add">
				
				<tr>
					<td>名称：</td>
					<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
				</tr>
				<tr>
					<td>描述：</td>
					<td><input type="text" name="description" id="description" value="<?php echo $this->_var['data']['description']; ?>"></td>
				</tr>
			 
				<tr>
					<td>状态：</td>
					<td><input type="text" name="status" id="status" value="<?php echo $this->_var['data']['status']; ?>"></td>
				</tr>
				
			</table>
			<div class="btn-row-submit js-submit">保存</div>
		</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
