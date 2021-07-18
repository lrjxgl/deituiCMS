<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="shd">短信记录</div>
<div class="main-body">
 <table class="tbs">
	 <colgroup>
		 <col width="100" />
		 <col width="200" />
		 <col />
		 <col width="100" />
	 </colgroup>
<thead>  <tr>
    
   <td>手机</td>
   
   <td>时间</td>
   <td>内容</td>
   <td>状态</td>
 </tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
    
   <td><?php echo $this->_var['c']['telephone']; ?></td>
    
   <td><?php echo date("Y-m-d H:i:s",$this->_var['c']['dateline']); ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
   <td><?php if ($this->_var['c']['status'] == 1): ?>成功<?php else: ?>失败<?php endif; ?></td>
 
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>