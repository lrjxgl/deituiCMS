<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	 
	<div class="header">
		<div class="header-back"></div>
		<div class="header-title">在线充值</div>
	</div>
	<div class="header-row"></div>
    <div class="main-body">
 
<form id="rcform" class="row-box" method="post" action="/index.php?m=recharge&a=recharge">
 <div class="flex flex-center">
 	<div class="input-flex-label">支付方式</div>
 	<div class="flex-1">
 		<div class="paylist" id="paylist">
    	<?php $_from = $this->_var['pay_type_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');$this->_foreach['p'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['p']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
        $this->_foreach['p']['iteration']++;
?>
        <?php if (($this->_foreach['p']['iteration'] <= 1)): ?>
        <input type="hidden" name="pay_type" id="pay_type" value="<?php echo $this->_var['k']; ?>">
         <div class="paylist-item active" v="<?php echo $this->_var['k']; ?>"><?php echo $this->_var['c']; ?></div>
        <?php else: ?>
        <div class="paylist-item" v="<?php echo $this->_var['k']; ?>"><?php echo $this->_var['c']; ?></div> 
        <?php endif; ?>
        
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
 	</div>
 </div>
 <div class="input-flex">
 	<div class="input-flex-label">充值金额</div>
 
 	<input class="input-flex-text" type="text" name="order_price" id="order_price" value="1" >
 	 
 </div>
 
<button type="submit" id="rcbtn"    class="btn-row-submit">确认充值</button>
</form>

 

</div>
 
<?php echo $this->fetch('footer.html'); ?>
 
<script>
$(function(){
	$(document).on("click","#paylist .item",function(){
		$("#paylist .item").removeClass("active");
		$("#pay_type").val($(this).attr("v"));
		$(this).addClass("active");
	});
	
	 
});
</script>
</div>
</body>
</html>