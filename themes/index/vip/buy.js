var app=new Vue({
	el:"#App",
	data:function(){
		return {
			list:[],
			aiuser:{},
			vipid:0,
			inpost:false
		}
	},
	created:function(){
		var that=this;
		this.getPage();
 
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=vip&a=buy&ajax=1",
				dataType:"json",
				success:function(res){
					that.list=res.data.list;
					that.aiuser=res.data.aiuser; 
				}
			})
		},
		goBuy:function(){
			var that=this;
			if(this.inpost){
				return false;
			}
			this.inpost=true;
			$.ajax({
				url:"/index.php?m=vip&a=save&ajax=1",
				dataType:"json",
				type:"POST",
				data:{
					vipid:this.vipid
				},
				success:function(res){
					that.inpost=false;
					if(res.error){
						skyToast(res.message);
						return false;
					}
					if(res.data.action=='pay'){
						window.location=res.data.payurl;
					}
				}
			})
		}
	}
})