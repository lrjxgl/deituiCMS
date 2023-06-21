function is_weixn(){  
	 var ua = navigator.userAgent.toLowerCase();  
	 if(ua.match(/MicroMessenger/i)=="micromessenger") {  
		 return true;  
	 } else {  
		 return false;  
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
	},2000)
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

/**短信验证码****/
//倒计时
var smsCountDown={
	time:60,
	timer:60,
	sendClass:"js-sendBtn",
	el:".input-flex-btn",
	disClass:"btn-light",
	init:function(){
		this.countdown();
	},
	forbid:function(){
		console.log("forbid");
		$(this.el).addClass(this.disClass)
	},
	allow:function(){
		console.log("allow");
		$(this.el).removeClass(this.disClass).addClass(this.sendClass);
	},
	countdown:function(){
		var that=this;
		if(this.timer==0){
			$(this.el).addClass(this.sendClass).removeClass(this.disClass);
			$(this.el).text("发送验证码")
			this.timer=this.time;
			return;
		}else{
			$(this.el).addClass(this.disClass).removeClass(this.sendClass);
			$(this.el).text('重新发送(' + this.timer + ')')
			this.timer--;
		}
		setTimeout(function(){
			that.countdown();
		},1000)
	}
};
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
var isPageHide = false;
window.addEventListener('pageshow', function () {		
 if (isPageHide) {
	 
	isPageHide=false;
	 skyToast("页面刷新中...");
	window.location.reload(); 	
 } 
});
$(function(){
	$(document).on("click",".js-pageHide",function(){
		isPageHide=true;
	})
	$(document).on("click", ".js-tabs-border-item", function() {
		var $group = $(this).parents(".tabs-border-group");
		var index = $(this).index();
		if ($group.length > 0) {
			$group.find(".tabs-border-box").removeClass("tabs-border-box-active");
			$group.find(".tabs-border-box").eq(index).addClass("tabs-border-box-active");
		}
		$(this).addClass("tabs-border-active").siblings().removeClass("tabs-border-active");
	})

	$(document).on("click", ".tabs-toggle-hd", function() {
		var $p = $(this).parents(".tabs-toggle");
		var $group = $(this).parents(".tabs-toggle-group");
		var isactive = $p.find(".tabs-toggle-hd").hasClass("tabs-toggle-hd-active");
		console.log(isactive);
		if ($group.length > 0) {
			$group.find(".tabs-toggle-hd").removeClass("tabs-toggle-hd-active");
			$group.find(".tabs-toggle-box").removeClass("tabs-toggle-active");
		}
		if (!isactive) {
			$p.find(".tabs-toggle-hd").toggleClass("tabs-toggle-hd-active");
			$p.find(".tabs-toggle-box").toggleClass("tabs-toggle-active");
		}
	})
	$(document).on("click",".js-switch",function(){
		var p=$(this).parents("switch-group");
		$(".switch-value").val($(this).siblings(".js-switch").attr("data-value"));
		 
		$(this).removeClass("switch-active").siblings(".js-switch").addClass("switch-active");
	})
	$(document).on("click","[gourl]",function(){
		var url=$(this).attr("gourl");
		window.location=url;
	})
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
	$(document).on("click",".header-back",function(){
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
	$(document).on("click",".modal-close,.modal-mask,.modal-cancel",function(){
		$(this).parents(".modal-group").hide();
	})
	$(document).on("click",".js-submit",function(){
		if(!postCheck.canPost()){
			return false;
		}
		var obj=$(this);
		$.post(
			$(this).parents("form").attr("action")+"&ajax=1",
			$(this).parents("form").serialize(),
			function(res){
				skyToast(res.message);
				if(res.error){
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
		if(confirm("删除后不可恢复，确认删除吗?")){
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
