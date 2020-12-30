
var app=new Vue({
	el:"#app",
	data:function(){
		return {
			pageData:[],
			type:type,
			per_page:0,
			isFirst:true,
			list:[]
		}
	},
	created:function(){
		this.getPage();
		$("#app").show();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_order&a=my&ajax=1",
				data:{
					type:that.type
				},
				dataType:"json",
				success:function(res){
					if(res.error) return false;
					that.pageData=res.data;
					that.list=res.data.list;
					that.per_page=res.data.per_page;
					that.isFirst=false;
				}
			})
		},
		getList:function(){
			var that=this;
			if(that.per_page==0 && !that.isFirst){
				return false;
			}
			$.ajax({
				url:"/module.php?m=b2c_order&a=my&ajax=1",
				data:{
					type:that.type,
					per_page:that.per_page
				},
				dataType:"json",
				success:function(res){
					if(res.error) return false;
					that.per_page=res.data.per_page;
					if(that.isFirst){
						that.list=res.data.list;
					}else{
						for(var i in res.data.list){
							that.list.push(res.data.list[i]);
						}
						that.isFirst=false;
					}
				}
			})
		},
		goOrder:function(orderid){
			window.location="/module.php?m=b2c_order&a=show&orderid="+orderid
		},
		setType:function(t){
			this.type=t;
			this.isFirst=true;
			this.per_page=0;
			this.getPage();
		},
		pay:function(orderid){
			$.ajax({
				url:"/module.php?m=b2c_order&a=pay&ajax=1&orderid="+orderid,
				dataType:"json",
				success:function(res){
					window.location=res.data.payurl;
				}
			})
			
		},
		gopin:function(orderid){
			window.location="/module.php?m=b2c_pintuan&a=invite&orderid="+orderid
		}
	}
});