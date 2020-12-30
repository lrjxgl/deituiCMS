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
$(document).on("click",".js-love-toggle",function(){
	var tablename=$(this).attr("tablename");
	var objectid=$(this).attr("objectid");
	var that=$(this);
	$.get("/index.php?m=love&a=toggle&ajax=1",{
		tablename:tablename,
		objectid:objectid
	},function(res){
		skyToast(res.message);
		if(res.error==1000){
			window.location="/index.php?m=login";
			return false;
		}else{
			if(res.data=='add'){
				that.addClass("btn-love-active");
			}else{
				that.removeClass("btn-love-active");
			}
		}
		
	},"json")
})

$(document).on("click",".js-follow-toggle",function(){
	var userid=$(this).attr("data-userid");
	var obj=$(this);
	$.get("/index.php?m=follow&a=toggle&ajax=1&t_userid="+userid,function(res){
		if(res.error==1000){
			loginBoxShow();
			return false;
		}
		if(res.error){
			skyToast(res.message);
			return false;
		}
		if(res.follow==1){
			obj.html("已关注");
		}else{
			obj.html("+关注");
		}
	},"json")
})