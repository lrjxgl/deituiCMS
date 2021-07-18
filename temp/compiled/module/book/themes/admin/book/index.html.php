<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
	<div class="tabs-border">
		<a class="item active" href="/moduleadmin.php?m=book">图书列表</a>
		<a class="item" href="/moduleadmin.php?m=book&a=add">添加图书</a>
	</div>	
 <div class="main-body">
 <table class="tbs">
 	<thead>
  <tr>
   <td>bookid</td>
   <td>名称</td>
   <td>图片</td>
   <td>价格</td>
   <td>状态</td>
   <td>推荐</td>
   <td>是否公开</td>
   <td>付费</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['bookid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td>
   	<img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg" width="60"  />
   </td>
   <td><?php echo $this->_var['c']['money']; ?></td>
   <td>
   	<?php if ($this->_var['c']['status'] == 2): ?>
   <img src='<?php echo $this->_var['skins']; ?>img/yes.gif' class="ajax_no" url="/moduleadmin.php?m=book&a=status&bookid=<?php echo $this->_var['c']['bookid']; ?>&status=4&ajax=1" rurl='/moduleadmin.php?m=book&a=status&bookid=<?php echo $this->_var['c']['bookid']; ?>&status=2&ajax=1'>
    <?php else: ?>
    <img src='<?php echo $this->_var['skins']; ?>img/no.gif' class="ajax_yes" url='/moduleadmin.php?m=book&a=status&bookid=<?php echo $this->_var['c']['bookid']; ?>&status=2&ajax=1' rurl='/moduleadmin.php?m=book&a=status&bookid=<?php echo $this->_var['c']['bookid']; ?>&status=4&ajax=1'>
    <?php endif; ?> 
   </td>
    <td>
   	<?php if ($this->_var['c']['isrecommend'] == 1): ?>
   <img src='<?php echo $this->_var['skins']; ?>img/yes.gif' class="ajax_no" url="/moduleadmin.php?m=book&a=dorecommend&bookid=<?php echo $this->_var['c']['bookid']; ?>&isrecommend=0&ajax=1" rurl='/moduleadmin.php?m=book&a=dorecommend&bookid=<?php echo $this->_var['c']['bookid']; ?>&isrecommend=1&ajax=1'>
    <?php else: ?>
    <img src='<?php echo $this->_var['skins']; ?>img/no.gif' class="ajax_yes" url='/moduleadmin.php?m=book&a=dorecommend&bookid=<?php echo $this->_var['c']['bookid']; ?>&isrecommend=1&ajax=1' rurl='/moduleadmin.php?m=book&a=dorecommend&bookid=<?php echo $this->_var['c']['bookid']; ?>&isrecommend=0&ajax=1'>
    <?php endif; ?>
   	
   </td>
   <td>
   	<?php if ($this->_var['c']['isprivate']): ?>私有<?php else: ?>公开<?php endif; ?>
   </td>
   <td>
   	<?php if ($this->_var['c']['ispay']): ?>付费<?php else: ?>免费<?php endif; ?>
   </td>
<td><a href="/moduleadmin.php?m=book&a=add&bookid=<?php echo $this->_var['c']['bookid']; ?>">编辑</a> 
	<a href="/module.php?m=book&a=show&bookid=<?php echo $this->_var['c']['bookid']; ?>" target="_blank">查看</a> 
	<a href="/moduleadmin.php?m=book&a=write&bookid=<?php echo $this->_var['c']['bookid']; ?>" target="_blank">写书</a> 
	<a href="javascript:;" class="delete" url="/moduleadmin.php?m=book&a=delete&bookid=<?php echo $this->_var['c']['bookid']; ?>">删除</a>
</td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>