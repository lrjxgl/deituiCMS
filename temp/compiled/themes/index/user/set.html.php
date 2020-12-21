<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">设置</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div class="row-box">
				
				<div class="row-item"  gourl="/index.php?m=user&a=info">
					<div class="row-item-icon icon-people"></div>
					<div class="flex-1"> <?php echo $this->_var['data']['nickname']; ?></div>
					
				</div>
				
				<div class="row-item" gourl="/index.php?m=user&a=password" >
					<div class="row-item-icon icon-password"></div>
					<div class="flex-1">登录密码</div>
				</div>
				<div class="row-item" gourl="/index.php?m=user&a=paypwd" >
					<div class="row-item-icon icon-password"></div>
					<div class="flex-1">支付密码</div>
				</div> 
			</div>
			
			<div class="btn-row-submit bg-danger js-logout" >注销</div>
			
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			$(function(){
				$(document).on("click",".js-logout",function(){
					$.get("/index.php?m=login&a=logout&ajax=1",function(res){
						window.location="/index.php?m=login"
					},"json")
				})
			})
		</script>
	</body>
</html>