<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body class="fullBody bg-fff">
		<div class="header-back-fixed goBack"></div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="flex-center pd-10 bg-fff">
				<image class="wh-100 bd-radius-50" src="<?php echo $this->_var['site']['logo']; ?>.100x100.jpg"></image>


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
			 
			<?php if (INWEIXIN): ?>
			<div class="otherBox mgb-20">
				<div class="otherBox-line"></div>
				<div class="otherBox-text">其它方式登录</div>
			</div>
			<div class="flex flex-center mgb-20">
				<div gourl="/index.php?m=open_weixin&a=Geturl" class="btn btn-round bg-success iconfont icon-weixin"></div>
			</div>
			<?php endif; ?>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<style>
			.otherBox {
			position: relative;
			height: 36px;
		}
		
		.otherBox-line {
			width: 100%;
			height: 1px;
			background-color: #d0d0d0;
			top: 14px;
			position: absolute;
		}
		
		.otherBox-text {
			background-color: #fff;
			text-align: center;
			padding: 0px 11px;
			line-height: 36px;
			position: absolute;
			width: 120px;
			left: 50%;
			margin-left: -60px;
			color: #646464;
		
		}
		</style>
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
