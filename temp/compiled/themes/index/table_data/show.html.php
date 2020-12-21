<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title"><?php echo $this->_var['table']['title']; ?></div>
	 
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			
			<div class="row-box">
				<div class="flex bd-mp-10 flex-ai-center none">
					<div class="w100"><?php echo $this->_var['fieldsList']["title"]["title"]; ?></div>
					<div class="flex-1"><?php echo $this->_var['fieldsList']["title"]["value"]; ?></div>					
				</div>
				<div>
				</div>
			<?php $_from = $this->_var['fieldsList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
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
				<div class="flex-1 d-content">
					<?php echo $this->_var['c']['value']; ?>
				</div>					
			</div>
			<?php elseif ($this->_var['c']['fieldtype'] == 'img'): ?>
			<div class="flex bd-mp-10 flex-ai-center">
				<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
				<div class="flex-1">
					<img src="<?php echo $this->_var['c']['value']; ?>" class="wmax" />
				</div>					
			</div>
			<?php elseif ($this->_var['c']['fieldtype'] == 'map'): ?>
			<div class="flex bd-mp-10 flex-ai-center">
				<div class="w100"><?php echo $this->_var['c']['title']; ?></div>
				<div class="flex-1 flex">
					<img  src="http://api.map.baidu.com/staticimage/v2?ak=<?php echo BDMAPKEY; ?>&mcode=666666&center=<?php echo $this->_var['c']['value']; ?>&markers=<?php echo $this->_var['c']['value']; ?>&width=300&height=200&zoom=11 " class="wmax"  />
				</div>					
			</div>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		 
	</body>
</html>
