<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<a href="#" class="item active">直播设置</a>
		</div>
		<form method="post" action="/moduleadmin.php?m=zblive_config&a=save">

			<table class="table table-bordered">
				

				<tr>
					<td>AccessKeyId</td>
					<td>
						<input type="text" class="w98" name="AccessKeyId" value="<?php echo $this->_var['data']['AccessKeyId']; ?>" />
					</td>
				</tr>

				<tr>
					<td>AccessKeyKey</td>
					<td>
						<input type="text" class="w98" name="AccessKeyKey" value="<?php echo $this->_var['data']['AccessKeyKey']; ?>" />
					</td>
				</tr>
				<tr>
					<td>AppName</td>
					<td>
						<input type="text" class="w98" name="zbappname" value="<?php echo $this->_var['data']['zbappname']; ?>" />
					</td>
				</tr>
				<tr>
					<td width="100">推流地址</td>
					<td>
						<input type="text" class="w98" name="zbrtmp" value="<?php echo $this->_var['data']['zbrtmp']; ?>" />
					</td>
				
				</tr>
				<tr>
					<td width="100">推流密钥</td>
					<td>
						<input type="text" class="w98" name="zbrtmp_key" value="<?php echo $this->_var['data']['zbrtmp_key']; ?>" />
					</td>
				
				</tr>
				<tr>
					<td>直播服务器</td>
					<td>
						<input type="text" class="w98" name="zbvhost" value="<?php echo $this->_var['data']['zbvhost']; ?>" />
					</td>

				</tr>
				
				<tr>
					<td>直播路径</td>
					<td>
						<input type="text" class="w98" name="zbpath" value="<?php echo $this->_var['data']['zbpath']; ?>" />
					</td>

				</tr>
				<tr>
					<td>直播Key</td>
					<td>
						<input type="text" class="w98" name="zbkey" value="<?php echo $this->_var['data']['zbkey']; ?>" />
					</td>
				</tr>

				<tr>
					<td>录播地址</td>
					<td>
						<input type="text" name="backhost" value="<?php echo $this->_var['data']['backhost']; ?>" class="w98" />
					</td>
				</tr>
				<tr>
					<td>wsHost</td>
					<td>
						<input type="text" name="wshost" value="<?php echo $this->_var['data']['wshost']; ?>" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="保存" class="btn btn-success"></td>
				</tr>
			</table>
		</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>

	</body>
</html>
