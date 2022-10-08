function skyToast(msg){
	var html='<div id="toast" class="toast toast-success">'+msg+'</div>';
	if($("#toast").length>0){
		$("#toast").html(msg).show();
		
	}else{
		$("body").append(html);
	}
	setTimeout(function(){
		$("#toast").hide();
	},1000)
}

function goBack(){
	window.history.back()
}

/**短信验证码****/
//倒计时
var smsCountDown={
	time:60,
	timer:60,
	sendClass:"js-sendBtn",
	el:".input-flex-btn",
	disClass:"btn-light",
	init:function(){
		this.countdown();
	},
	forbid:function(){
		console.log("forbid");
		$(this.el).addClass(this.disClass)
	},
	allow:function(){
		console.log("allow");
		$(this.el).removeClass(this.disClass).addClass(this.sendClass);
	},
	countdown:function(){
		var that=this;
		if(this.timer==0){
			$(this.el).addClass(this.sendClass).removeClass(this.disClass);
			$(this.el).text("发送验证码")
			this.timer=this.time;
			return;
		}else{
			$(this.el).addClass(this.disClass).removeClass(this.sendClass);
			$(this.el).text('重新发送(' + this.timer + ')')
			this.timer--;
		}
		setTimeout(function(){
			that.countdown();
		},1000)
	}
};

$(function(){
	$(document).on("click","[gourl]",function(){
		var url=$(this).attr("gourl");
		window.location=url;
	})
	$(document).on("click",".goBack",function(){
		window.history.back();
	})
	$(document).on("click",".header-back",function(){
		window.history.back();
	})
	$(document).on("click",".modal-close,.modal-mask,.modal-cancel",function(){
		$(this).parents(".modal-group").hide();
	})
	 
})
