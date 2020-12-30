<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=recharge">充值记录</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=recharge&a=man">人工充值</a>
</div>	
<div class="main-body">
	<form class="search-form" method="get" action="/admin.php">
		<input type="hidden" name="m" value="recharge" />
	 	
		ID:<input class="w100" type="text" name="id" value="<?php echo $_GET['id']; ?>" />
		状态：<select class="w100" name="status">
			<option value="0">请选择</option>
			<option value="1" <?php if (get ( 'status' ) == 1): ?>selected<?php endif; ?>>支付成功</option>
			<option value="2" <?php if (get ( 'status' ) == 2): ?>selected<?php endif; ?>>支付失败</option>
		</select>
		时间：从
		<input  class="w100" type="text" id="stime" name="stime" value="<?php echo html($_GET['stime']); ?>" /> 
		到
		<input  class="w100" type="text" id="etime" name="etime" value="<?php echo html($_GET['etime']); ?>" /> 
		<button type="submit" class="btn">搜索</button>
	</form>
	<div class="pd-10">
		总计：<?php echo $this->_var['total_money']; ?>元
	</div>
	<table class="tbs">
		<thead>
			<tr align="center">
				<td>ID</td>
				<td width="15%">订单号</td>
				<td>用户</td>
				<td width="10%">交易金额</td>
				<td width="10%">充值类型</td>

				<td width="10%">交易状态</td>
				<td width="18%">交易时间</td>
				<td>内容</td>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<tr align="center">
				<td><?php echo $this->_var['c']['id']; ?></td>
				<td><?php echo $this->_var['c']['orderno']; ?></td>
				<td><?php echo $this->_var['c']['userid']; ?>:<?php echo $this->_var['c']['nickname']; ?></td>
				<td><?php echo $this->_var['c']['money']; ?></td>
				<td><?php echo $this->_var['c']['pay_type_name']; ?></td>

				<td><?php if ($this->_var['c']['status'] == 1): ?>成功<?php else: ?>失败<?php endif; ?></td>
				<td><?php echo date("Y-m-d H:i:s",$this->_var['c']['dateline']); ?></td>
				<td><?php echo $this->_var['c']['orderinfo']; ?></td>
			</tr>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

		</tbody>
	</table>
	<div class="pages"><?php echo $this->_var['pagelist']; ?></div>

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