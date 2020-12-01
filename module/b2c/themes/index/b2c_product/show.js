var goBuy=false;
$("#ks1 .kslist-item:eq(0)").addClass("kslist-active");
$("#ks2 .kslist-item:eq(0)").addClass("kslist-active");
var cn=parseInt($("#cart-amount").val());
if(cn==0){
	$("#cart-amount").val(1)
}
$(document).on("click","#ppBox-close",function(){
	$("#ppBox").removeClass("flex-col");
})
$(document).on("click",".ppBox-Show",function(){
	if($(this).attr("goBuy")=="1"){
		goBuy=true;
	}else{
		goBuy=false;
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
			if(res.data.product.cart_amount==0){
				res.data.product.cart_amount=1;
			}
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
			if(res.data.product.cart_amount==0){
				res.data.product.cart_amount=1;
			}
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
			ksid: ksid
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
			 if(goBuy){
				 if(res.data.action=='delete'){
				 	skyToast("请选择商品")
				 	return false;
				 }
				 window.location="/module.php?m=b2c_order&a=confirm&cartid="+res.data.cartid
			 }
		}
	})
})

$(document).on("click","#goBuy",function(){
	var amount=$("#cart-amount").val();
	$.ajax({
		url: '/module.php?m=b2c_cart&a=add&ajax=1',
		data: {
			productid: productid,
			amount: amount,
			ksid: ksid
		},
		method: 'GET',
		dataType: "json",
		success: function(res) {
			if(res.error==1000){
				window.location="/index.php?m=login"
				return false;
			} 
			if(res.error){
				skyToast(res.message);
				return false;
			}
			if(res.data.action=='delete'){
				skyToast("请选择商品")
				return false;
			}
			window.location="/module.php?m=b2c_order&a=confirm&cartid="+res.data.cartid
		}
	})
})
