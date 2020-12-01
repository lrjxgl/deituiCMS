var app=new Vue({
	el:"#app",
	data:function(){
		return {
			pageLoad:false,
			pageData:{},
			orderid:0,
		}
	},
	created:function(){
		this.orderid=orderid;
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_order&a=raty&ajax=1&orderid="+this.orderid,
				dataType:"json",
				success:function(res){
					that.pageLoad=true; 
					that.pageData=res.data;
				}	
			})
		},
		ratySubmit:function(e){
			var that=this;
		 
			$.ajax({
				url:"/module.php?m=b2c_order&a=ratysave&ajax=1",
				data:$("#ratyForm").serialize(),
				method:"POST",
				dataType:"json",
				success:function(rs){
					 
					that.getPage();
				}	
			})
		}
	}
})