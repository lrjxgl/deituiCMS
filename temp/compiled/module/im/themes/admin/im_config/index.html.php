<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div class="item active">基本设置</div>
		</div>
		<div class="main-body">
			<form action="/moduleadmin.php?m=im_config&a=save&ajax=1">
				<table class="table-add">
					<tr>
						<td>wsHost</td>
						<td>
							<input type="text" name="wsHost" value="<?php echo $this->_var['data']['wsHost']; ?>" />
						</td>
					</tr>
					<tr>
						<td>机器人</td>
						<td>
							<input  type="text" name="aiusers" value="<?php echo $this->_var['data']['aiusers']; ?>" />(用英文,隔开)
						</td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
