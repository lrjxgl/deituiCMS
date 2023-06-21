var pageCache={
	setCache:function(obj,k,expire){
		 
		var  v=obj.$data;
		if(expire==undefined){
			expire=120;
		}
		v.expire=Date.parse(new  Date())/1000+expire
		sessionStorage .setItem(k,JSON.stringify(v));
	},
	getCache:function(obj,k){
		 
		var res=sessionStorage .getItem(k);
		 
		if(res!=null){
			var d=JSON.parse(res);
		 
			if(Date.parse(new  Date())/1000>d.expire){
				return false;
			}
			for(var i in obj.$data){
				for(var j in d){
					if(i==j){
						obj.$data[i]=d[j]
					}
				}
			}
			return true;
		}
		return false;
	},
}