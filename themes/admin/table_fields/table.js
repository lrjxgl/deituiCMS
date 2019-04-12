var App=new Vue({
	el:"#app",
	data:{
		pageLoad:false,
		pageData:{}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/admin.php?m=table_fields&ajax=1&tableid="+tableid,
				dataType:"json",
				success:function(res){
					that.pageData=res.data;
					that.pageLoad=true;
				}
			})
		},
		save:function(el){
			var that=this;
			$.ajax({
				url:"/admin.php?m=table_fields&a=save&ajax=1",
				data:$(el).serialize(),
				method:"POST",
				dataType:"json",
				success:function(res){
					console.log(res);
					skyToast(res.message);
					that.getPage();
				}
			})
		}
	}
})