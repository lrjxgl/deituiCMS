<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=permission">权限列表</a>
	
	<a class="item active"  href="<?php echo $this->_var['appadmin']; ?>?m=permission&a=add">权限添加</a>
	<a class="item"  href="<?php echo $this->_var['appadmin']; ?>?m=permission&a=saveconfig">权限生成</a>
</div>

<div class="main-body">
<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=permission&a=save">
<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
<table   class="table-add">
  <tr>
    <td align="right">名称：</td>
    <td   align="left"><input name="title" type="text" id="title" value="<?php echo $this->_var['data']['title']; ?>" /></td>
    </tr>
 
  <tr>
    <td align="right">m：</td>
    <td align="left"><label for="m"></label>
      <input name="m" type="text" id="m" value="<?php echo $this->_var['data']['m']; ?>" /></td>
    </tr>
   
  <tr>
    <td align="right">权限：</td>
    <td align="left"><label for="access"></label>
      <input name="access" type="text" id="access" value="<?php echo $this->_var['data']['access']; ?>" class="w600" /></td>
    </tr>
 
  </table>
	<div class="btn-row-submit js-submit">保存</div> 
</form>
</div>

<?php echo $this->fetch('footer.html'); ?>