function skyToast(msg){
	var html='<view id="toast" class="toast toast-success">'+msg+'</view>';
	if($("#toast").length>0){
		$("#toast").html(msg).show();
		setTimeout(function(){
			$("#toast").hide();
		},1000)
	}else{
		$("body").append(html);
	}
}
$(function(){
	$(document).on("click","[gourl]",function(){
		var url=$(this).attr("gourl");
		window.location=url;
	})
	$(document).on("click",".goBack",function(){
		window.history.back();
	})
	$(document).on("click",".header-back",function(){
		window.history.back();
	})
})
