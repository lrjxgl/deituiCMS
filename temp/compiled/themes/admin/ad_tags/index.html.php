<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad&tag_id=<?php echo get_post('tag_id');?>&tag_2nd_id=<?php echo get_post('tag_2nd_id');?>">广告管理</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad&a=add&tag_id=<?php echo get_post('tag_id');?>&tag_2nd_id=<?php echo get_post('tag_2nd_id');?>">广告添加</a>
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=ad_tags">广告分类管理</a>
	<a class="item " href="<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=add">广告分类添加</a>
</div>
<div class="main-body">
 

 <table class="tbs">
 	<thead>
  <tr>
   <td>tag_id</td>
   <td>标题</td>
   <td>唯一代号</td>
   <td>排序</td>
  
   <td>状态</td>
   <td>添加时间</td>
  
   <td>宽度</td>
   <td>高度</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['tag_id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['tagno']; ?></td>
   <td><?php echo $this->_var['c']['orderindex']; ?></td>
 
   <td><?php if ($this->_var['c']['status'] == 1): ?>
           <img src="<?php echo $this->_var['skins']; ?>img/no.gif"  class="ajax_yes" url="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['c']['tag_id']; ?>&status=2" rurl="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['c']['tag_id']; ?>&status=1" /> 
          <?php else: ?>
           <img src="<?php echo $this->_var['skins']; ?>img/yes.gif" class="ajax_no"  rurl="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['c']['tag_id']; ?>&status=2" url="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['c']['tag_id']; ?>&status=1" /> 
          <?php endif; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
    
   <td><?php echo $this->_var['c']['width']; ?></td>
   <td><?php echo $this->_var['c']['height']; ?></td>
<td><a href="admin.php?m=ad_tags&a=add&tag_id=<?php echo $this->_var['c']['tag_id']; ?>">编辑</a> 
	 <a href="javascript:;" class="js-delete" url="admin.php?m=ad_tags&a=delete&tag_id=<?php echo $this->_var['c']['tag_id']; ?>">删除</a></td>
  </tr>
  
  <?php if ($this->_var['c']['child']): ?>
   </tr>
 <?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'cc');if (count($_from)):
    foreach ($_from AS $this->_var['cc']):
?>
<tr>
   <td><?php echo $this->_var['cc']['tag_id']; ?></td>
   <td>|__<?php echo $this->_var['cc']['title']; ?></td>
   <td><?php echo $this->_var['cc']['tagno']; ?></td>
   <td><?php echo $this->_var['cc']['orderindex']; ?></td>
    <td><?php if ($this->_var['cc']['status'] == 1): ?>
           <img src="<?php echo $this->_var['skins']; ?>img/no.gif"  class="ajax_yes" url="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['cc']['tag_id']; ?>&status=2" rurl="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['cc']['tag_id']; ?>&status=1" /> 
          <?php else: ?>
           <img src="<?php echo $this->_var['skins']; ?>img/yes.gif" class="ajax_no"  rurl="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['cc']['tag_id']; ?>&status=2" url="/<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=status&tag_id=<?php echo $this->_var['cc']['tag_id']; ?>&status=1" /> 
          <?php endif; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['cc']['dateline']); ?></td>
    
   <td><?php echo $this->_var['cc']['width']; ?></td>
   <td><?php echo $this->_var['cc']['height']; ?></td>
<td><a href="admin.php?m=ad_tags&a=add&tag_id=<?php echo $this->_var['cc']['tag_id']; ?>">编辑</a> 
	 
	<a href="javascript:;" class="delete" url="admin.php?m=ad_tags&a=delete&tag_id=<?php echo $this->_var['cc']['tag_id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   
   
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
 
<?php echo $this->fetch('footer.html'); ?>