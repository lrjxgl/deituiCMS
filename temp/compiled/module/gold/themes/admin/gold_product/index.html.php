<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<?php echo $this->fetch('gold_product/nav.html'); ?>
		<div class="main-body">
			<table class="tbs">
				<thead>
					<tr>
						<td>id</td>
						<td>名称</td>
						
						<td>图片</td>
						<td>金币数量</td> 
						<td>市场价</td>
						<td>状态</td>
					 
						<td>最新</td>
						<td>最热</td>
						<td>推荐</td>
						<td>库存</td>
						<td>销量</td>
					
						
						 
						<td>操作</td>
					</tr>
					</tr>
				</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<tr>
					<td><?php echo $this->_var['c']['id']; ?></td>
					<td><?php echo $this->_var['c']['title']; ?></td>
				 
					<td>
						<img src="<?php echo $this->_var['c']['imgurl']; ?>.100x100.jpg" width="50"/>
					</td>
			 <td><?php echo $this->_var['c']['gold']; ?></td>
			 <td><?php echo $this->_var['c']['market_price']; ?></td>
					<td><div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=gold_product&a=status&id=<?php echo $this->_var['c']['id']; ?>&ajax=1" ></div></td>
					<td><div class="<?php if ($this->_var['c']['isnew'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=gold_product&a=new&id=<?php echo $this->_var['c']['id']; ?>&ajax=1" ></div></td>
					<td><div class="<?php if ($this->_var['c']['ishot'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=gold_product&a=hot&id=<?php echo $this->_var['c']['id']; ?>&ajax=1" ></div></td>
					<td><div class="<?php if ($this->_var['c']['isrecommend'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=gold_product&a=recommend&id=<?php echo $this->_var['c']['id']; ?>&ajax=1" ></div></td>
					<td><?php echo $this->_var['c']['total_num']; ?></td>
					<td><?php echo $this->_var['c']['buy_num']; ?></td>
					
					
					 
					<td><a href="/moduleadmin.php?m=gold_product&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
					<a target="_blank" href="/module.php?m=gold_product&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a>
						<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=gold_product&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
			<div><?php echo $this->_var['pagelist']; ?></div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
