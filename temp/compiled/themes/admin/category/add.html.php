<!DOCTYPE  html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<a class="item active" href="/admin.php?m=category">分类列表</a>
			<a class="item" href="/admin.php?m=category&a=add">添加</a>
		</div>
		<div class="main-body">


			<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=category&a=save">
				<input type="hidden" name="catid" value="<?php echo $this->_var['data']['catid']; ?>">
				<?php if ($this->_var['parent']): ?>
				<input type="hidden" name="pid" value="<?php echo $this->_var['parent']['catid']; ?>" />
				<?php endif; ?>
				<table class="table-add">

					<tr>
						<td>模型：</td>
						<td>
							<?php if (! $this->_var['parent']): ?><select name="tablename" id="tablename" <?php if ($this->_var['data']['tablename']): ?> disabled="disabled" <?php endif; ?>> 
							<?php $_from = $this->_var['modellist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'm');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['m']):
?> 
							<option value="<?php echo $this->_var['m']['tablename']; ?>" <?php if ($this->_var['data']['tablename'] == $this->_var['m']['tablename'] || $this->_var['tablename'] == $this->_var['m']['tablename']): ?> selected="selected" <?php endif; ?>><?php echo $this->_var['m']['title']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select>
							<?php else: ?>
							<?php echo $this->_var['tablename']; ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php if ($this->_var['catlist']): ?>
					<tr>
						<td>上级分类：</td>
						<td><select name="pid">
								<option value="0">请选择</option>
								<?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
								<option value="<?php echo $this->_var['c']['catid']; ?>" <?php if ($this->_var['data']['pid'] == $this->_var['c']['catid']): ?> selected="selected" <?php endif; ?>><?php echo $this->_var['c']['cname']; ?> </option> 
								<?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_2');if (count($_from)):
    foreach ($_from AS $this->_var['c_2']):
?> 
								<option value="<?php echo $this->_var['c_2']['catid']; ?>" <?php if ($this->_var['data']['pid'] == $this->_var['c_2']['catid']): ?> selected="selected" <?php endif; ?>
								 class="o_c_2">|__<?php echo $this->_var['c_2']['cname']; ?></option>
								<?php $_from = $this->_var['c_2']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_3');if (count($_from)):
    foreach ($_from AS $this->_var['c_3']):
?>
								<option value="<?php echo $this->_var['c_3']['catid']; ?>" <?php if ($this->_var['data']['pid'] == $this->_var['c_3']['catid']): ?> selected="selected" <?php endif; ?> class="o_c_3">
									|____<?php echo $this->_var['c_3']['cname']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select></td>
					</tr>

					<?php endif; ?>

					<tr>
						<td>名称：</td>
						<td><label for="cname"></label>
							<input name="cname" type="text" id="cname" value="<?php echo $this->_var['data']['cname']; ?>"></td>
					</tr>

					<tr>
						<td>状态：</td>
						<td><input name="status" type="radio" id="radio2" value="1" <?php if ($this->_var['data']['status'] != 2): ?> checked="checked" <?php endif; ?> />
							显示
							<input type="radio" name="status" id="radio3" value="2" <?php if ($this->_var['data']['status'] == 2): ?> checked="checked" <?php endif; ?> />
							隐藏</td>
					</tr>

					<tr>
						<td>排序：</td>
						<td><input name="orderindex" type="text" id="orderindex" value="<?php if ($this->_var['data']): ?><?php echo $this->_var['data']['orderindex']; ?><?php else: ?>9999<?php endif; ?>"></td>
					</tr>


					<tr>
						<td>seo标题：</td>
						<td><textarea name="title" id="title" class="w600 h100"><?php echo $this->_var['data']['title']; ?></textarea></td>
					</tr>
					<tr>
						<td>seo关键字：</td>
						<td><textarea name="keywords" id="keywords" class="w600 h100"><?php echo $this->_var['data']['keywords']; ?></textarea></td>
					</tr>
					<tr>
						<td>seo描述：</td>
						<td><textarea name="description" id="description" class="w600 h100"><?php echo $this->_var['data']['description']; ?></textarea></td>
					</tr>

			 
						<td >图标：</td>
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
						<td>列表模板：</td>
						<td><input name="list_tpl" type="text" id="list_tpl" class="w600" value="<?php echo $this->_var['data']['list_tpl']; ?>" /></td>
					</tr>
					<tr>
						<td>详情模板：</td>
						<td><input name="show_tpl" type="text" id="show_tpl" class="w600" value="<?php echo $this->_var['data']['show_tpl']; ?>" /></td>
					</tr>


				</table>
				<div class="btn-row-submit js-submit">保存</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="<?php echo $this->_var['skins']; ?>js/upload.js"></script>
	</body>
	</html>	
