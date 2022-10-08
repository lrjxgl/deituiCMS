var app=new Vue({
	el:"#App",
	data:function(){
		return {
			tableList:[],
			tablename:"",
			list:[],
			keyword:"",
			per_page:0,
			isFirst:true,
			rscount:0
		}
	},
	created:function(){
		this.keyword=keyword;
		this.getPage();
		if(this.keyword!=''){
			this.search();
		}
	},
	methods:{
		setType:function(t){
			this.tablename=t;
			this.per_page=0;
			this.isFirst=true;
			this.getList();
		},
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=search&a=article&ajax=1",
				dataType:"json",
				 
				success:function(res){
					that.tableList=res.data.tableList;
				}
			})
		},
		getList:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=search&a=article&ajax=1",
				dataType:"json",
				data:{
				 
					keyword:this.keyword
				},
				success:function(res){
					that.list=res.data.list;
					that.isFirst=false;
					that.rscount=res.data.rscount;
				}
			})
		},
		search:function(){
			this.per_page=0;
			this.isFirst=true;
			this.getList();
		},
		goDetail:function(item){
			this.goLink("/index.php?m=article&a=show&id="+item.id);
			 
			
		},
		goLink:function(url){
			var a=document.createElement("a");
			a.setAttribute("target","_blank");
			a.href=url;
			a.click();
		}
	}
})