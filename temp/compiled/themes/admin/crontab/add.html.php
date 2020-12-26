<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('crontab/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="admin.php?m=crontab&a=save">
				<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
				<table class="table-add">
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>
					<tr>
						<td>任务地址：</td>
						<td><input type="text" name="url" id="url" value="<?php echo $this->_var['data']['url']; ?>"></td>
					</tr>
					<tr>
						<td>执行时间：</td>
						<td><input type="text" name="crontime" id="crontime" value="<?php echo $this->_var['data']['crontime']; ?>"></td>
					</tr>
					<tr>
						<td>状态：</td>
						<td>
							<input type="radio" <?php if ($this->_var['data']['status'] == 1): ?>checked<?php endif; ?> name="status" value="1"> 在线
							<input type="radio"  <?php if ($this->_var['data']['status'] != 1): ?>checked<?php endif; ?> name="status" value="2"> 下线
						</td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
