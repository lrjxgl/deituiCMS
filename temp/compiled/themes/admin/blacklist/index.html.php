<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<div class="item active">用户黑名单</div>
</div>
<form class="search-form" method="get" action="/admin.php">
	<input type="hidden" name="m" value="blacklist" />
 
	昵称：<input type="text" name="nickname" class="w150" />
	 
	<button type="submit" class="btn btn-success">搜一下</button>
</form>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>昵称</td>
   <td>
	   头像
   </td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['userid']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td>
	   <img class="w60" src="<?php echo $this->_var['c']['user_head']; ?>.100x100.jpg" />
   </td>
<td>
	<a href="javascript:;" class="js-delete" url="admin.php?m=blacklist&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
 
</body>
</html>