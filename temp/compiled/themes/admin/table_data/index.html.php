<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body class="bg-ef">
		<div class="tabs-border">
			<div><?php echo $this->_var['table']['title']; ?>:<?php echo $this->_var['table']['tablename']; ?></div>
			<a href="?m=table_data&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item active">数据列表</a>
			<a href="?m=table_data&a=add&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">发布</a>
			<a href="?m=table_fields&a=table&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">表设计</a>
			
		</div>
		<div class="main-body ">
			<div class="list ">
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'rs');if (count($_from)):
    foreach ($_from AS $this->_var['rs']):
?>
				<div class="row-box mgb-5 js-item">
					 
					<?php $_from = $this->_var['rs']['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
						<?php if ($this->_var['c']['fieldtype'] == 'text'): ?>
						<div class="flex bd-mp-10 flex-ai-center">
							<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
							<div class="flex-1"><?php echo $this->_var['c']['value']; ?></div>					
						</div>
						<?php elseif ($this->_var['c']['fieldtype'] == 'textarea'): ?>
						<div class="flex bd-mp-10 flex-ai-center">
							<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
							<div class="flex-1">
								<?php echo $this->_var['c']['value']; ?>
							</div>					
						</div>
						<?php elseif ($this->_var['c']['fieldtype'] == 'select'): ?>
						<div class="flex bd-mp-10 flex-ai-center">
							<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
							<div class="flex-1"><?php echo $this->_var['c']['value']; ?></div>					
						</div>
						<?php elseif ($this->_var['c']['fieldtype'] == 'html'): ?>
						<div class="flex bd-mp-10 flex-ai-center">
							<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
							<div class="flex-1">
								<?php echo $this->_var['c']['value']; ?>
							</div>					
						</div>
						<?php elseif ($this->_var['c']['fieldtype'] == 'img'): ?>
						<div class="flex bd-mp-10 flex-ai-center">
							<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
							<div class="flex-1">
								<img src="<?php echo $this->_var['c']['value']; ?>.100x100.jpg" class="w60" />
							</div>					
						</div>
						<?php elseif ($this->_var['c']['fieldtype'] == 'map'): ?>
						<div class="flex bd-mp-10 flex-ai-center">
							<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
							<div class="flex-1 flex">
								<img class="wmax" src="http://api.map.baidu.com/staticimage/v2?ak=<?php echo BDMAPKEY; ?>&mcode=666666&center=<?php echo $this->_var['c']['value']; ?>&markers=<?php echo $this->_var['c']['value']; ?>&width=300&height=200&zoom=11 " class="w60" />
							</div>					
						</div>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					<div class="flex">
						<a href="?m=table_data&a=add&id=<?php echo $this->_var['rs']['id']; ?>&tableid=<?php echo $this->_var['rs']['tableid']; ?>" class="btn-small mgr-20">编辑</a>
						<div class="btn-small mgr-20 btn-warning js-delete" url="?m=table_data&a=delete&ajax=1&id=<?php echo $this->_var['rs']['id']; ?>">删除</div>
						<div >调用 id:<?php echo $this->_var['rs']['id']; ?></div>
					</div>
				</div>	
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
