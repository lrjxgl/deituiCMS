<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=coupon">优惠券列表</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=add">添加优惠券</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=user">优惠券用户</a>
</div>
<div class="main-body">
 <table class="tbs">
	 <thead>
  <tr>
   <td>id</td>
   <td>名称</td>
   
   <td>价格</td>
   <td>最低消费</td>
   <td>数量</td>
   <td>截止日期</td>
   <td>创建时间</td>
   <td>状态</td>
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
   
   <td><?php echo $this->_var['c']['money']; ?></td>
   <td><?php echo $this->_var['c']['lower_money']; ?></td>
   <td><?php echo $this->_var['c']['amount']; ?></td>
   <td><?php echo $this->cutstr($this->_var['c']['etime'],10,''); ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td>
	   <div class="js-toggle-status yes" url="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=status&id=<?php echo $this->_var['c']['id']; ?>&ajax=1"></div>
   		
   </td>
<td>
	<div vid="<?php echo $this->_var['c']['id']; ?>" class="js-send">赠送优惠券</div>
	<a href="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> 
 
<a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </tbody>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
</div>
</div>
<div class="modal-group" id="sendBox">
	<div class="modal-mask"></div>
	<div class="modal">
		<div class="modal-header">
			<div class="modal-title">赠送用户</div>
		</div>
		<div class="modal-body">
			<div class="input-flex">
				<div class="input-flex-label">用户</div>
				<input type="text" placeholder="请输入用户手机号码" id="sendUser" class="input-flex-text" />
				<div id="sendCheck" class="input-flex-btn">确认一下</div>
			</div>
			<div id="sendNick"></div>
			<div id="sendSubmit" class="btn-row-submit">确认赠送</div>
		</div>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>
<script>
	$(function(){
		var coupon_id;
		$(document).on("click",".js-send",function(){
			coupon_id=$(this).attr("vid");
			$("#sendBox").show();
		})
		$(document).on("click","#sendCheck",function(){
			var tel=$("#sendUser").val();
			$.get("/admin.php?m=coupon&a=checkuser&ajax=1&tel="+tel,function(res){
				$("#sendNick").html(res.message);
			},"json")
		})
		$(document).on("click","#sendSubmit",function(){
			$.get("/admin.php?m=coupon_user&a=sendSave&ajax=1",{
				coupon_id:coupon_id,
				telephone:$("#sendUser").val()
			},function(res){
				skyToast(res.message);
			},"json")
		})
	})
</script>
</body>
</html>