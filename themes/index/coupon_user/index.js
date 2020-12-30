var app=new Vue({
	el:"#App",
	data:function(){
		return {
			pageData:{},
			pageLoad:false,
			listNum:0
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=coupon_user&ajax=1",
				dataType:"json",
				success:function(res){
					that.pageData=res.data;
					that.pageLoad=true;
					that.listNum=Object.keys(that.pageData.list).length;
				}
			})
		}
	}
})