<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>

	<body>
		<?php echo $this->fetch('zblive/nav.html'); ?>
		<form method="post" action="/moduleadmin.php?m=zblive&a=save">
			<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
			<table class="table-add">
				<tr>
					<td width="100">名称：</td>
					<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
				</tr>

				<tr>
					<td>直播串：</td>
					<td>

						 
						<div>
							<?php echo $this->_var['data']['auth_key']; ?>
						</div>
						<div>
						完整： <?php echo $this->_var['zconfig']['zbrtmp']; ?><?php echo $this->_var['data']['auth_key']; ?>
						</div> 
						</td>
				</tr>

				<tr>
					<td>回放地址</td>
					<td>
						<input read-only type="text" class="w98" name="mp4url" value="<?php echo $this->_var['data']['mp4url']; ?>" /> (无需填写)
					</td>
				</tr>

				<tr>
					<td>状态：</td>
					<td><input type="radio" name="status" value="2" <?php if ($this->_var['data']['status'] != 1): ?> checked="checked" <?php endif; ?> />隐藏 &nbsp;
						<input type="radio" name="status" value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked="checked" <?php endif; ?> />显示</td>
				</tr>

				<tr>
					<td>直播状态</td>
					<td>
						<input type="radio" name="zbstatus" value="0" <?php if ($this->_var['data']['zbstatus'] == 0): ?> checked="" <?php endif; ?> /> 未直播
						<input type="radio" name="zbstatus" value="1" <?php if ($this->_var['data']['zbstatus'] == 1): ?> checked="" <?php endif; ?> /> 直播中
						<input type="radio" name="zbstatus" value="2" <?php if ($this->_var['data']['zbstatus'] == 2): ?> checked="" <?php endif; ?> /> 已结束
					</td>
				</tr>
				<tr>
					<td>回放状态：</td>
					<td><input type="radio" name="isback" value="1" <?php if ($this->_var['data']['isback'] == 1): ?> checked="checked" <?php endif; ?> />可回放 &nbsp;
						<input type="radio" name="isback" value="0" <?php if ($this->_var['data']['isback'] != 1): ?> checked="checked" <?php endif; ?> />否</td>
				</tr>
				<tr>
					<td>视频尺寸</td>
					<td>
						<select name="vdsize">
							<option <?php if ($this->_var['data']['vdsize'] == 1): ?>selected<?php endif; ?> value="1">16*9</option>
							
							<option  <?php if ($this->_var['data']['vdsize'] == 2): ?>selected<?php endif; ?>  value="2">竖屏视频</option>
							<option  <?php if ($this->_var['data']['vdsize'] == 3): ?>selected<?php endif; ?>  value="3">4*3</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>描述：</td>
					<td><textarea name="description" id="description" class="w98 h60"><?php echo $this->_var['data']['description']; ?></textarea></td>
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
					<td>开始时间：</td>
					<td><input type='text' name='starttime' id='starttime' value='<?php if ($this->_var['data']): ?><?php echo date("Y-m-d H:i:s",$this->_var['data']['starttime']); ?><?php endif; ?>' ></td>
				</tr>
				<tr>
					<td>结束时间：</td>
					<td><input type='text' name='endtime' id='endtime' value='<?php if ($this->_var['data']): ?><?php echo date("Y-m-d H:i:s",$this->_var['data']['endtime']); ?><?php endif; ?>'  ></td>
				</tr>
				<tr>
					<td>观看数：</td>
					<td><input type="text" name="view_num" id="view_num" value="<?php echo $this->_var['data']['view_num']; ?>"></td>
				</tr>
				<tr>
					<td>推广类型</td>
					<td>
						<select name="tablename">
							<option value="">请选择</option>
							<?php $_from = $this->_var['tableList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
							<option <?php if ($this->_var['k'] == $this->_var['data']['tablename']): ?>selected<?php endif; ?> value="<?php echo $this->_var['k']; ?>"><?php echo $this->_var['c']; ?></option>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>产品ID</td>
					<td>
						<input type="text" class="w98" name="proids" value="<?php echo $this->_var['data']['proids']; ?>" />
						(商品id用英文逗号隔开 如：123,345,666,765)
					</td>
				</tr>
				<tr>
					<td>内容：</td>
					<td>
						<script name="content" id="content" style="height:300px;" type="text/html"><?php echo $this->_var['data']['content']; ?></script>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><div class="btn btn-success js-submit">保存</div></td>
				</tr>
			</table>
		</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/laydate/laydate.js"></script>
		<script>
			laydate.render({
				elem:"#starttime",
				type:"datetime"
			})
			laydate.render({
				elem:"#endtime",
				type:"datetime"
			})
		</script>	
		<?php loadEditor();?>
		<script>
			var editor = UE.getEditor('content', options)
		</script>

		<script src="/static/admin/js/upload.js"></script>
	</body>

</html>
