<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<style>
	.userhead{
		text-align: center;
	}
	#head{
		max-height: 300px;
		max-width: 100%;
		margin-bottom: 5px;
	}
 	.main-body{
 		padding: 10px;
 	}
	#image{max-width: 100%; max-height: 300px; display: none;}
	.rtools{
		text-align: center;
	}
	.cropper-container{
		margin-bottom: 10px;
	}    
</style>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">头像编辑</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div id="page">
				<div class="mgb-10 flex-center" id="userhead">
					<img id="head" src="<?php echo $this->_var['data']['user_head']; ?>.100x100.jpg" class="wh-100">
				</div>
		
			<img id="image"  />
			<div class="flex flex-center">
				<button class="btn  mgr-10" id="js-up">上传头像</button>
			<button class="btn btn-success" id="js-save">保存头像</button>
			</div>

			<input style="display: none;" type="file" id="file" />
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/cropper/cropper.min.js"></script>
		<link href="/plugin/cropper/cropper.min.css" rel="stylesheet">
		<script>
			$(function(){
				$(document).on("click","#head",function(){
					$("#file").click();
				})
				$(document).on("click","#js-up",function(){
					$("#file").click();
				})
			
			$(document).on("click","#js-save",function(){
				console.log("js-save");
			 	var dataURL = $img.cropper("getCroppedCanvas");
			 	var imgurl = dataURL.toDataURL("image/jpeg", 0.3);  	
				$.post("/index.php?m=upload&a=Base64_user_head&ajax=1",{
					content:imgurl
				},function(imgdata){
					
					if(!imgdata.error){
						var  imgdata=imgdata;
						$.post("/index.php?m=user&a=user_head_save&ajax=1",{
							user_head:imgdata.imgurl
						},function(data){
							if(!data.error){
								$('#image').cropper("destroy").hide();
								$("#head").attr("src",imgdata.trueimgurl);
								$("#userhead").show();
							}
							 
						},"json")
					}
				 
				},"json")
			
				
			})
			
		 	$(document).on("change","#file",function(e){
		 		var file=e.target.files[0];
		  		var url = window.URL || window.webkitURL || window.mozURL;
		  		if(url) {
					src = url.createObjectURL(file);
				} else {
					src = e.target.result;
				}
				$("#image").attr("src",src).show();
				$("#userhead").hide();
				
				$('#image').cropper("destroy");
				$img=$('#image');
				$img.cropper({
				  aspectRatio: 1 / 1,
				  crop: function(e) {
				  	//console.log(e)
				  }
				});
				
		 	})
			})
		</script>
	</body>
</html>
