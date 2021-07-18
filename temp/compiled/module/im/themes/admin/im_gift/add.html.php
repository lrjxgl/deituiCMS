<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('im_gift/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="/moduleadmin.php?m=im_gift&a=save">
				<input type="hidden" name="giftid" style="display:none;" value="<?php echo $this->_var['data']['giftid']; ?>">
				<table class="table-add">
					 
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>
					<tr>
						<td>介绍：</td>
						<td><input type="text" name="description" id="description" value="<?php echo $this->_var['data']['description']; ?>"></td>
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
						<td>状态：</td>
						<td>
							<input type="radio" <?php if ($this->_var['data']['status'] == 1): ?>checked<?php endif; ?> name="status"   value="1">上线
							<input type="radio" <?php if ($this->_var['data']['status'] == 2): ?>checked<?php endif; ?> name="status"   value="2">下线
						</td>
					</tr> 
					<tr>
						<td>推荐：</td>
						<td>
							<input type="radio" <?php if ($this->_var['data']['isrecommend'] == 1): ?>checked<?php endif; ?> name="isrecommend"   value="1">是
							<input type="radio" <?php if ($this->_var['data']['isrecommend'] == 2): ?>checked<?php endif; ?> name="isrecommend"   value="2">否
						</td>
					</tr>
					<tr>
						<td>价格：</td>
						<td><input type="text" name="price" id="price" value="<?php echo $this->_var['data']['price']; ?>"></td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/static/admin/js/upload.js"></script>
	</body>
</html>
