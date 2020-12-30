new Vue({
	el:"#App",
	data:function(){
		return {
			 
			list:{},
			isFirst:true,
			pageLoad:false,
			 
			per_page:0
		 
		}
	},
	created:function(){
		 
		if(!this.getCache()){
			this.getPage();
		}
		
	},
	methods:{
		getCache:function(){
			var k="page-m-forum-new";
			var res=localStorage.getItem(k);
			 
			if(res!=null){
				var d=JSON.parse(res);
				 
				if(Date.parse(new  Date())/1000>d.expire){
					return false;
				}
				 
				this.list=d.list;
				this.isFirst=d.isFirst;
				this.pageLoad=d.pageLoad;
				 
				this.per_page=d.per_page;
				 
				return true;
			}
			return false;
		},
		setCache:function(){
			var k="page-m-forum-new";
			var v={
				 
				list:this.list,
				isFirst:this.isFirst,
				pageLoad:this.pageLoad,
				 
				per_page:this.per_page,
				 
				expire:Date.parse(new  Date())/1000+120
			}
			localStorage.setItem(k,JSON.stringify(v));
		},
		getPage:function(){
			that=this;
			$.ajax({
				url:"/module.php?m=forum&a=new&ajax=1",
				dataType:"json",
				success:function(res){
					that.list=res.data.list;
					 
					that.pageLoad=true;
					that.per_page=res.data.per_page;
					that.isFirst=false;
					 
					that.setCache();
				}
			})
		},
		setCat:function(catid){
			this.catid=catid;
			this.isFirst=true;
			this.per_page=0;
			this.getList();
		},
		getList:function(){
			that=this;
			if(this.per_page==0 && !this.isFirst){
				return false;
			}
			$.ajax({
				url:"/module.php?m=forum&a=new&ajax=1",
				data:{
					per_page:this.per_page 
				},
				dataType:"json",
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
					that.setCache();
				}
			})
		}
	}
})