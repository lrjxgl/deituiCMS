<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=permission">权限列表</a>
	
	<a class="item"  href="<?php echo $this->_var['appadmin']; ?>?m=permission&a=add">权限添加</a>
	<a class="item"  href="<?php echo $this->_var['appadmin']; ?>?m=permission&a=saveconfig">权限生成</a>
</div>
<div class="main-body">

<table  class="tbs">
	<thead>
  <tr>
    <td width="4%" align="center">ID</td>
    <td width="16%" align="center">名称</td>
    <td width="10%" align="center">m</td>
  
    <td width="40%" align="center">权限</td>
    <td width="20%" align="center">操作</td>
  </tr>
	</thead>
  <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['c']['id']; ?></td>
    <td align="center"><?php echo $this->_var['c']['title']; ?></td>
    <td align="center"><?php echo $this->_var['c']['m']; ?></td>
     
    <td align="center" style="word-break: break-all;"><?php echo $this->_var['c']['access']; ?></td>
    <td align="center"> 
		<a href="<?php echo $this->_var['appadmin']; ?>?m=permission&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
		<a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=permission&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
</table>
 
</div>

<?php echo $this->fetch('footer.html'); ?>