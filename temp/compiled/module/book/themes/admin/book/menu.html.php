<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link href="/plugin/skyweb/skyweb.css" rel="stylesheet"  />
		<style>
			.btn{
				width: 200px;
			}
		</style>
	</head>
	<body>
		<textarea id="content" style="width: 90%; height:400px ; line-height: 30px; margin-bottom: 10px;"><?php echo $this->_var['artMenu']; ?></textarea>
		<div class="btn btn-success" id="submit">保存</div>
		<script src="/plugin/jquery/jquery-2.1.3.min.js"></script>
<script src="/plugin/skyweb/skyweb.js"></script>
<script>
	var bookid="<?php echo $this->_var['book']['bookid']; ?>";
	$(document).on("click","#submit",function(){
		$.post("/moduleadmin.php?m=book&a=menusave&ajax=1",{
			bookid:bookid,
			content:$("#content").val()
		},function(data){
			skyToast(data.message);
			if(!data.error){
				window.parent.location.reload();
			}
		},"json")
	})
</script>
	</body>
</html>
