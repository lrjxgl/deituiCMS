var sidemenu_l,sidemenu_r;
$(function(){
	
	sidemenu_l=sidemenu_r=window.innerWidth-100;
	$("#sidemenu-left").css({"left":"-"+sidemenu_l+"px",width:sidemenu_l+"px"});
	$("#sidemenu-right").css({"right":"-"+sidemenu_r+"px",width:sidemenu_r+"px"});
});
function sidemenu_left_show(){
	if($('#sidemenu-left').css("left")=="0px"){
		sidemenu_left_hide();
		return false;
	}
	$('#sidemenu-left').css("left","0px");
	$('#sidemenu-left').removeClass().addClass("fadeInLeft" + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
}

function sidemenu_left_hide(){
	$('#sidemenu-left').removeClass().addClass("fadeOutLeft" + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
	  $('#sidemenu-left').css("left","-"+sidemenu_l+"px");
    });
}

function sidemenu_right_show(){
	if($('#sidemenu-right').css("right")=="0px"){
		sidemenu_right_hide();
		return false;
	}
	$('#sidemenu-right').css("right","0px");
	$('#sidemenu-right').removeClass().addClass("fadeInRight" + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
}

function sidemenu_right_hide(){
	$('#sidemenu-right').removeClass().addClass("fadeOutRight" + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
	  $('#sidemenu-right').css("right","-"+sidemenu_r+"px");
    });
}
$(function(){
	
	$("#sidemenu-left-range").swipeRight(function(){
		sidemenu_left_show();
	})
	 
	$("#sidemenu-right-range").swipeLeft(function(){
		sidemenu_right_show();
	});
	
	$("#sidemenu-left").swipeLeft(function(){
		sidemenu_left_hide();	
	});
	
	$(document).on("click","#sidemenu-left-show",function(){
		sidemenu_left_show();
	});
	
	$("#sidemenu-right").swipeRight(function(){
		sidemenu_right_hide();	
	});
	
	$(document).on("click","#sidemenu-right-show",function(){
		sidemenu_right_show()
	});

})

