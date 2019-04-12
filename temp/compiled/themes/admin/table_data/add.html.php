<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div><?php echo $this->_var['table']['title']; ?>:<?php echo $this->_var['table']['tablename']; ?></div>
			<a href="?m=table_data&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">数据列表</a>
			
			<a href="?m=table_data&a=add&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item active">发布</a>
			<a href="?m=table_fields&a=table&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">表设计</a>
		</div>
		<div class="main-body">
			<form action="" class="list">
				<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
				<input type="hidden" name="tableid" value="<?php echo $this->_var['table']['tableid']; ?>" />
				<?php $_from = $this->_var['fieldsList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<?php if ($this->_var['c']['fieldtype'] == 'text'): ?>
				<div class="input-flex">
					<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<input type="text" name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" value="<?php echo $this->_var['c']['value']; ?>" />
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'textarea'): ?>
				<div class="textarea-flex">
					<div class="textarea-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<textarea name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="textarea-flex-text h60"><?php echo $this->_var['c']['value']; ?></textarea>
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'html'): ?>
				<div class="textarea-flex">
					<div class="textarea-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<div class="js-html-item">
						<textarea name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="none js-html-textarea"><?php echo $this->_var['c']['value']; ?></textarea>
						<div contenteditable="true" class="sky-editor-content textarea-flex-text "><?php echo $this->_var['c']['value']; ?></div>
					</div>
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'img'): ?>
				<div class="input-flex">
					<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<div class="flex-1">
						<div class="js-upload-item">
							<input type="file" id="tablefield<?php echo $this->_var['c']['id']; ?>" class="js-upload-file" style="display: none;" />
							<div class="upimg-btn js-upload-btn">+</div>
							<input type="hidden" name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="js-imgurl" value="<?php echo $this->_var['c']['value']; ?>" />
							<div class="js-imgbox">
								<?php if ($this->_var['c']['value']): ?>
								<img src="<?php echo images_site($this->_var['c']['value']); ?>.100x100.jpg" class="w60" />
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				<div class="btn-row-submit" id="submit">保存</div>
				
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script language="javascript" src="/static/admin/js/upload.js"></script>
		<script src="/plugin/lrz/lrz.bundle.js"></script>
		<script src="/plugin/skyeditor/skyeditor.js"></script>
		<script>
			$(document).on("click","#submit",function(){
				var form=$(this).parents("form");
				var len=$(".sky-editor-content").length;
				for(var i=0;i<len;i++){
					var $e=$(".sky-editor-content:eq("+i+")");
					$e.parents(".js-html-item").find(".js-html-textarea").val($e.html());
				}
				$.ajax({
					url:"?m=table_data&a=save&ajax=1",
					data:form.serialize(),
					method:"POST",
					success:function(res){
						goBack();
					}
				})
			})
		</script>
	</body>
</html>
