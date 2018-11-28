<div class="footer-row"></div>
<div class="footer">
		<a href="/" class="footer-item icon-home">
			首页
		</a>
		<a href="/module.php?m=book" class="footer-item icon-goods">
			课堂
		</a>
		<a href="/index.php?m=api&tpl=gread_recyle" class="footer-item icon-goods">
			借书
		</a>
		
		<a href="<?php if ($this->_var['ssuser']): ?>/index.php?m=user<?php else: ?>/index.php?m=login<?php endif; ?>" class="footer-item icon-my_light">
			我的
		</a>
	</div>