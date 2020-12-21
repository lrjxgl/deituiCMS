<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title"><?php echo $this->_var['table']['title']; ?></div>
			<div class="header-right-btn" gourl="?m=table_data&a=add&tableid=<?php echo $this->_var['table']['tableid']; ?>">发布</div>
		</div>
		<div class="header-row"></div>
	 
		<div class="main-body ">
			<div class="list ">
				<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'rs');if (count($_from)):
    foreach ($_from AS $this->_var['rs']):
?>
				<?php $this->_var["row"]=$this->_var["rs"]["data"];?>
				<div class="none">
					<?php echo $this->_var['rs']["data"]["title"]["title"]; ?>:<?php echo $this->_var['rs']["data"]["title"]["value"]; ?><br/>
					<?php echo $this->_var['row']["title"]["title"]; ?>:<?php echo $this->_var['row']["title"]["value"]; ?>
				</div>
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
					<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					<div class="flex">
						<a href="?m=table_data&a=show&id=<?php echo $this->_var['rs']['id']; ?>&tableid=<?php echo $this->_var['rs']['tableid']; ?>" class="btn-small mgr-20">查看</a>
					 
						 
					</div>
				</div>	
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
