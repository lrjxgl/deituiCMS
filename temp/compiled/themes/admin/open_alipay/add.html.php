<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('open_alipay/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="admin.php?m=open_alipay&a=save">
				<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
				<table class="table-add">
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>
					<?php if ($this->_var['data']): ?>
					<tr>
						<td>创建时间：</td>
						<td><?php echo $this->_var['data']['createtime']; ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>appid：</td>
						<td><input type="text" name="appid" id="appid" value="<?php echo $this->_var['data']['appid']; ?>"></td>
					</tr>
					<tr>
							<td>merchant_private_key</td>
							<td><input type="text" name="merchant_private_key" value="<?php echo $this->_var['data']['merchant_private_key']; ?>" /> </td>
					</tr>	
					 
					<tr>
						<td>appcert_path</td>
						<td>
							<div class="btn-upload-item" url="/index.php?m=upload&a=uploadCert&ajax=1">
								<div class="btn-upload js-upload-file-btn">+</div>
								<input type="file" id="upfile-a" class="btn-upload-file" name="upfile" />
								<div class="btn-upload-text"><?php echo $this->_var['data']['appcert_path']; ?></div>
								<input type="hidden" class="btn-upload-input" name="appcert_path" value="<?php echo $this->_var['data']['appcert_path']; ?>" />
							</div>
						</td>
					</tr>
					<tr>
						<td>alicert_path</td>
						<td>
							<div class="btn-upload-item" url="/index.php?m=upload&a=uploadCert&ajax=1">
								<div class="btn-upload js-upload-file-btn">+</div>
								<input type="file" id="upfile-b" class="btn-upload-file" name="upfile" />
								<div class="btn-upload-text"><?php echo $this->_var['data']['alicert_path']; ?></div>
								<input type="hidden" class="btn-upload-input" name="alicert_path" value="<?php echo $this->_var['data']['alicert_path']; ?>" />
							</div>
						</td>
					</tr>
						<tr>
							<td>rootcert_path</td>
							<td>
								<div class="btn-upload-item" url="/index.php?m=upload&a=uploadCert&ajax=1">
									<div class="btn-upload js-upload-file-btn">+</div>
									<input type="file" id="upfile-c" class="btn-upload-file" name="upfile" />
									<div class="btn-upload-text"><?php echo $this->_var['data']['rootcert_path']; ?></div>
									<input type="hidden" class="btn-upload-input" name="rootcert_path" value="<?php echo $this->_var['data']['rootcert_path']; ?>" />
								</div>
							</td>
						</tr>
					<tr>
						<td>状态：</td>
						<td>
							<input type="radio" name="status" value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked <?php endif; ?> /> 上线
							<input type="radio" name="status" value="0" <?php if ($this->_var['data']['status'] != 1): ?> checked <?php endif; ?> /> 下线
						</td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/static/admin/js/upload.js"> </script>
	</body>
</html>
