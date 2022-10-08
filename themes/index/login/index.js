var app=new Vue({
	el:"#App",
	data:function(){
		return {
			page:"login"
		}
	},
	methods:{
		setPage:function(p){
			this.page=p;
		}
	}
})

$(document).on("click","#login-submit",function(){		
	$.post("/index.php?m=login&a=loginSave&ajax=1",{
		telephone:$("#telephone").val(),
		password:$("#password").val(),
		backurl:$("#backurl").val()
	},function(data){
		if(data.error==1){
			skyToast(data.message);
		}else{
			skyToast("登陆成功");
			setTimeout(function(){
				if(data.data.backurl!=undefined && data.data.backurl!=''){
					window.location=data.data.backurl;
				}else{
					goBack();
				}
				
			},700);
		}
	},"json");
});

$(document).on("click","#sendSms",function(res){
	var telephone=$("#telephone").val();
	$.get("/index.php?m=login&a=SendSms&ajax=1",{
		telephone:$("#telephone").val(),
	},function(res){
		skyToast(res.message);
	},"json");
})
$(document).on("click","#findpwd-submit",function(){
	$.post("/index.php?m=login&a=FindPwdSave&ajax=1",$("#fdForm").serialize(),function(res){
		skyToast(res.message);
		if(!res.error){
			app.page="login";
		}
	},"json");
})
$(document).on("click","#sendSms2",function(res){
	var telephone=$("#telephone").val();
	$.get("/index.php?m=register&a=SendSms&ajax=1",{
		telephone:$("#telephone").val(),
	},function(res){
		skyToast(res.message);
	},"json");
})
$(document).on("click","#reg-submit",function(){
	$.post("/index.php?m=register&a=regsave&ajax=1",$("#regForm").serialize(),function(res){
		skyToast(res.message);
		if(!res.error){
			window.location="/";
		}
	},"json");
})