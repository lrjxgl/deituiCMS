var GPS={
	expire:600,
	set:function(v){
		v.expire=Date.parse(new Date())/1000+this.expire;
		var str=JSON.stringify(v);
		localStorage.setItem("gps",str);
	},
	get:function(){
		var v=localStorage.getItem("gps");
		var json=JSON.parse(v);
		if(!json){
			return false;
		}
		var time=Date.parse(new Date())/1000;
		if(json.expire<time){
			return false;
		}else{
			return json;
		}
	}
}