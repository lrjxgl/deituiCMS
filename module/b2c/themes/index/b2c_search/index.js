var app=new Vue({
	el:"#app",
	data:function(){
		return {
			pageLoad:false,
			pageData:{},
			keyword:""
		}
	},
	created:function(){
		this.keyword=keyword;
		this.getPage();
	},
	methods:{
		goProduct:function(id){
			window.location="/module.php?m=b2c_product&a=show&id="+id;
		},
		 
		search:function(){
			this.getPage();
		},
		setPage:function(page){
			this.page=page;
			this.pageLoad=false;
			this.pageData={};
			this.getPage();
		},
		getPage:function(){
			this.getProduct();
		},
		 
		getProduct:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_search&a=product&ajax=1",
				data:{
					keyword:this.keyword
				},
				dataType:"json",
				success:function(res){
					that.pageLoad=true;
					that.pageData=res.data;
				}
			})
		}
	}
});