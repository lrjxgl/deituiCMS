<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('s2c_team/nav.html'); ?>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>teamid</td>
   <td>状态</td>
   <td>姓名</td>
    <td>头像</td>
   <td>电话</td>
   <td>地址</td>
 
   <td>小区</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['teamid']; ?></td>
   <td><div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=s2c_team&a=status&teamid=<?php echo $this->_var['c']['teamid']; ?>&ajax=1" ></div></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><img src="<?php echo $this->_var['c']['userhead']; ?>.100x100.jpg" width="50" /></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
 
   <td><?php echo $this->_var['c']['shequ_title']; ?></td>
<td>
	<?php if ($this->_var['c']['scid']): ?>
	<a href="javascript:;" class="js-unbind" teamid="<?php echo $this->_var['c']['teamid']; ?>">解绑社区</a>
	<?php endif; ?>
	<a href="/moduleadmin.php?m=s2c_team&a=add&teamid=<?php echo $this->_var['c']['teamid']; ?>">编辑</a>
 
 <a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=s2c_team&a=delete&teamid=<?php echo $this->_var['c']['teamid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
<script>
			$(document).on("click",".js-unbind",function(){
				var obj=$(this);
				if(confirm("确认解绑团长社区吗?")){
					$.get("/moduleadmin.php?m=s2c_team&a=unbind&ajax=1",{
						teamid:$(this).attr("teamid")
					},function(res){
						if(res.error){
							skyToast(res.message)
							return ;
						}
						obj.parents("tr").remove();
					},"json")
				}
			})
		</script>
</body>
</html>