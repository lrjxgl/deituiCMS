<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
<div class="tabs-border">
	<a class="item active" href="/admin.php?m=refund_apply">退款申请列表</a>
</div>
<div class="main-body">
 <table class="tbs">
<thead>  <tr>
   <td>id</td>
   
   <td>支付方式</td>
   <td>创建时间</td>
   <td>金额</td>
    
   <td>内容</td>
   
<td>操作</td>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   
   <td><?php echo $this->_var['c']['paytype']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['money']; ?></td>
    
   <td><?php echo $this->_var['c']['content']; ?></td>
   
<td>
	<a href="javascript:;" class="js-pass" v="<?php echo $this->_var['c']['id']; ?>">确认退款</a>
	 
	<a href="javascript:;" class="js-delete" url="admin.php?m=refund_apply&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
<script>
	$(function(){
		$(document).on("click",".js-pass",function(){
			var obj=$(this);
			if(confirm("确认退款给用户吗？")){
				$.get("/admin.php?m=refund_apply&a=pass&ajax=1&id="+$(this).attr("v"),function(data){
					obj.parents("tr").remove();
					skyToast(data.message);
				},"json")
			}			
		})
	})
</script>
</body>
</html>