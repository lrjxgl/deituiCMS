<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('table/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="admin.php?m=table&a=save">
				<input type="hidden" name="tableid" style="display:none;" value="<?php echo $this->_var['data']['tableid']; ?>">
				<table class="table-add">
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>
					<tr>
						<td>表名称：</td>
						<td><input type="text" name="tablename" id="tablename" value="<?php echo $this->_var['data']['tablename']; ?>"></td>
					</tr>
					<tr>
						<td>描述：</td>
						<td><input type="text" name="description" id="description" value="<?php echo $this->_var['data']['description']; ?>"></td>
					</tr>
					<tr>
						<td>状态</td>
						<td>
							<input type="radio" name="status" <?php if ($this->_var['data']['status'] == 1): ?> checked<?php endif; ?> value="1" />显示
							
							<input type="radio" name="status" <?php if ($this->_var['data']['status'] != 1): ?> checked<?php endif; ?>  value="2" />隐藏
						</td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
