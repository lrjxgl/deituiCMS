<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
	 
		<div class="tabs-border">
			<div class="item active">银行卡设置</div>
		</div>
		<div class="main-body">
			<form action="/admin.php?m=config&a=save&ajax=1">
				<table class="table-add">
					<tr>
						<td>银行名称</td>
						<td>
							<input type="text" name="s_bank_name" value="<?php echo $this->_var['data']['s_bank_name']; ?>" />
						</td>
					</tr>
					<tr>
						<td>银行用户</td>
						<td>
							<input type="text" name="s_bank_user" value="<?php echo $this->_var['data']['s_bank_user']; ?>" />
						</td>
					</tr>
					<tr>
						<td>银行账号</td>
						<td>
							<input type="text" name="s_bank_num" value="<?php echo $this->_var['data']['s_bank_num']; ?>" />
						</td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit" >保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
