<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('open_qq/nav.html'); ?>
<div class="main-body">
<form method="post" action="admin.php?m=open_qq&a=save">
<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>" >
 <table class="table-add">  <tr>
				<td>名称：</td>		
				<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>" ></td>
				</tr>
  <tr>
				<td>类型：</td>		
				<td> 
						<input type="radio" name="apptype" value="web" <?php if ($this->_var['data']['apptype'] == 'web'): ?>checked<?php endif; ?> /> web 
						<input type="radio" name="apptype" value="app" <?php if ($this->_var['data']['apptype'] == 'app'): ?>checked<?php endif; ?>  /> app
					 
				</td>
				</tr>
			<?php if ($this->_var['data']): ?>
  <tr>
				<td>创建时间：</td>		
				<td><?php echo $this->_var['data']['createtime']; ?></td>
				</tr>
				<?php endif; ?>
  <tr>
				<td>appid：</td>		
				<td><input type="text" name="appid" id="appid" value="<?php echo $this->_var['data']['appid']; ?>" ></td>
				</tr>
  <tr>
				<td>appkey：</td>		
				<td><input type="text" name="appkey" id="appkey" value="<?php echo $this->_var['data']['appkey']; ?>" ></td>
				</tr>
  <tr>
				<td>状态：</td>		
				<td>
						<input type="radio" name="status"  value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked <?php endif; ?> >上线
						<input type="radio" name="status"  value="0"  <?php if ($this->_var['data']['status'] == 0): ?> checked <?php endif; ?> >下线
				
				</td>
				</tr>
</table> <div class="btn-row-submit js-submit">保存</div> 
</form>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>