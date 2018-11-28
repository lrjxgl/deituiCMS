<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('weixin/side.html'); ?>


<div class="main-body">
	<?php echo $this->fetch('weixin_command/nav.html'); ?>
	<div class="pd-10">当前微信：<?php echo $this->_var['weixin']['title']; ?></div>

 <table class="tbs">
 	<thead>
  <tr>
   <td>id</td>
   <td>微信id</td>
   <td>命令名称</td>
   <td>命令</td>
   <td>命令类型</td>
   <td>内容</td>
   <td>dateline</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['weixin_list'][$this->_var['c']['wid']]['title']; ?></td>    
   <td><?php echo $this->_var['c']['title']; ?> <?php if ($this->_var['c']['isdefault']): ?><span style="color:red;">默认</span><?php endif; ?></td>
   <td><?php echo $this->_var['c']['command']; ?></td>
   <td><?php echo $this->_var['type_list'][$this->_var['c']['type_id']]; ?></td>
   <td><?php echo $this->cutstr($this->_var['c']['content'],24,''); ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
<td><a href="admin.php?m=weixin_command&a=add&id=<?php echo $this->_var['c']['id']; ?>&wid=<?php echo $this->_var['c']['wid']; ?>">编辑</a> 
<a href="javascript:;" class="delete" url="admin.php?m=weixin_command&a=delete&id=<?php echo $this->_var['c']['id']; ?>&wid=<?php echo $this->_var['c']['wid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
 
<?php echo $this->fetch('footer.html'); ?>