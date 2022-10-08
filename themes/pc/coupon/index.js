var app=new Vue({
	el:"#App",
	data:function(){
		return {
			pageData:{},
			pageLoad:false
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=coupon&ajax=1",
				dataType:"json",
				success:function(res){
					that.pageData=res.data;
					that.pageLoad=true;
				}
			})
		},
		getCoupon:function(id){
			$.ajax({
				url:"/index.php?m=coupon&a=getcoupon&ajax=1&id="+id,
				dataType:"json",
				success:function(res){
					skyToast(res.message);
				}
			})
		},
	}
})