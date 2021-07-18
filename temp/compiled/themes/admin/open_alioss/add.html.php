<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('open_alioss/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="admin.php?m=open_alioss&a=save">
				<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
				<table class="table-add">
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>
					<tr>
						<td>类型：</td>
						<td><input type="radio" name="apptype" id="apptype" value="oss" checked>oss</td>
					</tr>
					<?php if ($this->_var['data']): ?>
					<tr>
						<td>创建时间：</td>
						<td><?php echo $this->_var['data']['createtime']; ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>ACCESS_ID：</td>
						<td><input type="text" name="appid" id="appid" value="<?php echo $this->_var['data']['appid']; ?>"></td>
					</tr>
					<tr>
						<td>ACCESS_KEY：</td>
						<td><input type="text" name="appkey" id="appkey" value="<?php echo $this->_var['data']['appkey']; ?>"></td>
					</tr>
					<tr>
						<td>ENDPOINT：</td>
						<td><input type="text" name="endpoint" id="endpoint" value="<?php echo $this->_var['data']['endpoint']; ?>"></td>
					</tr>
					<tr>
						<td>BUCKET：</td>
						<td><input type="text" name="bucket" id="bucket" value="<?php echo $this->_var['data']['bucket']; ?>"></td>
					</tr>
					<tr>
								<td>状态：</td>		
								<td>
										<input type="radio" name="status"  value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked <?php endif; ?> >上线
										<input type="radio" name="status"  value="0"  <?php if ($this->_var['data']['status'] == 0): ?> checked <?php endif; ?> >下线
								
								</td>
								</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
