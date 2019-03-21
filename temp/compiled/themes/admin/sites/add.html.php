<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a href="<?php echo $this->_var['appadmin']; ?>?m=sites" class="item active">网站信息</a>
</div>

<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=sites&a=save">
	<input type="hidden" name="siteid" value="<?php echo $this->_var['data']['siteid']; ?>" />
	<table class="table-add">
		<col style="width: 90px;" />
		<tr>
			<td  align="right">网站名称：</td>
			<td  ><input name="sitename" type="text" id="sitename" value="<?php echo $this->_var['data']['sitename']; ?>" /></td>
		</tr>
		<tr>
			<td align="right">域名：</td>
			<td><input name="domain" type="text" id="domain" value="<?php echo $this->_var['data']['domain']; ?>" /></td>
		</tr>

		<tr>
			<td align="right">logo：</td>
			<td>
				<div class="js-upload-item">
					<input type="file" id="upa" class="js-upload-file" style="display: none;" />
					<div class="upimg-btn js-upload-btn">+</div>
					<input type="hidden" name="logo" class="js-imgurl" value="<?php echo $this->_var['data']['logo']; ?>" />
					<div class="js-imgbox">
						<?php if ($this->_var['data']['logo']): ?>
						<img src="<?php echo images_site($this->_var['data']['logo']); ?>.100x100.jpg">
						<?php endif; ?>
					</div>
				</div>
			</td>
		</tr>

		 

		<tr>
			<td align="right">关站：</td>
			<td><input type="radio" name="is_open" id="radio" value="1" <?php if ($this->_var['data']['is_open'] == 1): ?> checked="checked" <?php endif; ?> /> 开启
				<input type="radio" name="is_open" id="radio2" value="2" <?php if ($this->_var['data']['is_open'] == 2): ?> checked="checked" <?php endif; ?> /> 关闭
			</td>
		</tr>
		<tr>
			<td align="right">关站原因：</td>
			<td><textarea name="close_why" id="close_why" cols="45" rows="5"><?php echo $this->_var['data']['close_why']; ?></textarea></td>
		</tr>
		<tr>
			<td align="right">标题：</td>
			<td><input name="title" type="text" id="title" value="<?php echo $this->_var['data']['title']; ?>" class="w600" /></td>
		</tr>
		<tr>
			<td align="right">关键字：</td>
			<td><input name="keywords" type="text" id="keywords" value="<?php echo $this->_var['data']['keywords']; ?>" class="w600" /></td>
		</tr>
		<tr>
			<td align="right">描述：</td>
			<td><textarea name="description" id="description" cols="45" rows="5"><?php echo $this->_var['data']['description']; ?></textarea></td>
		</tr>
		<tr>
			<td align="right">icp：</td>
			<td><input name="icp" type="text" id="icp" value="<?php echo $this->_var['data']['icp']; ?>" /></td>
		</tr>
	 
		<tr>
			<td align="right">统计代码：</td>
			<td><textarea name="statjs" cols="45" rows="5" id="statjs"><?php echo $this->_var['data']['statjs']; ?></textarea></td>
		</tr>
		 
	 
	</table>
	<div class="btn-row-submit js-submit" ungo="1">保存</div>
</form>
 

<?php echo $this->fetch('footer.html'); ?>
<script src="/static/admin/js/upload.js"> </script>
</body>
</html>