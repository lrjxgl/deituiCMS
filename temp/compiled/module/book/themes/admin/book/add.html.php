<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body >
		<div class="tabs-border">
			<a class="item" href="/moduleadmin.php?m=book">图书列表</a>
			<a class="item active" href="/moduleadmin.php?m=book&a=add">添加图书</a>
		</div>
 <div class="main-body">
	<form id="form" method="post" action="/moduleadmin.php?m=book&a=save">
		<input type="hidden" name="bookid" style="display:none;" value="<?php echo $this->_var['data']['bookid']; ?>">
		<table class="table-add">
			<tr>
				<td width="80">名称：</td>
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
				<td>状态</td>
				<td>
					<input type="radio" <?php if ($this->_var['data']['status'] != 2): ?> checked="" <?php endif; ?> name="status" value="1" /> 下线 
					<input type="radio" <?php if ($this->_var['data']['status'] == 2): ?> checked="" <?php endif; ?>  name="status" value="2" /> 上线
				</td>
			</tr>
			<tr>
				<td>是否公开</td>
				<td>
					<input type="radio" <?php if ($this->_var['data']['isprivate'] != 1): ?> checked="" <?php endif; ?> name="isprivate" value="0" /> 公开 
					<input type="radio" <?php if ($this->_var['data']['isprivate'] == 1): ?> checked="" <?php endif; ?>  name="isprivate" value="1" /> 私有
				</td>
			</tr>
			<tr>
				<td>开启付费</td>
				<td>
					<input type="radio" <?php if ($this->_var['data']['ispay'] != 1): ?> checked="" <?php endif; ?> name="ispay" value="0" /> 无需
					<input type="radio" <?php if ($this->_var['data']['ispay'] == 1): ?> checked="" <?php endif; ?>  name="ispay" value="1" /> 需要
					价格 <input type="text" style="width: 100px;" name="money" value="<?php echo $this->_var['data']['money']; ?>" /> 元
				</td>
			</tr>
			
			 
			<tr>
				<td>描述：</td>
				<td>
					<textarea class="textarea"  name="description" id="description"><?php echo $this->_var['data']['description']; ?></textarea>
				</td>
			</tr>
			 
			<tr>
				<td>内容：</td>
				<td><script type="text/plain" id="content"  name="content" ><?php echo $this->_var['data']['content']; ?></script></td>
			</tr>
			 
		</table>
		<div id="submit"  class="btn-row-submit">保存</div>
	</form>
</div>
<?php echo $this->fetch('footer.html'); ?>
<?php loadEditor();?>
<script src="/static/admin/js/upload.js"></script>
<script language="javascript">
 
var editor=UE.getEditor('content',options);
$(document).on("click","#submit",function(){
	$.post("/moduleadmin.php?m=book&a=save&ajax=1",$("#form").serialize(),function(data){
		skyToast(data.message);
	},"json")
})
</script>
</body>
</html>
