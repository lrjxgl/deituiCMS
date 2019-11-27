var app=new Vue({
	el:"#App",
	data:function(){
		return {
			pageLoad:false,
			list:{},
			per_page:0,
			isFirst:true
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=sgpay&a=my&ajax=1",
				dataType:"json",
				success:function(res){
					if(res.error){
						skyToast(res.message);
						return false;
					}
					that.list=res.data.list;
					that.per_page=res.data.per_page;
					that.pageLoad=true;
					that.isFirst=false;
				}
			})
		},
		getList:function(){
			var that=this;
			if(this.per_page==0 && !this.isFirst){
				return false;
			}
			$.ajax({
				url:"/index.php?m=sgpay&a=my&ajax=1",
				data:{
					per_page:this.per_page
				},
				dataType:"json",
				success:function(res){
					if(res.error){
						skyToast(res.message);
						return false;
					}
					if(that.isFirst){
						that.isFirst=false;
						that.list=res.data.list;
					}else{
						for(var i in res.data.list){
							that.list.push(res.data.list[i])
						}
					}
					
					that.per_page=res.data.per_page;
					
				}
			})
		}
	}
})
