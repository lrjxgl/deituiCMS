<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<a class="item <?php if (get ( 'a' ) == 'default'): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=im_msg">私聊列表</a>
	 
</div>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>发信人</td>
   <td>收信人</td>
   
    
   <td>内容</td>
 <td>时间</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['to_nickname']; ?></td>
  
    
   <td><?php echo $this->_var['c']['content']; ?></td>
	 <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
<td>
<div class="btn-mini js-forbid-post" userid="<?php echo $this->_var['c']['userid']; ?>">禁言</div>
<div class="btn-mini js-join-blacklist"  userid="<?php echo $this->_var['c']['userid']; ?>">拉黑</div>
<a href="javascript:;" class="btn-mini btn-danger js-delete" url="/moduleadmin.php?m=im_msg&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a>
</td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>