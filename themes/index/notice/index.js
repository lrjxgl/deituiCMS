var App=new Vue({
	el:"#App",
	data:function(){
		return {
			pageLoad:false,
			list:[],
			per_page:0,
			isFirst:true,
			catid:0,
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
				url:"/index.php?m=notice&ajax=1",
				data:{
					type:this.type
				},
				dataType:"json",
				success:function(res){
					if(res.error){
						skyToast(res.message);
						return false;
					}
					that.list=res.data.data;
					that.isFirst=false;
					that.per_page=res.data.per_page;
					that.pageLoad=true;
				}
			})
		},
		getList:function(){
			var that=this;
			if(that.per_page==0 && !that.isFirst){
				return false;
			}
			$.ajax({
				url:"/index.php?m=notice&ajax=1",
				data:{
					type:this.type,
					per_page:that.per_page
				},
				dataType:"json",
				success:function(res){
					if(res.error){
						skyToast(res.message);
						return false;
					}
					if(that.isFirst){
						that.list=res.data.data;
						that.isFirst=false;
					}else{
						for(var i in res.data.data){
							that.list.push(res.data.data[i]);
						}
					}
					
					
					that.per_page=res.data.per_page;
					 
				}
			})
		},
		read:function(item){
			$.ajax({
				url:"/index.php?m=notice&a=ReadNotice&ajax=1",
				dataType:"json",
				data:{
					id:item.id
				},
				success:function(res){
					item.isread=1;
					item.status_name="已读";
				}
			})
		}
	}
})
