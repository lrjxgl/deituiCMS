new Vue({
	el:"#App",
	data:function(){
		return {
			pageLoad:false,
			data:{},
			proList:[],
			msgList:[],
			cmContent:"",
			product:{},
			productShow:false
		}
	},
	created:function(){
		this.getPage();
		this.getMsgList();
		this.getProList();
	},
	methods:{
		getPage:function(){

			var that=this;
			$.ajax({
				url:"/module.php?m=zblive&a=show&ajax=1&id="+room_id,
				dataType:"json",
				success:function(res){
					that.data=res.data.zblive;
					that.pageLoad=true;
					setTimeout(function(){
						video=document.getElementById("video");
						
						video.onclick=function(){
							if(video.paused){
								video.play();
								$("#videoPlay").hide();
							} 
							
						}
					},100)
					
				}
			})
		},
		getMsgList:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=zblive_msg&a=list&ajax=1&room_id="+room_id,
				dataType:"json",
				success:function(res){
					that.msgList=res.data.list;
				}
			})
		},
		sendMsg:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=zblive_msg&a=save&ajax=1",
				data:{
					room_id:room_id,
					content:this.cmContent
				},
				type:"POST",
				dataType:"json",
				success:function(res){
					that.cmContent="";
					that.getMsgList(); 
				}
			})
		},
		getProList:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=taoke&a=list&ajax=1&room_id="+room_id,
				dataType:"json",
				success:function(res){
					
					that.proList=res.data.data;
				}
			})
		},
		showQuan:function(item){
			this.productShow=true;
			this.product=item;
		}
	}
})