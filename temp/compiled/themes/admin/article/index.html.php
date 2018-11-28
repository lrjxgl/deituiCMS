<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="/admin.php?m=article">文章列表</a>
	<a class="item" href="/admin.php?m=article&a=add">添加文章</a>
</div> 
 
<div class="main-body">
<div class="search-form">
<form method="get" action="<?php echo $this->_var['appadmin']; ?>">
<input type="hidden" name="m" value="article" />

ID:<input class="w100" type="text" name="id" value="<?php echo intval($_GET['id']); ?>" class="w50" />
状态：<select name="type" class="w100">
	<option value="all">全部</option>
	<option value="new" <?php if (get ( 'type' ) == 'new'): ?>selected="selected"<?php endif; ?>>未审核</option>
    <option value="pass" <?php if (get ( 'type' ) == 'pass'): ?>selected="selected"<?php endif; ?>>已审核</option>
    <option value="forbid" <?php if (get ( 'type' ) == 'forbid'): ?>selected="selected"<?php endif; ?>>已禁止</option>
</select>
分类：    <select name="catid" class="w100">
    <option value="0">请选择</option>
    <?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
                <option value="<?php echo $this->_var['c']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c']['catid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['cname']; ?></option>
                <?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_2');if (count($_from)):
    foreach ($_from AS $this->_var['c_2']):
?>
                	<option value="<?php echo $this->_var['c_2']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c_2']['catid']): ?> selected="selected"<?php endif; ?> class="o_c_2">|__<?php echo $this->_var['c_2']['cname']; ?></option>
                    <?php $_from = $this->_var['c_2']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_3');if (count($_from)):
    foreach ($_from AS $this->_var['c_3']):
?>
                    <option value="<?php echo $this->_var['c_3']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c_3']['catid']): ?> selected="selected"<?php endif; ?> class="o_c_3"> |____<?php echo $this->_var['c_3']['cname']; ?></option>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </select>
主题：<input type="text" class="w150" name="title" value="<?php echo $_GET['title']; ?>" class="w200" />
推荐：<select name="s_recommend" class="w100">
<option value="0">请选择</option>
<option value="1" <?php if (get ( 's_recommend' ) == 1): ?> selected="selected"<?php endif; ?>>是</option>
<option value="2" <?php if (get ( 's_recommend' ) == 2): ?> selected="selected"<?php endif; ?>>否</option>
</select>

<input type="submit" value="搜索" class="btn" />
</form>
</div>
<div class="main-body">
	<form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=article&a=category">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>标题</td>
   <td>图片</td>
   <td>分类</td>
   <td>喜欢</td>
   <td>收藏</td>
   <td>状态</td>
   <td>推荐</td>
   
   <td>创建时间</td>
<td>操作</td>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><input type="checkbox" class="ids"  name="ids[]" value="<?php echo $this->_var['c']['id']; ?>" /> <?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td>
		 <?php if ($this->_var['c']['imgurl']): ?>
   		<img src="<?php echo $this->_var['c']['imgurl']; ?>.100x100.jpg" width="50" />
			<?php endif; ?>
    </td>
   <td><?php echo $this->_var['c']['cat_name']; ?></td>
   <td><?php echo $this->_var['c']['love_num']; ?></td>
   <td><?php echo $this->_var['c']['fav_num']; ?></td>
    
   <td>
   	 <?php if ($this->_var['c']['status'] == 2): ?>
   <img src='/static/admin/img/yes.gif' class="ajax_no" url='<?php echo $this->_var['appadmin']; ?>?m=article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=4' rurl='<?php echo $this->_var['appadmin']; ?>?m=article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=2'>
    <?php else: ?>
    <img src='/static/admin/img/no.gif' class="ajax_yes" url='<?php echo $this->_var['appadmin']; ?>?m=article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=2' rurl='<?php echo $this->_var['appadmin']; ?>?m=article&a=status&id=<?php echo $this->_var['c']['id']; ?>&status=4'>
    <?php endif; ?>
   </td>
   <td>
   	<?php if ($this->_var['c']['is_recommend'] == 1): ?>
   <img src='/static/admin/img/yes.gif' class="ajax_no" url='<?php echo $this->_var['appadmin']; ?>?m=article&a=recommend&id=<?php echo $this->_var['c']['id']; ?>&is_recommend=0' rurl='<?php echo $this->_var['appadmin']; ?>?m=article&a=recommend&id=<?php echo $this->_var['c']['id']; ?>&is_recommend=2'>
    <?php else: ?>
    <img src='/static/admin/img/no.gif' class="ajax_yes" url='<?php echo $this->_var['appadmin']; ?>?m=article&a=recommend&id=<?php echo $this->_var['c']['id']; ?>&is_recommend=1' rurl='<?php echo $this->_var['appadmin']; ?>?m=article&a=recommend&id=<?php echo $this->_var['c']['id']; ?>&is_recommend=0'>
    <?php endif; ?>
   </td>
   
   <td><?php echo $this->_var['c']['createtime']; ?></td>
<td><a href="admin.php?m=article&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>
 
	<a href="/index.php?m=article&a=show&id=<?php echo $this->_var['c']['id']; ?>" target="_blank">查看</a> 
	<a href="javascript:;" class="delete" url="admin.php?m=article&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
 <div style="padding:10px;">
	分类：    <select name="catid" class="w100">
    <option value="0">请选择</option>
    <?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
                <option value="<?php echo $this->_var['c']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c']['catid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['cname']; ?></option>
                <?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_2');if (count($_from)):
    foreach ($_from AS $this->_var['c_2']):
?>
                	<option value="<?php echo $this->_var['c_2']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c_2']['catid']): ?> selected="selected"<?php endif; ?> class="o_c_2">|__<?php echo $this->_var['c_2']['cname']; ?></option>
                    <?php $_from = $this->_var['c_2']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_3');if (count($_from)):
    foreach ($_from AS $this->_var['c_3']):
?>
                    <option value="<?php echo $this->_var['c_3']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c_3']['catid']): ?> selected="selected"<?php endif; ?> class="o_c_3"> |____<?php echo $this->_var['c_3']['cname']; ?></option>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </select>
    
    <input type="submit" class="btn" value="修改分类" />
</div>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 

<?php echo $this->fetch('footer.html'); ?>
<script>
	$(document).on("click",".js-article-send",function(){
		var id=$(this).attr("data-id");
		var obj=$(this);
		$.post("/admin.php?m=shop_article&a=articleSave&ajax=1&id="+id,function(res){
			skyToast(res.message);
			if(!res.error){
				obj.parents("tr").remove();
			}
		},"json")
	})
</script>
</body>
</html>