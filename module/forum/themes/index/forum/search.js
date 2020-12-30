
var App=new Vue({
	el:"#app",
	data:function(){
		return {
			pageData:{},
			per_page:0,
			isFirst:true,
			keyword:"",
			pageLoad:false
		}
	},
	created:function(){
		this.keyword=skeyword;
		if(!this.getCache()){
			this.getPage();
		}
	},
	methods:{
		setCache:function(){
			var k="page-m-forum-search";
			var v={
				pageData:this.pageData,
				list:this.list,
				isFirst:this.isFirst,
				pageLoad:this.pageLoad,
				per_page:this.per_page,
				keyword:this.keyword,
				expire:Date.parse(new  Date())/1000+120
			}
			localStorage.setItem(k,JSON.stringify(v));
		},
		getCache:function(){
			var k="page-m-forum-search";
			var res=localStorage.getItem(k);
			 
			if(res!=null){
				var d=JSON.parse(res);
			 
				if(Date.parse(new  Date())/1000>d.expire){
					return false;
				}
				this.isFirst=d.isFirst;
				this.pageData=d.pageData;
				this.pageLoad=d.pageLoad;
				this.per_page=d.per_page;
				this.keyword=d.keyword;
				
				return true;
			}
			return false;
		},
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=forum&a=search&ajax=1",
				data:{
					keyword:this.keyword
				},
				dataType:"json",
				success:function(res){
					that.pageLoad=true;
					that.pageData=res.data;
					that.setCache();
				}
			})
		},
		search:function(){
			this.getPage();
		},
		getList:function(){
			var that=this;
			if(!that.isFirst && that.per_page==0) return false;
			$.ajax({
				url:"/module.php?m=forum&a=search&ajax=1",
				data:{
					keyword:this.keyword,
					per_page:that.per_page
				},
				dataType:"json",
				success:function(res){
					
					that.per_page=res.data.per_page;
					
					if(that.isFirst){
						that.isFirst=false;
						that.pageData.list=res.data.list;
					}else{
						var pageData=that.pageData;
						var list=pageData.list;
						for(var i in res.data.list){
							list.push(res.data.list[i]);
						}
						that.pageData.list=list;
					}
					that.setCache();
				}
			})
		}
	}
})