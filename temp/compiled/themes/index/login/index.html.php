<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body class="fullBody bg-fff">
		<div class="header-back-fixed goBack"></div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="flex-center pd-10 bg-fff">
				<image class="wh-100 bd-radius-50" src="/static/images/logo.png"></image>


			</div>
			<input type="hidden" id="backurl" name="backurl" value="<?php echo $this->_var['backurl']; ?>" />
	
			<div class="input-flex">
				<div class="input-flex-label">手机</div>
				<input type="text" class="input-flex-text" id="telephone" name="telephone" placeholder="请输入手机号码" />
			</div>
			<div class="input-flex">
				<div class="input-flex-label">密码</div>
				<input type="password" class="input-flex-text" id="password" type="text" placeholder="请输入密码" passowrd />
			</div>
			<div class="row-box">
				<div class="btn-row-submit" id="login-submit">登录</div>
				<div class="flex pdl-10 pdr-10">
					<a class="cl2 mgb-10" href="index.php?m=login&a=findpwd">找回密码</a>
					<div class="flex-1"></div>
					<a class="mgb-10 cl2" href="index.php?m=register">立即注册</a>
					
				</div>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
		$(function(){
			$(document).on("click","#login-submit",function(){		
				$.post("/index.php?m=login&a=loginSave&ajax=1",{
					telephone:$("#telephone").val(),
					password:$("#password").val(),
					backurl:$("#backurl").val()
				},function(data){
					if(data.error==1){
						skyToast(data.message);
					}else{
						skyToast("登陆成功");
						setTimeout(function(){
							window.location=data.data.backurl;
						},700);
					}
				},"json");
			});
		});
		</script>
	</body>
</html>
