<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('site_city/nav.html'); ?>
<div class="main-body">
<?php if ($this->_var['parent']): ?><h3><a href="<?php echo $this->_var['appadmin']; ?>?m=site_city&pid=<?php echo $this->_var['parent']['pid']; ?>">返回上一级</a></h3><?php endif; ?>
 <table class='table table-bordered' width='100%'>
  <tr>
   <td>sc_id</td>
   <td>区域名称</td>
   <td>城市关联id</td>
   <td>纬度</td>
   <td>精度</td>
   <td>排序</td>
   <td>状态</td>
   <td>上级分类</td>
<td>操作</td>
  </tr>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['sc_id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['cityid']; ?></td>
   <td><?php echo $this->_var['c']['lat']; ?></td>
   <td><?php echo $this->_var['c']['lng']; ?></td>
   <td><?php echo $this->_var['c']['orderindex']; ?></td>
   <td><?php if ($this->_var['c']['status']): ?><img src="/static/images/yes.gif" class="ajax_no" url="<?php echo APPADMIN; ?>?m=site_city&a=status&sc_id=<?php echo $this->_var['c']['sc_id']; ?>&status=0" rurl="<?php echo APPADMIN; ?>?m=site_city&a=status&sc_id=<?php echo $this->_var['c']['sc_id']; ?>&status=1"><?php else: ?><img src="/static/images/no.gif"  class="ajax_yes" url="<?php echo APPADMIN; ?>?m=site_city&a=status&sc_id=<?php echo $this->_var['c']['sc_id']; ?>&status=1" rurl="<?php echo APPADMIN; ?>?m=site_city&a=status&sc_id=<?php echo $this->_var['c']['sc_id']; ?>&status=0"><?php endif; ?></td>
   <td>
   <?php if ($this->_var['parent']['pid']): ?><?php echo $this->_var['id_title'][$this->_var['parent']['pid']]; ?><?php endif; ?>
   <?php if ($this->_var['c']['pid']): ?><?php echo $this->_var['id_title'][$this->_var['c']['pid']]; ?><?php else: ?>顶级<?php endif; ?></td>
<td><a href="admin.php?m=site_city&a=add&sc_id=<?php echo $this->_var['c']['sc_id']; ?>">编辑</a> 
<a href="admin.php?m=site_city&pid=<?php echo $this->_var['c']['sc_id']; ?>">下级区域</a> 
<a href="javascript:;" class="js-delete" url="admin.php?m=site_city&a=delete&sc_id=<?php echo $this->_var['c']['sc_id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>
