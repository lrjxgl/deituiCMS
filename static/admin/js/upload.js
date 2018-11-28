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
$(function(){
	$(document).on("click",".js-upload-btn",function(){
			var p=$(this).parents(".js-upload-item");
			p.find(".js-upload-file").click();
		});
		
		$(document).on("change",".js-upload-file",function(){
			var p=$(this).parents(".js-upload-item");
			var id=$(this).attr("id");
			skyUpload(id,"/index.php?m=upload&a=img&ajax=1",function(e){
				var res=eval("("+e.target.responseText+")");
				if(res.error==0){
					var html='<img src="'+res.data.trueimgurl+'.100x100.jpg">';
					p.find(".js-imgbox").html(html);
					p.find(".js-imgurl").val(res.data.imgurl);
				}else{
					skyToast(res.message);
				}
			})
		})
		
		//上传文件
		$(document).on("click",".js-upload-file-btn",function(){
			var p=$(this).parents(".btn-upload-item");
			p.find(".btn-upload-file").click();
		})
		
		$(document).on("change",".btn-upload-file",function(){
			var id=$(this).attr("id");
			var p=$(this).parents(".btn-upload-item");
			var url=p.attr("url");
			if(url==undefined){
				url="/index.php?m=upload&a=uploadfile&ajax=1";
			}
			skyUpload(id,url,function(e){
				var res=eval("("+e.target.responseText+")");
				if(res.error==0){
					p.find(".btn-upload-text").html(res.imgurl);
					p.find(".btn-upload-input").val(res.imgurl);
				}else{
					skyToast(res.message);
				}
			})
		})
		
})
