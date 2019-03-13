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
function skyAlert(content,title){
	if(title==undefined){
		title="确认提示";
	}
	var html='<div class="alert-mask"></div>'
			+'<div class="alert">'
			+'	<div class="alert-header">'+title+'</div>'
			+'	<div class="alert-msg">'+content+'</div>'
			+'	<div class="alert-ft"><div onclick="skyAlertClose()" class="alert-ft-btn alert-ft-success">确定</div></div>'
			+'</div>';
		
	if($("#skyAlertBox").length>0){
		$("#skyAlertBox").html(html).show();
	}else{
		var html='<div class="alert-group" id="skyAlertBox" style="display: flex;">'+html+'</div>'
		$("body").append(html);
	}	
}
function skyAlertClose(){
	$("#skyAlertBox").hide();
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
				skyToast(data.message);
				if(data.error){
					retrn false;
				}
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
	$(document).on("click",".js-delete",function(){
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
	
	$(document).on("click",".js-tabs a",function(e){ 
		e.preventDefault();
		var p=$(this).parents(".tabs-box");
		p.find("a").removeClass("active");
		p.find(".tabs-hd").hide();
		$(this).addClass("active");
		
		var href=$(this).attr("href");
		if(href.match(/#/)){
			 var id=href.substr(1);
			 $(".tabs-item").hide();
			 $("#"+id).show();
		}else{
			var id=$(this).attr("data-id");
			if(id==null){
				window.location=href;
			}else{
				$.get(href,function(data){			
					$(".tabs-item").hide();				
					$("#"+id).html(data).show();
				});
			}
		}
	});
	
	$(document).on("click",".js-toggle-status",function(){
		var id=$(this).attr("v");
		var obj=$(this);
		var url=$(this).attr("url")
		$.get(url,function(res){
			if(res.data==1){
				obj.addClass("yes").removeClass("no");
			}else{
				obj.addClass("no").removeClass("yes");
			}
		},"json")
	})
})