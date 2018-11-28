<!doctype html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 
 
  <div class="tabs-border" style="margin-bottom: 10px;">
		<a href="/admin.php?m=tixian" class="item  <?php if (get ( 'type' ) == ''): ?>active<?php endif; ?>">新申请</a>
		<a href="/admin.php?m=tixian&type=confirm" class="item <?php if (get ( 'type' ) == 'confirm'): ?>active<?php endif; ?>">待转账</a>
		<a href="/admin.php?m=tixian&type=finish" class="item <?php if (get ( 'type' ) == 'finish'): ?>active<?php endif; ?>">已完成</a>
		<a href="/admin.php?m=tixian&type=all" class="item <?php if (get ( 'type' ) == 'all'): ?>active<?php endif; ?>">全部提现</a>
	</div>
 <div class="main-body">
 	<form class="search-form" method="get" action="<?php echo $this->_var['appadmin']; ?>">
	<input type="hidden" name="m" value="tixian" /> 
	<input type="hidden" id="type" name="type" value="<?php echo $_GET['type']; ?>" /> 
	姓名：<input class="w100" type="text" id="yhk_huming" name="yhk_huming" value="<?php echo $_GET['yhk_huming']; ?>" />
	下单时间：从
	<input  class="w100" type="text" id="stime" name="stime" value="<?php echo $_GET['stime']; ?>" /> 
	到
	<input  class="w100" type="text" id="etime" name="etime" value="<?php echo $_GET['etime']; ?>" /> 
	
	<a class="js-down-excel pointer" >导出excel</a>
	<input type="submit" value="搜索" class="btn" />
</form>
 	<div class="list">
  
    
   <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <div class="item" onclick="window.location='<?php echo $this->_var['appadmin']; ?>?m=tixian&a=show&id=<?php echo $this->_var['t']['id']; ?>'">
    <div class="hd">
    	<span class="status"><?php echo $this->_var['t']['status_name']; ?></span>
    	<span class="status">来自：<?php if ($this->_var['t']['k'] == 'shop'): ?>商家<?php else: ?>用户<?php endif; ?></span>
    	提现金额：<span class="status">￥<?php echo $this->_var['t']['money']; ?></span>
    	<span class="fr"><?php echo date("Y-m-d H:i:s",$this->_var['t']['dateline']); ?></span></div>
    
     <div class="info"><?php echo $this->_var['t']['info']; ?></div>
 
     <div class="content">
     	提现至
     <?php if ($this->_var['t']['paytype'] == "alipay"): ?>
     <span class="status">支付宝</span>
     <?php elseif ($this->_var['t']['paytype'] == "wxpay"): ?>
     <span class="status">微信</span>
     <?php else: ?>
   	  银行卡
     <?php endif; ?>
     	<?php if ($this->_var['t']['paytype'] != 'bank'): ?>
     	<span>姓名：<?php echo $this->_var['t']['yhk_huming']; ?></span>
        <span>账号：<?php echo $this->_var['t']['yhk_haoma']; ?></span>
     	<?php endif; ?>
     	<?php if ($this->_var['t']['paytype'] == "bank"): ?>
     	 
	     	<span>户名：<?php echo $this->_var['t']['yhk_huming']; ?></span>
	        <span>号码：<?php echo $this->_var['t']['yhk_haoma']; ?></span>
	       
	        <br>
	        <span>银行：<?php echo $this->_var['t']['yhk_name']; ?></span>
	        <span>开户地址：<?php echo $this->_var['t']['yhk_address']; ?></span>
        <?php endif; ?>
        <span>电话：<?php echo $this->_var['t']['telephone']; ?></span>
     </div> 
    <?php if ($this->_var['t']['reply']): ?><div class="content"><?php echo $this->_var['t']['reply']; ?> 处理时间：<?php echo date("Y-m-d H:i:s",$this->_var['t']['redateline']); ?></div><?php endif; ?>
    
   </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
  <div><?php echo $this->_var['pagelist']; ?></div>
  
</div>

<style>
	.list .item{
		cursor: pointer;
		font-size: 14px;
		line-height: 1.5;
		color: #646464;
 
		margin-bottom: 10px;
		 
		 
		 
		border: 5px solid #ddd;;
 
		padding: 20px;
		box-sizing: border-box;
	}
	.list .status{
		color: #f60;
		margin-right: 20px;
	}
</style>
<?php echo $this->fetch('footer.html'); ?>
<script src="/plugin/laydate/laydate.js"></script>
<script>
	laydate.render({
		elem:"#stime",
		type: 'date'
	})
	laydate.render({
		elem:"#etime",
		type: 'date'
	})
	$(document).on("click",".js-down-excel",function(){
		var type=$("#type").val();
		var yhk_huming=$("#yhk_huming").val();
		var stime=$("#stime").val();
		var etime=$("#etime").val();
		var url="/admin.php?m=tixian&a=excel";
		url=url+"&type="+type;
		url=url+"&yhk_huming="+encodeURI(yhk_huming);
		url=url+"&stime="+stime;
		url=url+"&etime="+etime;
		window.location=url;
	})
</script>
</body>
</html>
