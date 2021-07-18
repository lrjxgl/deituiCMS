new Vue({
	el:"#App",
	data:function(){
		return {
			list:[],
			isFirst:true,
			per_page:0,
			suser:{},
			suser_true:false,
			nickname:""
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		search:function(){
			var that=this;
			$.ajax({
				url:"/admin.php?m=user_group&a=getuser&ajax=1",
				dataType:"json",
				data:{
					nickname:that.nickname
				},
				success:function(res){
					if(res.error){
						that.suser={};
						that.suser_true=false;
					}else{
						that.suser_true=true;
						that.suser=res.data;
					}
					
				}
			})
		},
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/admin.php?m=user_group&a=people&ajax=1",
				dataType:"json",
				data:{
					gid:gid
				},
				success:function(res){
					that.list=res.data.list;
				}
			})
		},
		add:function(){
			var that=this;
			$.ajax({
				url:"/admin.php?m=user_group_people&a=save&ajax=1",
				dataType:"json",
				data:{
					gid:gid,
					userid:that.suser.userid
				},
				method:"POST",
				success:function(res){
					that.getPage()
				}
			})
		},
		del:function(item){
			var that=this;
			$.ajax({
				url:"/admin.php?m=user_group_people&a=delete&ajax=1",
				dataType:"json",
				data:{
					gid:gid,
					userid:item.userid
				},
				success:function(res){
					var list=that.list;
					var newList=[];
					for(var i in list){
						if(list[i].userid!=item.userid){
							newList.push(list[i])
						}
					}
					that.list=newList;
				}
			})
		}
	}
})