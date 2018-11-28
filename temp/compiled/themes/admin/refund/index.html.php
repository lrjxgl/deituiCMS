<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 <div class="tabs-border">
	 <a href="/admin.php?m=refund" class="item active">退款列表</a>
 </div>
 
<div class="main-body"> 
 	<form class="search-form" method="get" action="<?php echo $this->_var['appadmin']; ?>">
	<input type="hidden" name="m" value="refund" /> 
时间：从
	<input  class="w100" type="text" id="stime" name="stime" value="<?php echo $_GET['stime']; ?>" /> 
	到
	<input  class="w100" type="text" id="etime" name="etime" value="<?php echo $_GET['etime']; ?>" /> 
	
 
	<input type="submit" value="搜索" class="btn" />
</form>
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   
   <td>支付方式</td>
   <td>退款时间</td>
   <td>金额</td>
    
   <td>支付原订单</td>
   
    
 
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
    
   <td><?php echo $this->_var['c']['paytype']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['money']; ?></td>
   <td><?php echo $this->_var['c']['recharge_id']; ?></td>
   
    
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
<script src="/plugin/laydate/laydate.js"></script>
<script>
	laydate.render({
		elem:"#stime",
		type: 'date'
	})
	laydate.render({
		elem:"#etime",
		type: 'date'
	})
</script>	
</body>
</html>