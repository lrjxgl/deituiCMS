<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('weixin/nav.html'); ?>
<div class="main-body">
	<form method='post' action='/admin.php?m=weixin&a=save'>
		<input type='hidden' name='id' style='display:none;' value='<?php echo $this->_var['data']['id']; ?>'>
		<table class="table-add">
			<col style="width: 100px;" />
			<tr>
				<td>微信名：</td>
				<td><input type='text' name='title' id='title' value='<?php echo $this->_var['data']['title']; ?>'></td>
			</tr>
			<tr>
				<td>微信token：</td>
				<td><input type='text' name='token' id='token' value='<?php echo $this->_var['data']['token']; ?>'></td>
			</tr>
			
			 

			<tr>
				<td>状态：</td>
				<td> 验证
					<input type="radio" name="status" value="0" <?php if ($this->_var['data']['status'] != 1): ?> checked="checked" <?php endif; ?> />
					运营
					<input type="radio" name="status" value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked="checked" <?php endif; ?> /></td>
			</tr>

			<tr>
				<td>appId</td>
				<td><input type="text" name="appid" value="<?php echo $this->_var['data']['appid']; ?>" /></td>
			</tr>

			<tr>
				<td>appSecert</td>
				<td><input type="text" name="appkey" value="<?php echo $this->_var['data']['appkey']; ?>" /></td>
			</tr>

			<tr>
				<td>enKey</td>
				<td><input type="text" name="enkey" value="<?php echo $this->_var['data']['enkey']; ?>" /></td>
			</tr>
			<tr>
				<td>mchid</td>
				<td><input type="text" name="mchid" value="<?php echo $this->_var['data']['mchid']; ?>" /></td>
			</tr>
			<tr>
				<td>mchkey</td>
				<td><input type="text" name="mchkey" value="<?php echo $this->_var['data']['mchkey']; ?>" /></td>
			</tr>
			<tr>
				<td>sslcert_path</td>
				<td>
					<div class="btn-upload-item" url="/index.php?m=upload&a=uploadCert&ajax=1">
						<div class="btn-upload js-upload-file-btn">+</div>
						<input type="file" id="upfile-a" class="btn-upload-file" name="upfile" />
						<div class="btn-upload-text"><?php echo $this->_var['data']['sslcert_path']; ?></div>
						<input type="hidden" class="btn-upload-input" name="sslcert_path" value="<?php echo $this->_var['data']['sslcert_path']; ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<td>sslkey_path</td>
				<td>
					<div class="btn-upload-item" url="/index.php?m=upload&a=uploadCert&ajax=1">
						<div class="btn-upload js-upload-file-btn">+</div>
						<input type="file" id="upfile-b" class="btn-upload-file" name="upfile" />
						<div class="btn-upload-text"><?php echo $this->_var['data']['sslkey_path']; ?></div>
						<input type="hidden" class="btn-upload-input" name="sslkey_path" value="<?php echo $this->_var['data']['sslkey_path']; ?>" />
					</div>
				</td>
			</tr>

			<?php if ($this->_var['data']['dateline']): ?>
			<tr>
				<td>添加时间：</td>
				<td><?php echo date("Y-m-d H:i:s",$this->_var['data']['dateline']); ?></td>
			</tr>
			<?php endif; ?>
			 
 
		</table>
		<div class="btn-row-submit js-submit">保存</div>
	</form>
</div>


 
<?php echo $this->fetch('footer.html'); ?>
<script src="<?php echo $this->_var['skins']; ?>js/upload.js"> </script>
</body>
</html>