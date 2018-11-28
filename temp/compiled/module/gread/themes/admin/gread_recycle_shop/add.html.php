<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('gread_recycle_shop/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="/moduleadmin.php?m=gread_recycle_shop&a=save">
				<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
				<table class="table-add">
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>

					<tr>
						<td>图片：</td>
						<td>
							<div class="js-upload-item">
								<input type="file" id="upa" class="js-upload-file" style="display: none;" />
								<div class="upimg-btn js-upload-btn">+</div>
								<input type="hidden" name="imgurl" class="js-imgurl" value="<?php echo $this->_var['data']['imgurl']; ?>" />
								<div class="js-imgbox">
									<?php if ($this->_var['data']['imgurl']): ?>
									<img src="<?php echo images_site($this->_var['data']['imgurl']); ?>.100x100.jpg">
									<?php endif; ?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>店主：</td>
						<td><input type="text" name="nickname" id="nickname" value="<?php echo $this->_var['data']['nickname']; ?>"></td>
					</tr>
					<tr>
						<td>手机：</td>
						<td><input type="text" name="telephone" id="telephone" value="<?php echo $this->_var['data']['telephone']; ?>"></td>
					</tr>
					<tr>
						<td>地址：</td>
						<td><input type="text" name="address" id="address" value="<?php echo $this->_var['data']['address']; ?>"></td>
					</tr>

					<tr>
						<td>lat：</td>
						<td><input type="text" name="lat" id="lat" value="<?php echo $this->_var['data']['lat']; ?>"></td>
					</tr>
					<tr>
						<td>lng：</td>
						<td><input type="text" name="lng" id="lng" value="<?php echo $this->_var['data']['lng']; ?>"></td>
					</tr>
					<tr>

					<tr>
						<td>简介：</td>
						<td><textarea name="description" id="description" ><?php echo $this->_var['data']['description']; ?></textarea></td>
					</tr>
					<?php if ($this->_var['data']): ?>
					<tr>
						<td>创建时间：</td>
						<td><?php echo $this->_var['data']['createtime']; ?></td>
					</tr>
					<?php endif; ?>
					<td>状态：</td>
					<td><input type="text" name="status" id="status" value="<?php echo $this->_var['data']['status']; ?>"></td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/static/admin/js/upload.js"></script>
	</body>
</html>
