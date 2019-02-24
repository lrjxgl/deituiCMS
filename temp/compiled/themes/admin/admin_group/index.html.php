<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a href="/admin.php?m=admin_group" class="item active">管理组列表</a>
	<a href="/admin.php?m=admin_group&a=add" class="item">添加</a>
</div>
<div class="main-body">

<table class="tbs">
	<colgroup>
		<col width="100" />
		<col width="200" />
	</colgroup>
	<thead>
  <tr>
    <td  >ID</td>
    <td  >组名</td>
    <td  >操作</td>
  </tr>
	</thead>
  <?php $_from = $this->_var['zulist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td  ><?php echo $this->_var['t']['id']; ?></td>
    <td  ><?php echo $this->_var['t']['title']; ?></td>
    <td ><a href="<?php echo $this->_var['appadmin']; ?>?m=admin_group&a=add&id=<?php echo $this->_var['t']['id']; ?>">编辑</a>
		 <a href="javascript:;" url="<?php echo $this->_var['appadmin']; ?>?m=admin_group&a=delete&id=<?php echo $this->_var['t']['id']; ?>"  class="js-delete" >删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
  
</table>
<?php echo $this->_var['pagelist']; ?>

</div> 

<?php echo $this->fetch('footer.html'); ?>
