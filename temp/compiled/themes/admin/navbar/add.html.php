<!DOCTYPE  html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
	<div class="tabs-border">
		<a href="<?php echo $this->_var['appadmin']; ?>?m=navbar" class="item">导航管理</a>
		<a href="<?php echo $this->_var['appadmin']; ?>?m=navbar&a=add" class="item active">导航添加</a>
	</div>
		<div class="main-body">
			<form action="admin.php?m=navbar&a=save" method="post">
				<input type="hidden" name="id" value="<?php echo $this->_var['nav']['id']; ?>">
				<table class="table-add">


					<?php if (! $this->_var['parent']): ?>
					<tr>
						<td height="30" align="right">跳转目标：</td>
						<td><select name="target" id="target">
								<option value="_self">self</option>
								<option value="_blank" <?php if ($this->_var['nav']['target'] == '_blank'): ?> selected="selected" <?php endif; ?>>_blank </option> </select> </td>
								 </tr> <?php endif; ?> <?php if ($this->_var['parent']): ?> <tr>
						<td width="16%" height="30" align="right">上级分类：</td>
						<td width="84%">
							<input type="hidden" name="pid" value="<?php echo $this->_var['parent']['id']; ?>">
							<?php echo $this->_var['parent']['title']; ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td height="30" align="right">名称：</td>
						<td><input name="title" type="text" value="<?php echo $this->_var['nav']['title']; ?>" />

					</tr>
					<tr>
						<td height="30" align="right">链接：</td>
						<td><input name="link_url" type="text" id="link_url" value="<?php echo $this->_var['nav']['link_url']; ?>" size="40" /></td>
					</tr>
					<?php if (! $this->_var['parent']): ?>
					<tr>
						<td height="30" align="right">位置：</td>
						<td><select name="group_id" id="group_id">
								<?php $_from = $this->_var['group_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['g']):
?>
								<option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['nav']['group_id']): ?> selected<?php endif; ?>><?php echo $this->_var['g']; ?> </option> <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </select> </td> </tr> <?php endif; ?>
					<tr>
						<td align="right">Icon：</td>
						<td>
							<input type="text" name="icon" value="<?php echo $this->_var['nav']['icon']; ?>" />
						</td>
					</tr>			
					<tr>
						<td align="right">图标：</td>
						<td>
							<div class="js-upload-item">
								<input type="file" id="upa" class="js-upload-file" style="display: none;" />
								<div class="upimg-btn js-upload-btn">+</div>
								<input type="hidden" name="logo" class="js-imgurl" value="<?php echo $this->_var['nav']['logo']; ?>" />
								<div class="js-imgbox">
									<?php if ($this->_var['nav']['logo']): ?>
									<img src="<?php echo images_site($this->_var['nav']['logo']); ?>.100x100.jpg">
									<?php endif; ?>
								</div>
							</div>
							
							 
						</td>
					</tr>

					<tr>
						<td height="30" align="right">m： </td>
						<td><input name="m" type="text" id="m" value="<?php echo $this->_var['nav']['m']; ?>" /></td>
					</tr>
					<tr>
						<td height="30" align="right">a：</td>
						<td><input name="a" type="text" id="a" value="<?php echo $this->_var['nav']['a']; ?>" /></td>
					</tr>
					<tr>
						<td height="30" align="right">排序：</td>
						<td><input name="orderindex" type="text" id="orderindex" value="<?php echo $this->_var['nav']['orderindex']; ?>" /></td>
					</tr>

				</table>
				<div class="btn-row-submit js-submit">保存</div>

			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/static/admin/js/upload.js"></script>
	</body>
</html>
