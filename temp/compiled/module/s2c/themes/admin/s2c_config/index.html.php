<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div class="item active">团长设置</div>
		</div>
		<div class="main-body">
			<form action="/moduleadmin.php?m=s2c_config&a=save&ajax=1">
				<table class="table-add">
					<tr>
						<td>分成模式</td>
						<td>
							<input type="radio" <?php if ($this->_var['data']['fctype'] == 0): ?>checked<?php endif; ?> name="fctype" value="0" /> 订单分成
							&nbsp;&nbsp;
							<input type="radio" <?php if ($this->_var['data']['fctype'] == 1): ?>checked<?php endif; ?> name="fctype" value="1" /> 产品分成
						</td>
					</tr>
					<tr>
						<td>抽成比例</td>
						<td>
							<input type="text" class="w100" name="per_money" value="<?php echo $this->_var['data']['per_money']; ?>" /> %
						</td>
					</tr>
					<tr>
						<td>保证金</td>
						<td>
							<input type="text" class="w100" name="earnest_money" value="<?php echo $this->_var['data']['earnest_money']; ?>" /> ￥
						</td>
					</tr>
					<tr>
						<td>晚单时间</td>
						<td>
							<input type="text" class="w100" name="out_time" value="<?php echo $this->_var['data']['out_time']; ?>" /> 
							<span>时，</span>
							<span>超出时间隔两天送</span>
						</td>
					</tr>
				</table>
				<div class="btn-row-submit js-submit">保存设置</div>
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
