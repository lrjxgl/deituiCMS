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
	},
	//仅供示例
	getLbs:function(){
		//地理位置
		var geolocation = new BMap.Geolocation();
		var latlng=GPS.get();
		var lat=0,lng=0;
		if(!latlng){
			
			geolocation.getCurrentPosition(function(r){
			if(this.getStatus() == BMAP_STATUS_SUCCESS){
				lat=r.point.lat;
				lng=r.point.lng;
				GPS.set({
					lat:lat,
					lng:lng
				});
				
				
			}
			else {
				alert('获取GPS失败'+this.getStatus());
				
			}        
			},{enableHighAccuracy: true})
		}else{
			lat=latlng.lat;
			lng=latlng.lng;
		}
		 
	}
}