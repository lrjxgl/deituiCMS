function skyToast(message,type){
	if(typeof(type)=="undefined"){
		type="";
	}
	if($("#toast").length==0){
		var html="<div id='toast'><div class='bg "+type+"'>"+message+"</div></div>";
		$("body").append(html);		
	}else{
		$("#toast").html("<div class='bg "+type+"'>"+message+"</div>");
	}
	$("#toast").show();
	setTimeout(function(){
		$("#toast").hide();
	},2000);
}

function goBack(){
	window.history.back();
}

$(function(){
	$(document).on("click",".js-submit",function(){
		var obj=$(this);
		$.post(
			$(this).parents("form").attr("action")+"&ajax=1",
			$(this).parents("form").serialize(),
			function(data){
				skyToast(data.message)
				if(obj.attr("ungo")=="1"){
					return true;
				}else{
					setTimeout(function(){
						window.history.back();
					},1000)
					
				}
			},
			"json"
		);
		
	})
	
	//删除
	$(".js-delete").click(function(){
		var obj=$(this);
		if(confirm("删除后不可恢复，确认删除吗?")){
			$.get($(this).attr("url"),function(data){
				if(data.error=='0'){
					obj.parents("tr").remove();
				}else{
					alert(data.message);
				}
			},"json");
			
		}
	});
	
	$(document).on("click",".ajax_yes",function()
	{
		
		$.get($(this).attr("url"));
		$(this).attr("src","/static/images/yes.gif");
		var url=$(this).attr("url");
		$(this).attr("url",$(this).attr("rurl"));
		$(this).attr("rurl",url);
		$(this).removeClass("ajax_yes").addClass("ajax_no");
	});
	
	$(document).on("click",".ajax_no",function()
	{
		$.get($(this).attr("url"));
		$(this).attr("src","/static/images/no.gif");
		var url=$(this).attr("url");
		$(this).attr("url",$(this).attr("rurl"));
		$(this).attr("rurl",url);
		$(this).removeClass("ajax_no").addClass("ajax_yes");
	});
})