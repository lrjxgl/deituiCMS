<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">找回密码</div>
		</div>
		<div class="header-row"></div>
		<form id="fdForm">
			<div class="input-flex">
				<div class="input-flex-label">手机</div>
				<input class="input-flex-text" id="telephone" name="telephone" placeholder="请输入手机号码" />
			</div>
			<div class="input-flex">					
				<div class="input-flex-label">验证码</div>					 
				<input type="text" name="yzm" class="input-flex-text">				 
				<div class="input-flex-btn" id="sendSms">获取验证码</div>
			</div>
		 
			<div class="input-flex">
				<div class="input-flex-label">密码</div>
				<input class="input-flex-text" name="password" type="password" placeholder="请输入密码" type="password" />
			</div>
			<div class="input-flex">
				<div class="input-flex-label">重复密码</div>
				<input class="input-flex-text" name="password2" placeholder="请再次输入密码" type="password" />
			</div>
			<div class="btn-row-submit" id="login-submit">登录</div>
		</form>
		<?php echo $this->fetch('footer.html'); ?>
		<script type="text/javascript">
			$(document).on("click","#sendSms",function(res){
				var telephone=$("#telephone").val();
				$.get("/index.php?m=login&a=SendSms&ajax=1",{
					telephone:$("#telephone").val(),
				},function(res){
					skyToast(res.message);
				},"json");
			})
			$(document).on("click","#reg-submit",function(){
				$.post("/index.php?m=login&a=FindPwdSave&ajax=1",$("#fdForm").serialize(),function(res){
					skyToast(res.message);
					if(res.error){
						window.location="/";
					}
				},"json");
			})
		</script>
	</body>
</html>
