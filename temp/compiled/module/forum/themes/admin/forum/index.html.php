<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
<div class="tabs-border">
	<a class="item active" href="/moduleadmin.php?m=forum">帖子管理</a>
	<a class="item" href="/moduleadmin.php?m=forum&a=add">帖子添加</a>
</div>
<div class="main-body">
	 <div id="searchbox" class="search-form" >
	<form id="searchform" action="/moduleadmin.php" autocomplete="off">
		<input type="hidden" name="m" value="forum">
		ID <input type="text"  class="w50" name="id" value="<?php echo intval($_GET['id']); ?>" />
		主题 <input type="text" class="w150" name="title" value="<?php echo $_GET['title']; ?>" />
		板块 
		 <select name="gid" id="gid" class="w150">
		 		<option value="0">请选择</option>
		 		<?php $_from = $this->_var['grouplist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		 								<option value="<?php echo $this->_var['c']['gid']; ?>" <?php if (get ( 'gid' ) == $this->_var['c']['gid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['title']; ?></option>
		 								
		 	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		 		</select>
		分类 
		 <select name="catid" id="catid" class="w150">
		    <option value="0">请选择</option>
		    <?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		                <option value="<?php echo $this->_var['c']['catid']; ?>" <?php if (get ( 'catid' ) == $this->_var['c']['catid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['title']; ?></option>
		                 
		   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		    </select>
		创建时间 <input name="stime" type="text" id="stime" value="<?php echo $_GET['stime']; ?>" class="w100" /> 到 <input  class="w100" type="text"  name="etime" id="etime"  value="<?php echo $_GET['etime']; ?>" /> 
		<button type="submit" class="btn" >搜索</button>
		 
	</form>
</div>
 <table class='tbs' width='100%'>
  <thead>
  <tr>
   <td>id</td>
   <td>主题</td>
   
  <td>图片</td>
   <td>类别</td>
    <td>作者</td>
   <td >状态</td>
    <td>推荐</td>

<td>操作</td>
  </tr>
  </thead>
  <tbody>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td>
   	<?php if ($this->_var['c']['imgurl']): ?>
   		<img class="w60" src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg">
   	<?php else: ?>
   	无图
   	<?php endif; ?>
   
   </td>
   <td><?php echo $this->_var['c']['gid_name']; ?>/<?php echo $this->_var['c']['cat_name']; ?></td> 
   <td><?php echo $this->_var['c']['nickname']; ?></td>
    <td>
    	<div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=forum&a=status&id=<?php echo $this->_var['c']['id']; ?>&ajax=1" ></div>
    </td>
    <td>
    	<div class="<?php if ($this->_var['c']['isrecommend'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=forum&a=recommend&id=<?php echo $this->_var['c']['id']; ?>&ajax=1" ></div>
    </td>
   
<td><a href="moduleadmin.php?m=forum&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>
	 
	 
	<a href="/module.php?m=forum&a=show&id=<?php echo $this->_var['c']['id']; ?>"  target="_blank">查看</a> 
	<a href="javascript:;" class="js-delete" url="moduleadmin.php?m=forum&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </tbody>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
</div>
<?php echo $this->fetch('footer.html'); ?>
<script src="/plugin/laydate/laydate.js"></script>
<script>
	laydate.render({
		elem:"#stime"
	})
	laydate.render({
		elem:"#etime"
	});
</script>
</body>
</html>