new Vue({
	el:"#App",
	data:function(){
		return {
			pageLoad:false,
			list:[],
			isFirst:true,
			per_page:0,
			timer:0,
			type:"all"
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		setType:function(type){
			this.type=type;
			this.isFirst=true;
			this.per_page=0;
			this.getList();
		},
		tgo:function(atime){
			if(atime>3600){
				var h=parseInt(atime/3600);
				var m=parseInt((atime-h*3600)/60);
				var s=atime%60;
				var t=h+":"+m+":"+s;
			}else if(atime>60){
				var m=parseInt(atime/60);
				var s=atime%60;
				var t="00:"+m+":"+s;
			}else{
				t=atime;
			}
			return t;
		},
		getTimeStatus:function(item){
			var stime=item.stime;
			var etime=item.etime;
			var time=Date.parse(new Date())/1000;
			if(stime>time){
				var t=this.tgo(stime-time);
				return "即将开始："+t;
				$("#btnBuy").hide();
				$("#btnNone").show();
			}else if(etime<time){
				return "活动已经结束";
			}else{
				var t=this.tgo(etime-time);
				return "距离结束："+t;
				 
			}
		},
		timerList:function(){
			var that=this;
			that.timer=setInterval(function(){
				for(var i in that.list){
					var it=that.list[i];
					it.timestatus=that.getTimeStatus(it);					 
				}
			},1000)
		},
		getPage:function(){
			var that=this;
			$.ajax({
				dataType:"json",
				url:"/module.php?m=b2c_flash&ajax=1",
				success:function(res){
					if(res.error){
						return false;
					}
					that.pageLoad=true;
					that.isFirst=false;
					that.per_page=res.data.per_page;
					for(var i in res.data.list){
						var it=res.data.list[i];
						it.timestatus=that.getTimeStatus(it);					 
					}
					that.list=res.data.list;
					that.timerList();
				}
			})
		},
		getList:function(){
			var that=this;
			if(this.per_page==0 && !this.isFirst){
				return false;
			}
			$.ajax({
				dataType:"json",
				url:"/module.php?m=b2c_flash&ajax=1",
				data:{
					per_page:this.per_page,
					type:this.type
				},
				success:function(res){
					if(res.error){
						return false;
					}
					for(var i in res.data.list){
						var it=res.data.list[i];
						it.timestatus=that.getTimeStatus(it);					 
					}
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
		goProduct:function(id){
			window.location="/module.php?m=b2c_product&a=show&id="+id
		}
	}
})