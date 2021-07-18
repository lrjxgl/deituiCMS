<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=seo">seo优化</a>
		<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=seo&a=add">添加seo</a>
	</div>
 
 
 <div class="main-body">
<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=seo&a=save">
<input type="hidden" name="id" value="<?php echo $this->_var['seo']['id']; ?>">
<table width="100%" class="table table-bordered">
<tr>
<td align="right">页面名称:</td>
<td><input type="text" name="cname" value="<?php echo $this->_var['seo']['cname']; ?>"></td>
</tr>
<tr>
  <td align="right">m：</td>
  <td><input name="m" type="text" id="m" value="<?php echo $this->_var['seo']['m']; ?>"></td>
</tr>
<tr>
  <td align="right">a：</td>
  <td><input name="a" type="text" id="a" value="<?php echo $this->_var['seo']['a']; ?>"></td>
</tr>
<tr>
  <td align="right">ID：</td>
  <td><label for="object_id"></label>
    <input name="object_id" type="text" id="object_id" value="<?php echo $this->_var['seo']['object_id']; ?>" /></td>
</tr>
<tr>
  <td align="right">标题：</td>
  <td><input name="title" type="text" id="title" value="<?php echo $this->_var['seo']['title']; ?>" size="80"></td>
</tr>
<tr>
  <td align="right">关键字：</td>
  <td><input name="keywords" type="text" id="keywords" value="<?php echo $this->_var['seo']['keywords']; ?>" size="80"></td>
</tr>
<tr>
  <td align="right">描述：</td>
  <td><textarea name="description" id="description" cols="45" rows="5"><?php echo $this->_var['seo']['description']; ?></textarea></td>
</tr>
 
</table>
<div class="btn-row-submit js-submit" >保存</div>
</form>
</div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>