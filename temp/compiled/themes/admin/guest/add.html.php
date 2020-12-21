<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>

		<div class="shd">留言板</div>
		<div class="main-body">
			<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=guest&a=save">
			<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>">
			<table class="table-add">
			  <tr>
			    <td width="20%" align="right">主题：</td>
			    <td width="80%"><?php echo $this->_var['data']['title']; ?></td>
			  </tr>
			  <tr>
			    <td align="right">昵称：</td>
			    <td><?php echo $this->_var['data']['nickname']; ?></td>
			  </tr>
			  <tr>
			    <td align="right">内容：</td>
			    <td><?php echo $this->_var['data']['content']; ?></td>
			  </tr>
			  <tr>
			    <td align="right">qq：</td>
			    <td><?php echo $this->_var['data']['qq']; ?></td>
			  </tr>
			  <tr>
			    <td align="right">email：</td>
			    <td><?php echo $this->_var['data']['email']; ?></td>
			  </tr>
			  <tr>
			    <td align="right">telephone:</td>
			    <td><?php echo $this->_var['data']['telephone']; ?></td>
			  </tr>
			  <tr>
			    <td align="right">回复：</td>
			    <td><textarea name="reply" id="reply" cols="45" rows="5"><?php echo $this->_var['data']['reply']; ?></textarea></td>
			  </tr>
			   
			</table>
				<div class="btn-row-submit js-submit">提交</div>
			</form>
		</div>

 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>