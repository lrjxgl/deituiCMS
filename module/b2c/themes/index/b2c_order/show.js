$(document).on("click","#order-cancel-submit",function(){
	if(confirm("确认取消订单?")){
		$.get("/module.php?m=b2c_order&a=cancel&ajax=1&orderid="+orderid,function(res){
			
			if(!res.error){
				window.location.reload();
			}
		},"json")
	}
})
$(document).on("click","#order-receive-submit",function(){
	$.get("/module.php?m=b2c_order&a=receive&ajax=1&orderid="+orderid,function(res){
		window.location.reload();
	})
})

$(document).on("click","#goPay",function(){
	 
	$.ajax({
		url:"/module.php?m=b2c_order&a=pay&ajax=1&orderid="+orderid,
		dataType:"json",
		success:function(res){
			window.location=res.data.payurl;
		}
	})
})

$(document).on("click","#express-search",function(){
	var express_no=$(this).attr("v");
	var iframe='<iframe style="width:100%;height:400px;border:0;" src="http://m.kuaidi100.com/result.jsp?nu='+express_no+'"></iframe>';
	var html='<div class="modal-mask"></div><div class="modal">'+iframe+'</div>';
	if($("#expressWeb").length>0){
		$("#expressWeb").html(html);
	}else{
		html='<div id="expressWeb" class="modal-group">'+html+'</div>';
		$("body").append(html);
	}
	
	$("#expressWeb").show();
})