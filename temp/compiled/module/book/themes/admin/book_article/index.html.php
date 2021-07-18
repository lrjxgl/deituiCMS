<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
 
	<div class="tabs-border">
		<a class="item active" href="/moduleadmin.php?m=book_article">文章列表</a>
		 
	</div>		
 <div class="main-body">
 <table class="tbs">
 	<thead>
  <tr>
   <td>id</td>
   <td>标题</td>
   <td>书籍</td>
   
  
   
   <td>创建</td>
   <td>状态</td> 
 <td>推荐</td>
   
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
    <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['book_title']; ?></td>
   
   
   
   <td><?php echo $this->cutstr($this->_var['c']['createtime'],16,''); ?></td>
   <td>
   	<?php if ($this->_var['c']['status'] == 2): ?>
   <img src='<?php echo $this->_var['skins']; ?>img/yes.gif' class="ajax_no" url="/moduleadmin.php?m=book_article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=4&ajax=1" rurl='/moduleadmin.php?m=book_article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=2&ajax=1'>
    <?php else: ?>
    <img src='<?php echo $this->_var['skins']; ?>img/no.gif' class="ajax_yes" url='/moduleadmin.php?m=book_article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=2&ajax=1' rurl='/moduleadmin.php?m=book_article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=4&ajax=1'>
    <?php endif; ?> 
   </td>
    <td>
   	<?php if ($this->_var['c']['pageindex'] == 1): ?>
   <img src='<?php echo $this->_var['skins']; ?>img/yes.gif' class="ajax_no" url="/moduleadmin.php?m=book_article&a=dopageindex&id=<?php echo $this->_var['c']['id']; ?>&pageindex=0&ajax=1" rurl='/moduleadmin.php?m=book_article&a=dopageindex&id=<?php echo $this->_var['c']['id']; ?>&pageindex=1&ajax=1'>
    <?php else: ?>
    <img src='<?php echo $this->_var['skins']; ?>img/no.gif' class="ajax_yes" url='/moduleadmin.php?m=book_article&a=dopageindex&id=<?php echo $this->_var['c']['id']; ?>&pageindex=1&ajax=1' rurl='/moduleadmin.php?m=book_article&a=dopageindex&id=<?php echo $this->_var['c']['id']; ?>&pageindex=0&ajax=1'>
    <?php endif; ?>
   	
   </td>
    
  
<td><a href="/moduleadmin.php?m=book_article&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
	<a href="/module.php?m=book_article&a=show&id=<?php echo $this->_var['c']['id']; ?>" target="_blank">查看</a> 
	<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=book_article&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>