<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=ad&tag_id=<?php echo get_post('tag_id');?>&tag_2nd_id=<?php echo get_post('tag_2nd_id');?>">广告管理</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad&a=add&tag_id=<?php echo get_post('tag_id');?>&tag_2nd_id=<?php echo get_post('tag_2nd_id');?>">广告添加</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad_tags">广告分类管理</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=add">广告分类添加</a>
</div>