 
	var upgaller;

	$(document).on("change",".uploader-imgsdata-file", function(e){
           var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
           var parent=$(this).parents(".uploader-imgsdata-imgslist");
           for (var i = 0, len = files.length; i < len; ++i) {
                var file = files[i];

                if (url) {
                    src = url.createObjectURL(file);
                } else {
                    src = e.target.result;
                }
				lrz(file,{width:1024}) .then(function(rst){
					 
					$.post("/index.php?m=upload&a=base64",
					{
						content:rst.base64
					},
					function(data){
						//console.log(data);
						if(data.error){
							mui.toast(data.message);
							return false;
						} 
						var html='<div class="upimg-item uploader-imgsdata-img js-zzimg" data-src="'+data.trueimgurl+'"  v="'+data.imgurl+'" trueimg="'+data.imgurl+'">'
								+'	<img class="upimg-img" src="'+data.trueimgurl+'.100x100.jpg"/>'
								+'<i class="upimg-del js-imgdel"></i>'
								+'</div>';
						parent.append(html);
						//同步到表单
						var $imgs=$(".uploader-imgsdata-img");
						var $imgsdata="";
						for(var i=0;i<$imgs.length;i++){
							if(i>0){
								$imgsdata+=","
							}
							$imgsdata+=$imgs.eq(i).attr("v");
							
						}
						$("#imgsdata").val($imgsdata);
						//end 
					},"json")
				})
				.catch(function(err){
					console.log(err)
				})
                
            }
        });
   
$(document).on("click",".js-imgdel",function(){
	var id=$(this).parents(".uploader-imgsdata-img").remove();
	//同步到表单
	var $imgs=$(".uploader-imgsdata-img");
	var $imgsdata="";
	for(var i=0;i<$imgs.length;i++){
		if(i>0){
			$imgsdata+=","
		}
		$imgsdata+=$imgs.eq(i).attr("v");
		
	}
	$("#imgsdata").val($imgsdata);
})
$(document).on("click",".upimg-btn",function(){
	$(this).parents(".upimg-box").find(".uploader-imgsdata-file").click();//
	 
}) 