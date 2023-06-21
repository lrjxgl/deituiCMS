 
$.get("/admin.php?m=index&a=CheckNewVersion&ajax=1",function(res){
	shouquan();
	if(res.data.isnew==1){
		$("#newVersion").html("V"+res.data.version_num);
		$("#newVersion-desc").html(res.data.desc);
		 
		$("#update-btn").show();
	}else{
		$("#newVersion").html("V"+res.data.version_num);
		$("#newVersion-desc").html(res.data.desc);
	}
},"json");
function shouquan(){
	$.get("/admin.php?m=index&a=shouquan",function(res){
		
			if(res.issq){
				$("#sqRes").html("您已获得商业授权");
				 
			}else{
				$("#update-btn").hide();
				$("#sqRes").html('您还未获得商业授权，无法在线更新');
			}
	},"json");
}

$(document).on("click","#update-btn",function(){
	skyJs.confirm({
		content:"更新前请做好数据备份，确定更新吗？",
		success:function(){
			skyJs.alert({
				content:"正在升级请耐心等待..."
			});
			$.get("/admin.php?m=index&a=update",function(data){
				if(data.error){
					skyJs.toast(data.message);
					 
					return ;
				}
				skyJs.alert({
					content:"升级成功"
				});
				setTimeout(function(){
						window.location.reload();
				},600);
				
			},"json")
		}
	})
	 
});