<!doctype html>
<html>
	<?php echo $this->fetch('head.html'); ?>

	<body>
		 
		<div class="tabs-border">
			<div class="item active">提现先去</div>
		</div>
		<div class="main-body">

			<table class="table mgb-10">
				<tr>
					<td>现金额: <?php echo $this->_var['data']['money']; ?> <span style="color:red"> <?php echo $this->_var['data']['status_name']; ?></span></td>
					<td>银行卡号码:<?php echo $this->_var['data']['yhk_haoma']; ?></td>
				</tr>
				<tr>
					<td>银行卡户名:<?php echo $this->_var['data']['yhk_huming']; ?></td>
					<td>银行名称:<?php echo $this->_var['data']['yhk_name']; ?></td>
				</tr>

				<tr>
					<td>开户地址:<?php echo $this->_var['data']['yhk_address']; ?></td>
					<td>联系电话:<?php echo $this->_var['data']['telephone']; ?></td>
				</tr>

				<tr>
					<td colspan="2">
						<div class="flex">
							<div class="mgb-5">备注</div>
							<textarea class="textarea" name="info"  value="100"><?php echo $this->_var['data']['info']; ?></textarea>

						</div>
					</td>

				</tr>

			</table>

			<!--订单操作-->
			 
			<div class="mgb-10 f18 cl-red">订单状态：<?php echo $this->_var['data']['status_name']; ?></div> 
		<?php if ($this->_var['data']['status'] == 0): ?>
			<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=tixian&a=confirm" class="form form-inline ">
				<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
				<table class="table mgb-10">
					<tr>
						<td> 订单确认 </td>
						<td>操作日志：<input type="text" name="content" value="<?php echo $this->_var['admin']['username']; ?>确认了订单" class="w300" />
						<button type="button" class="btn btn-success js-submit-refresh">确认下单</button></td>
					</tr>
				</table>
			</form>
			
			<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=tixian&a=cancel" class="form form-inline " onsubmit="return confirm('订单取消后不可恢复，并且会将订单金额返还给客户，确认取消吗？');">
				<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
				<table class="table  mgb-10">
					<tr>
						<td> 取消订单 </td>
						<td>
							<p>原因：<input type="text" name="message" value="" class="w300" />
								<br /></p>
							操作日志：<input type="text" name="content" value="<?php echo $this->_var['admin']['username']; ?>取消了订单" class="w300" />
								<button type="button" class="btn btn-success js-submit-refresh">订单取消</button></td>
					</tr>
				</table>
			</form>
			<?php endif; ?> 
			<?php if ($this->_var['data']['status'] == 1): ?>

			<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=tixian&a=send" >
				<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
				<table class="table-add">
					<tr>
						<td> 确认支付 </td>
						<td>

							操作日志：
<input type="text" name="content" value="<?php echo $this->_var['admin']['username']; ?>确认支付了" class="w300" />
<button type="button" class="btn btn-success js-submit-refresh">确认支付</button></td>
					</tr>
				</table>
			</form>
			<?php endif; ?> 
		<?php if ($this->_var['data']['status'] == 2): ?>
			<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=tixian&a=finish" onsubmit="return confirm('订单确认完成后订单不能再编辑，确认完成吗？');">
				<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
				<table class="table-add">
					<tr>
						<td> 订单完成 </td>
						<td>操作日志：<input type="text" name="content" value="<?php echo $this->_var['admin']['username']; ?>确认订单完成了" class="w400" />
							<button type="button" class="btn btn-success js-submit-refresh">确认完成</button></td>
					</tr>
				</table>
			</form>
			<?php endif; ?>

		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			$(document).on("click", ".js-submit-refresh", function() {
				$.post($(this).parents("form").attr("action") + "&ajax=1", $(this).parents("form").serialize(), function(res) {
					skyToast(res.message);
					if(!res.error) {
						window.location.reload();
					}
				}, "json")
			})
		</script>
	</body>

</html>