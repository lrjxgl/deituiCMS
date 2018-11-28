<ul class="nav nav-tabs">
<li <?php if (get ( 'm' ) == 'admin' && get ( 'a' ) == 'default'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_var['appadmin']; ?>?m=admin">管理员管理</a> </li> 
<li <?php if (get ( 'm' ) == 'admin' && get ( 'a' ) == 'add'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_var['appadmin']; ?>?m=admin&a=add">管理员添加</a>  </li>
<li <?php if (get ( 'm' ) == 'admin_group' && get ( 'a' ) == 'default'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_var['appadmin']; ?>?m=admin_group">管理组</a></li> 
<li <?php if (get ( 'm' ) == 'admin_group' && get ( 'a' ) == 'add'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_var['appadmin']; ?>?m=admin_group&a=add">管理组添加</a></li>
</ul>