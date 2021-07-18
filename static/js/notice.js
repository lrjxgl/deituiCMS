$(function(){
	$.get("/index.php?m=notice&ajax=1",function(data){
		var html='';
		if(data.error){
			
			return '';
		}
		if(data.data.data.length>0){
			console.log("notice");
			var sdata=data.data.data;
			for(var i=0;i<sdata.length;i++){
				html+='<div class="item">'+sdata[i].content+'<span class="tan-notice-read js-notice-read"  v="'+sdata[i].id+'">x</span></div>';
				
			}
			if($("#js-notice-box").length>0){
				
				$("#js-notice-box box").html(html);
			}else{
				var css='<style>'
				+'.tan-notice-box{position:fixed;z-index:99999 ;right:0px;top:40%;opacity:0.9;}'
				+'.tan-notice-hd{color:#666; cursor:pointer; box-sizing: border-box; width:34px; padding:10px;background-color:#fff;text-align:center;line-height:18px;font-size:14px}'
				+'.tan-notice-con{display:none;}'
				+'.tan-notice-close{position:absolute;right:10px;top:10px;display:none;width:30px;height:30px;font-size: 14px;line-height: 30px;}'
				+'.tan-notice-active{top:0px;bottom:0px; background-color:#fff;left:0px;z-index:999;}'
				+'.tan-notice-active .tan-notice-close{display:block;}'
				+'.tan-notice-active .tan-notice-hd{color:#333; width:100%; line-height:30px;font-size:18px;border-bottom:1px solid #eee; margin-bottom:10px;}'
				+'.tan-notice-active .tan-notice-con{display:block;padding:5px;}'
				+'.tan-notice-con .item{position:relative; margin-bottom:10px;border-bottom:1px solid #eee; padding-bottom:10px;font-size:14px;padding-right:30px;}'
				+'.tan-notice-read{cursor:pointer;position:absolute;right:5px; top:0px;color:red;text-align:center;width:30px;line-height:30px;font-size:16px;}'
				+'</style>';
				html=css+'<div class="tan-notice-box" id="js-notice-box">'
				+'<div class="tan-notice-hd" id="js-notice-hd">新消息</div>'
				+'<div class="tan-notice-close" id="js-notice-close">关闭</div>'
				+'<div class="tan-notice-con">'+html+'</div>'
				+'</div>';
				$("body").append(html);
				
			}
			$("#js-notice-box").show();
		}
		
		$(document).on("click","#js-notice-close",function(){
			$("#js-notice-box").removeClass("tan-notice-active");
			if($("#js-notice-box .item").length==0){
					$("#js-notice-box").hide();
				}
		})
		
		$(document).on("click","#js-notice-hd",function(){
			$("#js-notice-box").toggleClass("tan-notice-active");
			if($("#js-notice-box .item").length==0){
					$("#js-notice-box").hide();
				}
		})
		
		$(document).on("click",".js-notice-read",function(){
			var id=$(this).attr("v");
			var obj=$(this);
			$.get("/index.php?m=notice&a=delete&ajax=1&id="+id,function(data){
				obj.parents(".item").remove();
				if($("#js-notice-box .item").length==0){
					$("#js-notice-box").hide();
				}
			},"json")
		})
	},"json")
})
