var App=new Vue({
	el:"#App",
	data:function(){
		return {
			pageLoad:false,
			 
			tab:"notice"
			
		}
	},
	created:function(){
	  
	},
	methods:{
		setTab:function(t){
			this.tab=t;
			 
		}
		 
	}
})
