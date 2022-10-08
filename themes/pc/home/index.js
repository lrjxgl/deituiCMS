var App=new Vue({
	el:"#App",
	data:function(){
		return {
			list:[],
			pageLoad:false,
			user:{}
			 
		}
	},
	created:function(){
		this.getPage();
		this.getAsk();
	},
	watch:{
		pageLoad:function(n,o){
			console.log(n,o)
		}
	},
	methods:{
		goPm:function(userid){
			window.location="/index.php?m=pm&a=detail&userid="+userid;
			 
		},  
		goBlog:function(askid){
			window.location="/module.php?m=ask&a=show&askid="+askid;
		},
		getPage:function(){
			var that=this;
			
			$.ajax({
				url:"/index.php?m=home&ajax=1",
				data:{
					userid:userid
				},
				dataType:"json",
				success:function(res){
					console.log(that.pageLoad);
					that.user=res.data.user;
					that.pageLoad=true;
				}
			})
		},
		getAsk:function(){
			var that=this;
			
			$.ajax({
				url:"/module.php?m=ask&a=user&ajax=1",
				data:{
					userid:userid
				},
				dataType:"json",
				success:function(res){
					that.list=res.data.list;
				}
			})
		},
		toggleFollow:function(item){
			var that=this;
			$.ajax({
				url: "/index.php?m=follow&a=Toggle&ajax=1",
				dataType: "json",
				data: {
					t_userid: item.userid
				},
				success: function(res) {
					if(res.error){
						skyToast(res.message);
						return false;
					}
					item.isFollow = res.follow;
			
				}
			});
		}
	}
})