<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('weixin/nav.html'); ?>
<div class="main-body">
	
 <table class="tbs">
	 <thead>
  <tr>
   <td>id</td>
 
   <td>微信token</td>
   <td>微信名</td>
   <td>状态</td>
    
   <td>接口地址</td>
<td width="200">操作</td>
  </tr>
	</thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   
   <td><?php echo $this->_var['c']['token']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php if ($this->_var['c']['status'] == 0): ?>验证<?php else: ?>运营<?php endif; ?></td>
   
   <td><a href="/index.php?m=weixin_openapi&wid=<?php echo $this->_var['c']['id']; ?>">http://<?php echo $_SERVER['HTTP_HOST']; ?>/index.php?m=weixin_openapi&wid=<?php echo $this->_var['c']['id']; ?></a></td>
<td><a href="admin.php?m=weixin&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>
 
 <a href="admin.php?m=weixin&a=setWeixin&id=<?php echo $this->_var['c']['id']; ?>">进入管理</a> 
 <a href="javascript:;" class="js-delete" url="admin.php?m=weixin&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
 
<?php echo $this->fetch('footer.html'); ?>