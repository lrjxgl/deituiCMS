var app=new Vue({
	el:"#App",
	data:function(){
		return {
			pageLoad:false,
			list:{},
			per_page:0,
			isFirst:true,
			type:"all",
			id:0,
			stime:"",
			etime:""
		}
	},
	created:function(){
		
		this.getPage();
	},
	methods:{
		search:function(){
			this.per_page=0;
			this.isFirst=true;
			this.getList();
		},
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/admin.php?m=sgpay&ajax=1",
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
		setType:function(type){
			this.type=type;
			this.per_page=0;
			this.isFirst=true;
			this.id=0;
			this.stime="";
			this.etime="";
			this.getList();
		},
		getList:function(){
			var that=this;
			if(this.per_page==0 && !this.isFirst){
				return false;
			}
			$.ajax({
				url:"/admin.php?m=sgpay&ajax=1",
				data:{
					per_page:this.per_page,
					type:this.type,
					id:this.id,
					etime:this.etime,
					stime:this.stime
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
		},
		pass:function(item){
			if(confirm("确认充值已经对账了吗")){
				$.ajax({
					url:"/admin.php?m=sgpay&a=pass&ajax=1&id="+item.id,
					success:function(res){
						if(res.error){
							skyToast(res.message)
							return false;
						}
						item.status=1;
						item.status_name="已通过"
					}
				})
			}
			
		},
		forbid:function(item){
			if(confirm("确认充值已经对账了吗")){
				$.ajax({
					url:"/admin.php?m=sgpay&a=forbid&ajax=1&id="+item.id,
					success:function(res){
						if(res.error){
							skyToast(res.message)
							return false;
						}
						item.status=2;
						item.status_name="未通过"
					}
				})
			}
		},
		del:function(item){
			if(confirm("确认删除吗")){
				$.ajax({
					url:"/admin.php?m=sgpay&a=delete&ajax=1&id="+item.id,
					success:function(res){
						if(res.error){
							skyToast(res.message)
							return false;
						}
						item.status=11;
						item.status_name="已删除"
					}
				})
			}
		}
	}
})
