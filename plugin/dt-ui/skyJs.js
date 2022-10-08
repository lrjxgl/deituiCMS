var skyJs={
	toast:function(msg,type="success"){
		var style;
		switch(type){
			case "success":
				style="toast-success"
				break;
			case "error":
				style="toast-error"
				break;
			case "warning":
				style="toast-warning"
				break;
			default:
				style="toast-success"
				break;
		}
		 
		var html='<div id="skyJs-toast" class="toast '+style+'">'+msg+'</div>';
		if($("#skyJs-toast").length>0){
			$("#skyJs-toast").html(msg).show();
			
		}else{
			$("body").append(html);
		}
		setTimeout(function(){
			$("#skyJs-toast").hide();
		},2000)
	},
	alert:function(ops){
		var ops=ops;
		if(typeof(ops.title)=="undefined"){
			ops.title="确认提示";
		}
		if(typeof(ops.success)=="undefined"){
			ops.success=function(){
				$("#skyJs-alert").hide();	
			}
		}
		var html='<div >'
				+'	<div class="alert-mask"></div>'
				+'		<div class="alert">'
				+'			<div class="alert-header">'+ops.title+'</div>'
				+'			<div class="alert-msg">'+ops.content+'</div>'
				+'			<div class="alert-ft">'
				+'				<div id="skyJs-alert-success" class="alert-ft-btn alert-ft-success">确认</div>'
				 
				+'			</div>'
				+'		</div>'
				+'	</div>';
		if($("#skyJs-alert").length>0){
			$("#skyJs-alert").html(html).show();
			
		}else{
			$("body").append('<div id="skyJs-alert">'+html+'</div>');
			$("#skyJs-alert").show();
			
		}		
		$(document).one("click","#skyJs-alert-success",function(){
			ops.success();
			$("#skyJs-alert").hide();
		}) 
		 		
	},
	confirm:function(ops){
		var ops=ops;
		if(typeof(ops.title)=="undefined"){
			ops.title="确认提示";
		}
		if(typeof(ops.fail)=="undefined"){
			ops.fail=function(){
				$("#skyJs-confirm").hide();	
			}
		}
		var html='<div >'
				+'	<div class="alert-mask"></div>'
				+'		<div class="alert">'
				+'			<div class="alert-header">'+ops.title+'</div>'
				+'			<div class="alert-msg">'+ops.content+'</div>'
				+'			<div class="alert-ft">'
				+'				<div id="skyJs-fail-success" class="alert-ft-btn alert-ft-fail">取消</div>'
				+'				<div id="skyJs-confirm-success" class="alert-ft-btn alert-ft-success">确认</div>'
				+'			</div>'
				+'		</div>'
				+'	</div>';
		if($("#skyJs-confirm").length>0){
			$("#skyJs-confirm").html(html).show();
			
		}else{
			$("body").append('<div id="skyJs-confirm">'+html+'</div>');
			$("#skyJs-confirm").show(); 
			
		}		
		$(document).off("click","#skyJs-confirm-success");
		$(document).off("click","#skyJs-fail-success");	
		$(document).one("click","#skyJs-confirm-success",function(){
			ops.success();
			$("#skyJs-confirm").hide();
		})
		$(document).one("click","#skyJs-fail-success",function(){
			ops.fail();
			$("#skyJs-confirm").hide();
		}) 		
	},
	showBox:function(ops){
		if(typeof(ops.title)=="undefined"){
			ops.title="确认提示";
		}
		 
		if(typeof(ops.width)=="undefined"){
			ops.width=320;
		}
		if(typeof(ops.height)=="undefined"){
			ops.height=200;
		}
		var width=ops.width;
		var height=ops.height;
		var html='<div class="modal-mask"></div>'
			+'<div class="modal" id="skyJs-showBox-container">'
				+'<div class="modal-header">'
					+'<div class="modal-title">'+ops.title+'</div>'
					+'<div class="modal-close" id="skyJs-showBox-close">关闭</div>'
				+'</div>'
				+'<div class="modal-body">'+ops.content+'</div>'
				+'<div style="height:30px"></div>'
			+'</div>';
			
		if($("#skyJS-showBox").length==0){
			html='<div class="modal-group" id="skyJs-showBox">'+html+'</div>'; 
			$("body").append(html); 
			$("#skyJs-showBox").show();
		}else{
			$("#skyJs-showBox").html(html).show();
		}
		var mt= Math.max(10,parseInt(height)/2);
		$("#skyJs-showBox-container").css({left:'50%',marginLeft:-width/2,width:width-10,minHeight:height,marginTop:-mt});
		$(document).one("click","#skyJs-showBox-close",function(){
			$("#skyJs-showBox").hide();
		}) 
	},
	showPic:function(url){
		var html='<img style="width:100%;height:auto;" src="'+url+'">';
		this.showBox({
			title:"查看大图",
			content:html,
			width:480,
			height:320
		});
	},
	showIframe:function(url){
		 
		var w=$(window).width()-200;
		var h=$(window).height()-100;
		var mh=h-100;
		var html=`
			<style>
				.modal-body{max-height:`+mh+`px;height:`+mh+`px;}
			</style>
			<iframe style="border:0;width:99%;height:98%;" src="`+url+`"></iframe>
		`;
		$("#skyJs-showBox").remove();
		skyJs.showBox({
			title:"新窗口",
			content:html,
			width:w,
			height:h
		})
	}
}