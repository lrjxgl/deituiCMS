var App=new Vue({
	el:"#App",
	data:function(){
		return {
			list:[],
			isFirst:true,
			pageLoad:false,
			per_page:0,
			type:"all"
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				dataType:"json",
				url:"/module.php?m=zblive&ajax=1",
				data:{
					type:that.type
				},
				success:function(res){
					that.list=res.data.list;
					that.isFirst=false;
					that.per_page=res.data.per_page;
				}
			})
		},
		setType:function(type){
			this.type=type;
			this.per_page=0;
			this.isFirst=true;
			this.getList();
		},
		getList:function(){
			var that=this;
			if(that.per_page==0 && !that.isFirst){
				return false;
			}
			$.ajax({
				dataType:"json",
				url:"/module.php?m=zblive&ajax=1",
				data:{
					type:that.type,
					per_page:that.per_page
				},
				success:function(res){
					if(that.isFirst){
						that.list=res.data.list;
						that.isFirst=false;
					}else{
						for(var i in res.data.list){
							that.list.push(res.data.list[i]);
						}
					}
					
					that.per_page=res.data.per_page;
				}
			})
		}
	}
})