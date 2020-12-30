var ispin=false;
var pin_orderid=0;
$("#ks1 .kslist-item:eq(0)").addClass("kslist-active");
$("#ks2 .kslist-item:eq(0)").addClass("kslist-active");
var $objs=$(".js-timego");
var times=Array();
for(var i=0;i<$objs.length;i++){
	var $obj=$objs.eq(i);
	var html="";
	var atime=parseInt($obj.attr("v"));
	console.log(atime)
	times.push(atime);
}
var timeLeft=function(){
	for(var i=0;i<$objs.length;i++){
		atime=times[i];
		times[i]-=1;
		if(atime<=0){
			html="已结束";
		}else{
			if(atime>3600){
				var h=parseInt(atime/3600);
				var m=parseInt((atime-h*3600)/60);
				var s=atime%60;
				var t=h+":"+m+":"+s;
			}else if(atime>60){
				var m=parseInt(atime/60);
				var s=atime%60;
				var t="00:"+m+":"+s;
			}else{
				t=atime;
			}
			
			html="还剩"+t;
		}
		$objs.eq(i).html(html);
	}
	console.log(atime)
	setTimeout(timeLeft,1000);
}
timeLeft();
$(document).on("click","#ppBox-close",function(){
	$("#ppBox").removeClass("flex-col");
})
$(document).on("click",".ppBox-Show",function(){
	if($(this).attr("ispin")=="1"){
		ispin=true;
	}else{
		ispin=false;
	}
	if($(this).attr("orderid")){
		pin_orderid=$(this).attr("orderid");
	}
	$("#ppBox").addClass("flex-col");
})

$(document).on("click","#attBox-close",function(){
	$("#attBox").removeClass("flex-col");
})
$(document).on("click","#attBox-show",function(){
	$("#attBox").removeClass("ani-bottom");
	$("#attBox").addClass("flex-col").addClass("ani-bottom");
})

$(document).on("click", ".numbox-plus", function() {
	var p = $(this).parent(".numbox");
	var n = parseInt(p.find(".numbox-num").val());
	n++;
	p.find(".numbox-num").val(n);
})
$(document).on("click", ".numbox-minus", function() {
	var p = $(this).parent(".numbox");
	var n = parseInt(p.find(".numbox-num").val());
	n--;
	n = n < 0 ? 0 : n;
	p.find(".numbox-num").val(n);
})
$(document).on("click", "#ks1 .kslist-item", function() {
	var kid = $(this).attr("v");
	var that = $(this);
	$.ajax({
		url: "/module.php?m=b2c_product_ks&a=sizeList&ajax=1&id=" + kid,
		dataType: "json",
		success: function(res) {
			that.addClass("kslist-active").siblings().removeClass("kslist-active");
			ksid = res.data.ksid;
			var list = "";
			for (var i in res.data.ksList2) {
				list += '<div class="kslist-item" v="' + res.data.ksList2[i].id + '">' + res.data.ksList2[i].size + '</div>';
			}
			$(".kslist-list").html(list);
			$("#ks2 .kslist-item:eq(0)").addClass("kslist-active");
			$("#price").html("￥" + res.data.ks.price);
			$("#cart-amount").val(res.data.product.cart_amount);
		}
	})
})
$(document).on("click", "#ks2 .kslist-item", function() {
	var kid = $(this).attr("v");
	var that = $(this);
	$.ajax({
		url: "/module.php?m=b2c_product_ks&a=get&ajax=1&id=" + kid,
		dataType: "json",
		success: function(res) {
			that.addClass("kslist-active").siblings().removeClass("kslist-active");
			ksid = res.data.ksid;
			$("#price").html("￥" + res.data.ks.price);
			$("#cart-amount").val(res.data.product.cart_amount);
		}
	})
})


$(document).on("click","#addCart",function(){
	var amount=$("#cart-amount").val();
	$.ajax({
		url: '/module.php?m=b2c_cart&a=add&ajax=1',
		data: {
			productid: productid,
			amount: amount,
			ksid: ksid,
			
		},
		method: 'GET',
		dataType: "json",
		success: function(res) {
			skyToast(res.message);
			 if(res.error==1000){
			 	window.location="/index.php?m=login"
			 	return false;
			 } 
			 if(res.error){
			 	return false;
			 }
			 if(res.data.action=='delete'){
			 	skyToast("请选择商品")
			 	return false;
			 }
			 if(ispin){
				window.location="/module.php?m=b2c_order&a=confirm&pin_orderid="+pin_orderid+"&ispin=1&cartid="+res.data.cartid 
			 }else{
				 window.location="/module.php?m=b2c_order&a=confirm&pin_orderid="+pin_orderid+"&cartid="+res.data.cartid
			 }
			 
		}
	})
})


