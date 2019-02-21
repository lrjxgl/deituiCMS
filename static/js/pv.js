var pvurl="";
setTimeout(function(){
	$.get("/index.php?m=pv&a=stat",{
		url:pvurl
	});
},1000);

