var App=new Vue({
		el:"#App",
		data:function(){
			return {
				catid:0,
				pageLoad:false,
				catList:[],
				list:[],
				pageCatid:0,
				per_page:0,
				isFirst:0,
				orderby:""
			}
		},
		created:function(ops){
			this.catid=catid
			this.getPage();
		},
		onReachBottom:function(){
			this.getList();
		},
		methods:{
			setCat:function(catid){
				this.catid=catid;
				this.isFirst=true;
				this.per_page=0;
				this.getList();
			},
			setOrder:function(o){
				this.orderby=o;
				this.isFirst=true;
				this.per_page=0;
				this.getList();
			},
			goProduct:function(id){
				window.location="/module.php?m=b2c_product&a=show&id="+id;
				 
			},
			getPage:function(){
				var that=this;
				$.ajax({
					url:"/module.php?m=b2c_product&a=list&ajax=1",
					dataType:"json",
					data:{
						orderby:this.orderby,
						catid:that.catid
					},
					success:function(res){					
						that.per_page=res.data.per_page;
						that.list=res.data.list;
						that.catList=res.data.catList;
						that.isFirst=false;
						that.pageLoad=true;
						if(that.pageCatid==0){
							that.pageCatid=res.data.cat.catid;
						}						
						 
					}
				})
			},
			getList:function(){
				var that=this;
				if(that.per_page==0 && !that.isFirst){
					return false;	
				}
				$.ajax({
					url:"/module.php?m=b2c_product&a=list&ajax=1",
					dataType:"json",
					data:{
						orderby:this.orderby,
						catid:that.catid
					},
					success:function(res){
						that.per_page=res.data.per_page;
						
						if(that.isFirst){
							that.list=res.data.list;
							that.isFirst=false;
						}else{
							for(var i in res.data.list){
								that.list.push(res.data.list[i]);
							}
						}
						 
					}
				})
			},
		}
	});