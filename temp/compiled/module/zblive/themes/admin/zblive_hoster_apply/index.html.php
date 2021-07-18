<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<a class="item <?php if (get ( 'a' ) == 'default'): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=zblive_hoster_apply">管理</a>
</div>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>hostid</td>
   <td>userid</td>
   <td>status</td>
   <td>dateline</td>
   <td>content</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['hostid']; ?></td>
   <td><?php echo $this->_var['c']['userid']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
<td><a href="moduleadmin.php?m=zblive_hoster_apply&a=pass&hostid=<?php echo $this->_var['c']['hostid']; ?>">审核通过</a> 
<a href="/module.php?m=zblive_hoster_apply&a=forbid&hostid=<?php echo $this->_var['c']['hostid']; ?>">不通过</a>
</td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>