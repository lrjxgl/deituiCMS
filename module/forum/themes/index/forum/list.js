new Vue({
	el:"#App",
	data:function(){
		return {
			recList:{},
			list:{},
			isFirst:true,
			pageLoad:false,
			catlist:{},
			catid:0,
			per_page:0,
			gid:0
		}
	},
	created:function(){
		this.gid=gid;
		if(!this.getCache()){
			this.getPage();
		}
		
	},
	methods:{
		getCache:function(){
			var k="page-m-forum-list";
			var res=localStorage.getItem(k);
			 
			if(res!=null){
				var d=JSON.parse(res);
				if(gid!=d.gid){
					
					return false;
				}
				if(Date.parse(new  Date())/1000>d.expire){
					return false;
				}
				this.recList=d.recList;
				this.list=d.list;
				this.isFirst=d.isFirst;
				this.pageLoad=d.pageLoad;
				this.catlist=d.catlist;
				this.catid=d.catid;
				this.per_page=d.per_page;
				this.gid=gid;
				
				return true;
			}
			return false;
		},
		setCache:function(){
			var k="page-m-forum-list";
			var v={
				recList:this.recList,
				list:this.list,
				isFirst:this.isFirst,
				pageLoad:this.pageLoad,
				catlist:this.catlist,
				catid:this.catid,
				per_page:this.per_page,
				gid:this.gid,
				expire:Date.parse(new  Date())/1000+120
			}
			localStorage.setItem(k,JSON.stringify(v));
		},
		getPage:function(){
			that=this;
			$.ajax({
				url:"/module.php?m=forum&a=list&ajax=1&gid="+gid,
				dataType:"json",
				success:function(res){
					that.list=res.data.list;
					that.catlist=res.data.catlist;
					that.pageLoad=true;
					that.per_page=res.data.per_page;
					that.isFirst=false;
					that.recList=res.data.recList;
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
				url:"/module.php?m=forum&a=list&ajax=1&gid="+gid,
				data:{
					per_page:this.per_page,
					catid:this.catid
				},
				dataType:"json",
				success:function(res){
					if(that.isFirst){
						that.list=res.data.list;
						that.isFirst=false;
						that.recList=res.data.recList;
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