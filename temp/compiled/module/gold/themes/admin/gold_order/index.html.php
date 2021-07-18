<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<a class="item <?php if (get ( 'a' ) == 'default'): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=gold_order">订单列表</a>
</div>
<div class="main-body">
	<form autocomplete="off" class="search-form" action="/moduleadmin.php"> 
		<input type="hidden" name="m" value="gold_order">
		<input type="hidden" name="type" value="<?php echo html($_GET['type']); ?>" />
		 
		订单号 <input type="text" class="w150" name="orderno" value="<?php echo html($_GET['orderno']); ?>" />
		用户 <input type="text" name="nickname" class="w100" value="<?php echo html($_GET['nickname']); ?>" />	 
		 
		下单时间 <input name="stime" type="text" id="stime" value="<?php echo $_GET['stime']; ?>" class="w100" /> 到 <input  class="w100" type="text"  name="etime" id="etime"  value="<?php echo $_GET['etime']; ?>" /> 
		<button type="submit" class="btn" >搜索</button>
	</form>
 <table class="tbs">
<thead>  <tr>
   <td>订单号</td>
   <td>产品</td>
   
   <td>状态</td>
   
  
   <td>金币</td>
  
  
   <td>createtime</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
  <td><?php echo $this->_var['c']['orderno']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   
   <td><?php echo $this->_var['c']['status_name']; ?></td>
  
   <td><?php echo $this->_var['c']['gold']; ?></td>
  
 
   <td><?php echo $this->_var['c']['createtime']; ?></td>
<td> <a href="/moduleadmin.php?m=gold_order&a=show&orderid=<?php echo $this->_var['c']['orderid']; ?>">查看</a> 
</td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>