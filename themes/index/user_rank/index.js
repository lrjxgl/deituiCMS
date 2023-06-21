var app=new Vue({
	el:"#App",
	data:function(){
		return {
			list:[],
 
		}
	},
	created:function(){
		var that=this;
		this.getPage();
 
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=user_rank&ajax=1",
				dataType:"json",
				success:function(res){
					that.list=res.data.list;
					 
				}
			})
		}
	}
})