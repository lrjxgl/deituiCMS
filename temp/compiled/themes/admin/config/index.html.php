<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body> 
<div class="tabs-border" id="myTab">
	<div href="c_base"  class="item active">基本设置</div>
	<div href="c_email" class="item">邮箱设置</div>
 
	<div href="c_water" class="item">水印设置</div>
	<div href="c_sms" class="item">短信设置</div>
	<div href="c_invite" class="item">邀请设置</div>
	<div href="c_pay" class="item">支付设置</div>
	 
 
</div>	
<div class="main-body">
  
  
    
    <form method="post" id="t-form" action="/admin.php?m=config&a=save">
      <div class="tab-content">
        <div class="tabs-border-box tabs-border-box-active" id="c_base"><?php echo $this->fetch('config/base.html'); ?></div>
   
        <div class="tabs-border-box" id="c_water"><?php echo $this->fetch('config/water.html'); ?></div>
        <div class="tabs-border-box" id="c_sms"><?php echo $this->fetch('config/sms.html'); ?></div>
        <div class="tabs-border-box" id="c_invite"><?php echo $this->fetch('config/invite.html'); ?></div>
        <div class="tabs-border-box" id="c_pay"><?php echo $this->fetch('config/pay.html'); ?></div>
        
        <div class="tabs-border-box" id="c_email"><?php echo $this->fetch('config/email.html'); ?></div>
         
      </div>
			<div class="btn-row-submit js-submit" ungo="1">保存</div>
      
    </form>
  </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
<script >
$(".tab-content tr").find("td:eq(0)").css("width","100px");
$('#myTab .item').click(function (e) {
	 var id=$(this).attr("href");
	 $(this).addClass("active").siblings().removeClass("active");
	  
	  $("#"+id).addClass("tabs-border-box-active").siblings().removeClass("tabs-border-box-active");
});
$("#testphone").click(function(){
		$.get("<?php echo $this->_var['appadmin']; ?>?m=config&a=testphone",$("#t-form").serialize(),function(data){
			alert(data)
		})
});

$("#testemail").click(function(){
	$.get('<?php echo $this->_var['appadmin']; ?>?m=config&a=testemail',$("#t-form").serialize(),function(data){ 
    	$('.testemail_res').html(data); 
    });
});

</script>
</body>
</html>