<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<div class="item active">手机黑名单</div>
</div>
<form class="search-form" action="/admin.php?m=badphone&a=save">
	手机号：<input type="text" name="telephone" class="w150" />
	原因：<input type="text" name="content" class="w300" />
	<div class="btn btn-success js-add">添加</div>
</form>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   <td>手机号</td>
   <td>原因</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
<td>
	<a href="javascript:;" class="js-delete" url="admin.php?m=badphone&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
<script>
	$(document).on("click",".js-add",function(){
		var obj=$(this);
		$.post(
			$(this).parents("form").attr("action")+"&ajax=1",
			$(this).parents("form").serialize(),
			function(data){
				if(data.error){
					skyToast(data.message);
					return false;
				}
				window.location.reload();
			},
			"json"
		);
		
	})
</script>
</body>
</html>