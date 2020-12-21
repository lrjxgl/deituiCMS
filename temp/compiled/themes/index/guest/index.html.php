<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">留言板</div>
			<div gourl="/index.php?m=guest&a=add" class="header-right-btn">发布留言</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="list">
			<?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<div class="row-box mgb-5">
				
				
			   <div class="flex bd-mp-5">
			   	<div class="cl1 f14"><?php echo $this->_var['c']['nickname']; ?></div>
			   	<div class="flex-1"></div>
			   	<div class="f12 cl2"><?php echo date("Y-m-d H:i:s",$this->_var['c']['dateline']); ?></div> 
			   </div> 
			   <div class="f14 cl2"><?php echo $this->_var['c']['content']; ?></div>
			    
			   <div class="bd-mp-5"></div>
			   <?php if ($this->_var['c']['reply']): ?>
			   <div class="f14 mgb-5 cl2"><?php echo $this->_var['c']['reply']; ?></div>
			   <?php endif; ?>
				
			</div>
			<?php endforeach; else: ?>
				<div class="emptyData">暂无留言</div>
			<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
