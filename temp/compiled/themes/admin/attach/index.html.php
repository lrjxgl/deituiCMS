<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<div gourl="?m=attach&type=new" class="item <?php if (get ( 'type' ) == 'new'): ?>active<?php endif; ?>">待审核</div>
	<div gourl="?m=attach&type=pass"  class="item <?php if (get ( 'type' ) == 'pass'): ?>active<?php endif; ?>">已通过</div>
	<div gourl="?m=attach&type=all"  class="item <?php if (get ( 'type' ) == 'all'): ?>active<?php endif; ?>">全部</div>
</div>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>文件</td>
   <td>时间</td>
   <td>状态</td>
   <td>上传用户</td>
   
   
   <td>文件大小</td>
   <td>后缀</td>
   <td>类型</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php if ($this->_var['c']['file_group'] == 'img'): ?>
   	<img class="w100" src="<?php echo images_site($this->_var['c']['file_url']); ?>.small.jpg" />
   <?php else: ?><?php echo $this->_var['c']['file_name']; ?><?php endif; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td><div url="?m=attach&a=status&ajax=1&id=<?php echo $this->_var['c']['id']; ?>" class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status"></div></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
    
   
   <td><?php echo $this->_var['c']['file_size']; ?>KB</td>
   <td><?php echo $this->_var['c']['file_type']; ?></td>
   <td><?php echo $this->_var['c']['file_group']; ?></td>
<td><a target="_blank" href="<?php echo images_site($this->_var['c']['file_url']); ?>">下载</a> <a href="javascript:;" class="js-delete" url="admin.php?m=attach&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>