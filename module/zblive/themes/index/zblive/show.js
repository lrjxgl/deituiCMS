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
			productShow:false,
			m3u8url:"",
			mp4url:""
		}
	},
	created:function(){
		this.getPage();
		this.getMsgList();
		
	},
	methods:{
		getPage:function(){

			var that=this;
			$.ajax({
				url:"/module.php?m=zblive&a=show&ajax=1&id="+room_id,
				dataType:"json",
				success:function(res){
					that.data=res.data.zblive;
					that.getProList();
					that.pageLoad=true;
					that.m3u8url=res.data.m3u8url;
					that.mp4url=res.data.mp4url;
					setTimeout(function(){
						if(iswap=="1"){
							video=document.getElementById("video");
							
							video.onclick=function(){
								if(video.paused){
									video.play();
									$("#videoPlay").hide();
								} 
								
							}
						}else{
							$("#videoPlay").hide();
							var player = new Aliplayer({
							  "id": "player-con",
							  "source": that.mp4url,
							  "width": "100%",
							  "height": "500px",
							  "autoplay": true,
							  "isLive": true,
							  "rePlay": false,
							  "playsinline": true,
							  "preload": true,
							  "controlBarVisibility": "hover",
							  "useH5Prism": true
							}, function (player) {
							    console.log("The player is created");
							  }
							);
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
				url:"/module.php?m="+that.data.tablename+"&a=list&ajax=1&ids="+that.data.proids,
				dataType:"json",
				success:function(res){
					
					that.proList=res.data.list;
				}
			})
		},
		goProduct:function(id){
			window.location="/module.php?m="+this.data.tablename+"&a=show&id="+id;
		},	
		showQuan:function(item){
			this.productShow=true;
			this.product=item;
		}
	}
})