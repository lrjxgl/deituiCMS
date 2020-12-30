<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=pay_log">支付记录</a>
</div>
<div class="main-body">
 

<form class="search-form" action="<?php echo $this->_var['appadmin']; ?>">
<input type="hidden" name="m" value="pay_log" />
	用户Id：<input class="w60" type="text" name="userid"  value="<?php echo $_GET['userid']; ?>" />
	时间：从
	<input  class="w100" type="text" id="stime" name="stime" value="<?php echo html($_GET['stime']); ?>" /> 
	到
	<input  class="w100" type="text" id="etime" name="etime" value="<?php echo html($_GET['etime']); ?>" /> 
	
    <input type="submit" class="btn " />
</form>
 <table class="tbs">
 	<thead>
  <tr>
   <td>id</td>
   <td>时间</td>
   <td>用户id</td>
    
   <td width="300">日志内容</td>
 
   <td>金钱</td>
   <td>收支</td>
  
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td><?php echo $this->_var['c']['userid']; ?>:<?php echo $this->_var['c']['nickname']; ?></td>
   
   <td><?php echo $this->_var['c']['content']; ?></td>
   
   <td><?php echo $this->_var['c']['money']; ?></td>
   <td>
		<?php if ($this->_var['c']['ispay']): ?>收入<?php else: ?>支出<?php endif; ?>
	 </td>
 
<td> <a href="javascript:;" class="js-delete" url="admin.php?m=pay_log&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
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