<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="shd">礼物发送记录</div>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>sendid</td>
   <td>礼物</td>
   <td>发送人</td>
   <td>接收人</td>
   <td>留言</td>
   <td>创建时间</td>
 
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['sendid']; ?></td>
   <td><?php echo $this->_var['c']['gift_title']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['touser_nickname']; ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   
 </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>