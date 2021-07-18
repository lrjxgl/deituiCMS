<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('im_group/nav.html'); ?>
		<div class="main-body">
			<form method="post" action="/moduleadmin.php?m=im_group&a=save">
				<input type="hidden" name="groupid" style="display:none;" value="<?php echo $this->_var['data']['groupid']; ?>">
				<table class="table-add">
					<tr>
						<td>名称：</td>
						<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
					</tr>
					<tr>
						<td>类型</td>
						<td>
							<select name="typeid">
								<option value="0">请选择</option>
								<?php $_from = $this->_var['typeList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
								<option <?php if ($this->_var['data']['typeid'] == $this->_var['c']['id']): ?>selected<?php endif; ?> value="<?php echo $this->_var['c']['id']; ?>"><?php echo $this->_var['c']['title']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select>
						</td>
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
						<td>描述：</td>
						<td><input type="text" name="description" id="description" value="<?php echo $this->_var['data']['description']; ?>"></td>
					</tr>
					<?php if ($this->_var['data']): ?>
					<tr>
						<td>创建时间：</td>
						<td><input type="text" name="createtime" id="createtime" value="<?php echo $this->_var['data']['createtime']; ?>"></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>状态：</td>
						<td>
							<input type="radio" <?php if ($this->_var['data']['status'] == 1): ?>checked<?php endif; ?> name="status"   value="1">上线
							<input type="radio" <?php if ($this->_var['data']['status'] != 1): ?>checked<?php endif; ?> name="status"   value="2">下线
						</td>
					</tr>
					<tr>
						<td>加入：</td>
						<td>
							<input type="radio" <?php if ($this->_var['data']['need_join'] == 1): ?>checked<?php endif; ?> name="need_join"   value="1">需要
							<input type="radio" <?php if ($this->_var['data']['need_join'] != 1): ?>checked<?php endif; ?> name="need_join"   value="2">不用
						</td>
					</tr> 
				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/static/admin/js/upload.js"></script>
	</body>
</html>
