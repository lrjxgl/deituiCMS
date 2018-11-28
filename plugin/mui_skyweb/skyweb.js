/*Start toast*/
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
/*End toast*/
/***评分插件****/
function js_raty(id,grade,num){
		if(num==undefined){
			num=5;
		}
		var html="";
		for(i=0;i<grade;i++){
			html=html+'<i  class="raty-good"></i>';
		}
		var j=Math.max(0,num-grade);
		for(i=0;i<j;i++){
			html=html+'<i  class="raty-bad"></i>';
		}
		$(id).find(".m-raty-level").html(html);
		$(id).find(".raty-grade").val(grade);
		$(id).find(".raty-text").html("+"+grade);
	}
/*文件上传*/
function skyUpload(upid,url,success,error,uploadProgress)
{
		 var vFD = new FormData();
		 var f= document.getElementById(upid).files;
		 $("#"+upid+"loading").show();
		 for(var i=0;i<f.length;i++){ 
		vFD.append('upimg', document.getElementById(upid).files[i]);
		// create XMLHttpRequest object, adding few event listeners, and POSTing our data
		var oXHR = new XMLHttpRequest();        
		oXHR.addEventListener('load', success, false);
		oXHR.addEventListener('error', error, false);
		if(uploadProgress!=undefined){
			oXHR.upload.addEventListener("progress", uploadProgress, false);
		}
		oXHR.open('POST',url);
		oXHR.send(vFD);
	
		 }
}
/*
function uploadFinish(e){
		var data=eval("("+e.target.responseText+")");
		$("#uploading").hide()
		if(data.error != '')
        {
           skyToast(data.msg);
        }else
        {
            $("#imgShow").html("<img src='/"+data.imgurl+".100x100.jpg' width='100'>");
			$("#imgurl").val(data.imgurl);
         }
}
	
function uploadError(e) { // upload error
		skyToast("上传出错了");
}
*/

function err_user_head(obj,t){
	//event.preventDefault();
	if(t==1){
		obj.src="/static/images/user_head.jpg.small.jpg";
	}else{
		obj.src="/static/images/user_head.jpg.100x100.jpg";
	}
	
}
function err_imgurl(obj,t){
	//event.preventDefault();
	if(t==1){
		obj.src="/static/images/no_image.jpg.small.jpg";
	}else if(t==2){
		obj.src="/static/images/no_image.jpg.middle.jpg";
	}else{
		obj.src="/static/images/no_image.jpg.100x100.jpg";
	}
}
/*弹框*/
function showbox(title,content,width,height){
	if($("#showbox_container").length==0){
		var html='<div id="showBox_opac" ></div><div id="showBox" onDblClick="showboxClose()" style=" width:100%; height:100%;  "><div id="showbox_container"><div id="showBox_nav"><div id="showBox_title">  </div><div id="showBox_close" onclick="showboxClose()">关闭</a></div></div><div id="showBox_content"></div><div id="showBox_footer"></div></div></div>'; 
		$("body").append(html); 
	}
	$("#showBox_title").html(title);
	$("#showBox_content").html(content);
	$("#showBox").show();
	$("#showBox_opac").show();
	var mt= Math.max(10,( window.innerHeight-parseInt(height))/2);
	$("#showbox_container").css({width:width-10,minHeight:height,marginTop:mt});
	setTimeout(function(){
		width=$("#showbox_container").css("width");
		height=$("#showbox_container").css("height");
		height=parseInt(height);
		width=parseInt(width);
		var mt= Math.max(10,( window.innerHeight-parseInt(height))/2);
		$("#showbox_container").css({width:width-10,minHeight:height,marginTop:mt});
	},300);
	 
}

function showboxClose(){
	$("#showBox_opac").hide();
	$("#showBox_content").html("");
	$("#showBox").css("display","none");
}
function goBack(){
	window.history.back();
 
}
$(function(){
	
	$(document).on("click",".js-submit",function(){
		var p=$(this).parents("form");
		var url=p.attr("action")+"&ajax=1";
		$.post(url,p.serialize(),function(data){
			mui.toast(data.message);
			if(data.error==0){
				if(p.attr("ungo")!=1){
					setTimeout(function(){
						goBack();
					},300);
				}
				
			}
			
		},"json")
	})
	
	$(document).on("click",".goBack",function(e){
		 
		window.history.back();
		e.preventDefault();
		var href=$(this).attr("href");
		if(href=="" || href==undefined){
			href="/";
		}
		setTimeout(function(){
			window.location=href;
		},600);
		
	});
	
	$(document).on("click",".js-delete",function(){
		var obj=$(this); 
		var url=$(this).attr("url");
		if(confirm("确认删除吗?")){
			$.get(url,function(data){
				mui.toast(data.message);
				obj.parents(".item").remove();
			},"json")
		}
		
	})
	
	$(document).on("click",".js-raty i",function(){
		var num = $(this).index();
		var pmark = $(this).parents('.m-raty-level');
 
		
		var list = $(this).parent().find('i');
		for(var i=0;i<=num;i++){
			list.eq(i).attr('class','raty-good');
		}
		for(var i=num+1,len=list.length-1;i<=len;i++){
			list.eq(i).attr('class','raty-bad');
		}
		$(this).parents(".js-raty").find(".raty-grade").val(num+1);
		$(this).parents(".js-raty").find(".raty-text").html("+"+(num+1));
	});
	
	$(document).on("click",".js-tabs .item",function(e){ 
		e.preventDefault();
		var p=$(this).parents(".tabs-box");
		 
		$(this).addClass("active").siblings().removeClass("active");
		
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
	
});
