<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=seo">seo优化</a>
		<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=seo&a=add">添加seo</a>
	</div>
 
 
 <div class="main-body">
 <table  class="tbs">
	 <thead>
 <tr>
   <td width="9%" align="center">ID</td>
 <td width="9%" align="center">页面名称</td>
 <td width="18%" align="center">m</td>
 <td width="15%" align="center">a</td>
 <td width="22%" align="center">标题</td>
 <td width="36%" align="center">操作</td>
 </tr>
 </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
 <tr>
   <td align="center"><?php echo $this->_var['c']['id']; ?></td>
   <td align="center"><?php echo $this->_var['c']['cname']; ?></td>
   <td align="center"><?php echo $this->_var['c']['m']; ?></td>
   <td align="center"><?php echo $this->_var['c']['a']; ?></td>
   <td align="center"><?php echo $this->_var['c']['title']; ?></td>
   <td align="center"><a href="index.php?m=<?php echo $this->_var['c']['m']; ?>&a=<?php echo $this->_var['c']['a']; ?>" target="_blank">查看</a>
    <a href="<?php echo $this->_var['appadmin']; ?>?m=seo&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
    <a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=seo&a=del&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
 </tr>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 <tr>
   <td colspan="6"><?php echo $this->_var['pagelist']; ?></td>
    
 </tr>
 </table>
</div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>