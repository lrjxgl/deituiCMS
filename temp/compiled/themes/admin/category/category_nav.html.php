<ul class="nav nav-tabs">
<li <?php if (get ( 'a' ) == 'default'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_var['appadmin']; ?>?m=category&model_id=<?php echo $this->_var['model_id']; ?>">分类管理</a></li>
<li <?php if (get ( 'a' ) == 'add'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&model_id=<?php echo $this->_var['model_id']; ?>">分类添加</a></li>
 
</ul>