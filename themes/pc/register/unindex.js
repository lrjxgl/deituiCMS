var that;
var v=new Vue({
	el:"#App",
	data:function(){
		return {
			aa:"axx",
			tab:"login",
			pageData:{},
			pageLoad:false
		}
	},
	created:function(){
		that=this;
		that.getPage();
	},
	methods:{
		getPage:function(){
			
			$.ajax({
				url:"/index.php?ajax=1",
				dataType:"json",
				success:function(res){
					that.pageLoad=true;
				}
			})
		},
		login:function(){
			$.ajax({
				url:"/index.php?m=login&a=loginSave&ajax=1",
				method:"POST",
				dataType:"json",
				data:$("#loginForm").serialize(),
				success:function(res){
					if(res.error==1){
						skyToast(res.message);
					}else{
						skyToast("登陆成功");
						setTimeout(function(){
							window.location=res.data.backurl;
						},700);
					}
				}
			})
		},
		sendSms:function(){
			var telephone=$("#telephone").val();
			$.get("/index.php?m=register&a=SendSms&ajax=1",{
				telephone:$("#telephone").val(),
			},function(res){
				skyToast(res.message);
			},"json");
		},
		regSubmit:function(){
			$.post("/index.php?m=register&a=regsave&ajax=1",$("#regForm").serialize(),function(res){
				skyToast(res.message);
				if(!res.error){
					
					window.location="/";
				}
			},"json");
		}
	}
})