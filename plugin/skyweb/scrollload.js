var scrollload={
	inloading:false,
	minH:50,	
}
scrollload.scrollBottom=function(callback){
	var h=$("body").height();
	var winH=window.innerHeight;
	var scH=$(window).scrollTop();
	
	if(h-winH-scH<scrollload.minH){
		if(scrollload.inloading) return false
		scrollload.inloading=true;
		callback();
	}else{
		scrollload.inloading=false;
	}
}