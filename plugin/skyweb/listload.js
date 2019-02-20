/**无限加载*/
var listload={
	loading:false,
	loadid:"#loading",
	loadHeight:160,/*加载离底部高度*/
	loadtime:1000,/*两次加载时间*/
	showload:function(loadsuccess){
		$(window).scroll(function(){
			if ($(document).height() - $(this).scrollTop() - $(this).height()<listload.loadHeight) {
				listload.success(loadsuccess);
			}
		  });
		$(document).on("click",listload.loadid,function(){
			listload.success(loadsuccess);
		});
	},
	success:function(loadsuccess){
		var loadid=listload.loadid;
				$(loadid).addClass("active");		
				var ldtimer=setTimeout(function(){
					$(loadid).removeClass("active");
					listload.loading=false;
					clearTimeout(ldtimer);
				},listload.loadtime);
				if(listload.loading==false){
					loadsuccess();
				}
				listload.loading=true;
	},
	hideload:function(){
		var loadid=listload.loadid;
		$(loadid).removeClass("active");
		listload.loading=false;
	}
};