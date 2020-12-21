<div class="footer-row"></div>
<div class="footer">
	<div class="footer-item icon-home <?php if ($this->_var['ftnav'] == 'b2c_home'): ?>footer-active<?php endif; ?>" gourl="/module.php?m=b2c">首页</div>
	<!--
	<?php if (MB2C_SHOPTYPE != 'diancan'): ?>
	<div class="footer-item icon-cascades <?php if ($this->_var['ftnav'] == 'b2c_category'): ?>footer-active<?php endif; ?>" gourl="/module.php?m=b2c_category">分类</div>
	<?php endif; ?>
	<?php if (MB2C_SHOPTYPE == 'diancan'): ?>
	<div class="footer-item icon-goods <?php if ($this->_var['ftnav'] == 'b2c_product'): ?>footer-active<?php endif; ?>" gourl="/module.php?m=b2c_product">点餐</div>
	<?php endif; ?>
	-->
	<div class="footer-item icon-cart <?php if ($this->_var['ftnav'] == 'b2c_cart'): ?>footer-active<?php endif; ?>" gourl="/module.php?m=b2c_cart">购物车</div>
	
	<div class="footer-item icon-my_light <?php if ($this->_var['ftnav'] == 'b2c_user'): ?>footer-active<?php endif; ?>"  gourl="/module.php?m=b2c_user">我的</div>
</div>