var APPADMIN="/admin.php";
var postCheck={
	inSubmit:false,
	timer:0,
	canPost:function(){
		var that=this;
		if(this.inSubmit){
			return false;
		}
		if(this.timer>0){
			clearTimeout(this.timer);
		}
		this.inSubmit=true;
		this.timer=setTimeout(function(){
			that.inSubmit=false;
		},1000)
		return true;
	}
}

function skyToast(msg){
	var html='<div id="toast" class="toast toast-success">'+msg+'</div>';
	if($("#toast").length>0){
		$("#toast").html(msg).show();
		
	}else{
		$("body").append(html);
	}
	setTimeout(function(){
		$("#toast").hide();
	},3000)
}

/*弹框*/
function showbox(title,content,width,height){
	var html='<div class="modal-mask"></div>'
		+'<div class="modal" id="showbox-container">'
			+'<div class="modal-header">'
				+'<div class="modal-title">'+title+'</div>'
				+'<div class="modal-close" onclick="showboxClose()">关闭</div>'
			+'</div>'
			+'<div class="modal-body">'+content+'</div>'
			+'<div style="height:30px"></div>'
		+'</div>';
		
	if($("#showBox").length==0){
		html='<div class="modal-group" id="showBox">'+html+'</div>'; 
		$("body").append(html); 
		$("#showBox").show();
	}else{
		$("#showBox").html(html).show();
	}
	var mt= Math.max(10,parseInt(height)/2);
	$("#showbox-container").css({left:'50%',marginLeft:-width/2,width:width-10,minHeight:height,marginTop:-mt});
	setTimeout(function(){
		width=$("#showbox-container").css("width");
		height=$("#showbox-container").css("height");
		height=parseInt(height);
		width=parseInt(width);
		var mt= Math.max(10,parseInt(height)/2);
		$("#showbox-container").css({width:width-10,minHeight:height,marginTop:-mt});
	},300);
	 
}

function showboxClose(){
	$("#showBox").hide();
}

function goBack(){
	var backurl=document.referrer;
	if(backurl==''){
		window.location="/";
	}else{
		window.history.back()
	}
	
}

$(function(){
	$(document).on("click",".goBack",function(){
		var backurl=document.referrer;
		
		if(backurl==''){
			var obj=$(this);
			if(obj.attr("url")!=undefined){
				window.location=obj.attr("url");
			}else{
				window.location="/";
			}
		}else{
			window.history.back();
		}	
		
	})
	$(document).on("click","[gourl]",function(){
		var url=$(this).attr("gourl");
		window.location=url;
	})
	$(document).on("click",".js-submit",function(){
		var obj=$(this);
		if(!postCheck.canPost()){
			return false;
		}
		$.post(
			$(this).parents("form").attr("action")+"&ajax=1",
			$(this).parents("form").serialize(),
			function(data){
				skyToast(data.message);
				if(data.error){
					return false;
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
		var msg="删除后不可恢复，确认删除吗?";
		if($(this).attr("msg")!=undefined){
			msg=$(this).attr("msg");
			 
		}
		if(confirm(msg)){
			$.get($(this).attr("url"),function(data){
				if(data.error=='0'){
					obj.parents("tr").remove();
					obj.parents(".js-item").remove();
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
			if(res.error){
				skyToast(res.message);
				return false;
			}
			if(res.data==1){
				obj.addClass("yes").removeClass("no");
			}else{
				obj.addClass("no").removeClass("yes");
			}
		},"json")
	})
	//加入黑名单
	$(document).on("click",".js-join-blacklist",function(){
		var userid=$(this).attr("userid");
		skyJs.confirm({
			content:"确认拉黑用户吗？",
			success:function(){
				$.post(APPADMIN+"?m=blacklist&a=add&ajax=1",{userid:userid},function(res){
					skyToast(res.message);
					 
				},"json");
			}
		})
		
	})
	//加入手机黑名单
	$(document).on("click",".js-join-blacklist",function(){
		var userid=$(this).attr("userid");
		skyJs.confirm({
			content:"确认拉黑用户吗？",
			success:function(){
				$.post(APPADMIN+"?m=blacklist&a=add&ajax=1",{userid:userid},function(res){
					skyToast(res.message);
					 
				},"json");
			}
		})
		
	})
	//禁止言论
	$(document).on("click",".js-forbid-post",function(){
		var userid=$(this).attr("userid");
		skyJs.confirm({
			content:"确认禁言用户吗？",
			success:function(){
				$.post(APPADMIN+"?m=blacklist_post&a=add&ajax=1",{userid:userid},function(res){
					skyToast(res.message);
					 
				},"json");
			}
		})
		
	})
	
	//iframe弹框
	$(document).on("click",".js-iframe-btn",function(){
		var url=$(this).attr("url");
		var w=$(window).width()-200;
		var h=$(window).height()-100;
		var mh=h-100;
		var html=`
			<style>
				.modal-body{max-height:`+mh+`px;height:`+mh+`px;}
			</style>
			<iframe style="border:0;width:99%;height:98%;" src="`+url+`"></iframe>
		`;
		skyJs.showBox({
			title:"新窗口",
			content:html,
			width:w,
			height:h
		})
	})
	
})