<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<a href="/moduleadmin.php?m=s2c_done&a=last" class="item active">上月业绩</a>
		</div>
		<div class="main-body">
			<form class="search-form" method="get" action="/moduleadmin.php">
				<input type="hidden" name="m" value="s2c_done" />
				<input type="hidden" name="a" value="last" />
				团长：<input value="<?php echo html($_GET['team_nickname']); ?>" class="w100" type="text"  name="team_nickname" />
				 
				<button type="submit" class="btn">搜索</button>
			</div>
			<table class="tbs">
				<thead>
					<tr>
						<td>团长</td>
						 
						<td>月份</td>
						<td>收入</td>
						
					</tr>
				</thead>
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<tr>
					<td><?php echo $this->_var['c']['team_nickname']; ?></td>
					 
					<td><?php echo $this->_var['c']['smonth']; ?></td>
					<td>￥<?php echo $this->_var['c']['money']; ?></td>
					
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
			<?php echo $this->_var['pagelist']; ?>
		</div>
	</body>
</html>
