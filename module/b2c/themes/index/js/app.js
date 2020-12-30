$(document).on("click",".js-fav-toggle",function(){
	var tablename=$(this).attr("tablename");
	var objectid=$(this).attr("objectid");
	var that=$(this);
	$.get("/index.php?m=fav&a=toggle&ajax=1",{
		tablename:tablename,
		objectid:objectid
	},function(res){
		skyToast(res.message);
		if(res.error==1000){
			window.location="/index.php?m=login";
			return false;
		}else{
			if(res.data=='add'){
				that.addClass("btn-fav-active");
			}else{
				that.removeClass("btn-fav-active");
			}
		}
		
	},"json")
})