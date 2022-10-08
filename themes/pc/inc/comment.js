var cmApp=new Vue({
	el:"#commentApp",
	data:function(){
		return {
			list:[],
			per_page:0,
			pageLoad:false,
			isFirst:true,
			content:"",
			formShow:false,
			cmBtn:true
		}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=comment&tablename=" + comment_tablename + "&ajax=1&objectid=" + comment_objectid,
				dataType:"json",
				success:function(res){
					if (res.error) {
					    return false;
					}
					that.list=res.data.list;
					that.per_page=res.data.per_page;
					that.isFirst=false;
				}
			})
		},
		getList:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=comment&tablename=" + comment_tablename + "&ajax=1&objectid=" + comment_objectid,
				dataType:"json",
				success:function(res){
					if (res.error) {
					    return false;
					}
					that.per_page=res.data.per_page;
					for(var i in res.data.list){
						that.list.push(res.data.list[i])
					}
					 
				}
			})
		},
		reply:function(pid,nickname){
			comment_pid=pid;
			this.content="@"+nickname+" ";
			this.cmBtn=false;
			this.formShow=true;
			$("#comment-content").focus();
		},
		submit:function(){
			if(!postCheck.canPost()){
				return false;
			}
			var that=this;
			var pdata = {
			    content: that.content,
			    objectid: comment_objectid,
			    tablename: comment_tablename,
				pid:comment_pid
				 
			}
			$.ajax({
				url:"/index.php?m=comment&a=save&ajax=1",
				dataType:"json",
				type:"POST",
				data:pdata,
				success:function(res){
					if (res.error==1000) {
					    window.location="/index.php?m=login"
					}else{
						comment_pid = 0;
						that.content="";
						that.cmBtn=true;
						that.formShow=false;
						skyToast("评论成功");
						that.getPage();
					} 
				}
			})
			 
		},
		cancel:function(){
			this.content="";
			comment_pid = 0;
			this.cmBtn=true;
			this.formShow=false;
		},
		goHome:function(userid){
			window.location="/module.php?m=forum_home&userid="+userid
		}
	}
})

 