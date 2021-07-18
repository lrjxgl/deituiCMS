var isFirst=false;
var App=new Vue({
	el:"#app",
	data:function(){
		return {
			pageData:{},
			pageLoad:false,
			type:"",
			per_page:0,
			catid:0,
			scatid:0,
		}
	},
	created:function(){
		this.catid=catid;
		this.scatid=catid;
		this.getPage();
		
	},
	methods:{
		setCatid:function(catid){
			this.catid=catid;
			isFirst=true;
			this.per_page=0;
			this.getList();
		},
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=article&a=list&ajax=1&catid="+this.catid,
				dataType:"json",
				success:function(res){
					that.pageData=res.data;
					that.pageLoad=true;
					that.per_page=res.data.per_page;
					isFirst=false;
				}
			})
		},
		getList:function(){
			var that=this;
			if(that.per_page==0 && !isFirst){
				skyToast("已经到底了");
				return false;
			}
			$.ajax({
				url:"/index.php?m=article&a=list&ajax=1&catid="+this.catid,
				data:{
					type:that.type,
					per_page:that.per_page,
					catid:this.catid
				},
				dataType:"json",
				success:function(res){
					that.per_page=res.data.per_page;
					if(isFirst){
						that.pageData.list=res.data.list;
					}else{
						var list=that.pageData.list;
						for(var i=0;i<res.data.list.length;i++){
							list.push(res.data.list[i]);
						}
						that.pageData.list=list;
					}
					isFirst=false;
				}
			})
		}
	}
})