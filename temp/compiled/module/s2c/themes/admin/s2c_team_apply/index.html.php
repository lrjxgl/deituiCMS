<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<div class="tabs-border">
	<a class="item <?php if (get ( 'type' ) == ''): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=s2c_team_apply">待审核列表</a>
	<a class="item <?php if (get ( 'type' ) == 'pass'): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=s2c_team_apply&type=pass">已通过列表</a>
	<a class="item <?php if (get ( 'type' ) == 'forbid'): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=s2c_team_apply&type=forbid">已禁止列表</a>
</div>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>teamid</td>
   
   <td>姓名</td>
   <td>电话</td>
   <td>地址</td>
  
   
   <td>身份证</td>
   <td>身份证号码</td>
   <td>微信号</td>
   <td>小区名称</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['teamid']; ?></td>
    
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
    
   
   <td><img src="<?php echo $this->_var['c']['usercard']; ?>.100x100.jpg" width="50" /></td>
   <td><?php echo $this->_var['c']['usernum']; ?></td>
   <td><?php echo $this->_var['c']['wxhao']; ?></td>
   <td><?php echo $this->_var['c']['shequ']; ?></td>
  
<td>	
 <?php if ($this->_var['c']['status'] == 0): ?>
	<div class="btn js-pass" teamid="<?php echo $this->_var['c']['teamid']; ?>">通过</div>
	
	<div class="btn btn-danger js-forbid"  teamid="<?php echo $this->_var['c']['teamid']; ?>">不通过</div>
	<?php endif; ?>
</td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
<?php echo $this->fetch('footer.html'); ?>
<script>
	$(document).on("click",".js-pass",function(){
		var teamid=$(this).attr("teamid");
		var obj=$(this);
		$.get("/moduleadmin.php?m=s2c_team_apply&a=pass&ajax=1&teamid="+teamid,function(res){
			obj.parents("tr").remove();
		},"json")
	})
	$(document).on("click",".js-forbid",function(){
		var teamid=$(this).attr("teamid");
		var obj=$(this);
		$.get("/moduleadmin.php?m=s2c_team_apply&a=forbid&ajax=1&teamid="+teamid,function(res){
			obj.parents("tr").remove();
		},"json")
	})
</script>
</body>
</html>