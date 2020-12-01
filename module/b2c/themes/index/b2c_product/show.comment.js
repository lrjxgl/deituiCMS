var cmVue=new Vue({
	el:"#cmApp",
	data:function(){
		return {
			pageData:{}
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_product&a=raty&ajax=1&limit=1&id="+productid,
				dataType:"json",
				success:function(res){
					that.pageData=res.data;
				}
			})
		}
	}
})