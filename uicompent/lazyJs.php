<script>
	var lazyFiles=[];
	function lazyJs(files,i,lazyJsCallback){
		if(files.length>=i){
			lazyJsCallback();
			return false;
		}
		
		for(var j in lazyFiles){
			if(files[i]==lazyFiles[j]){
				lazyJs(files,i+1,callback);
				return false;
			}
		}
	    var script = document.createElement("script");
	    script.type = "text/javascript";
	    if(script.readyState){
	        script.onreadystatechange = function(){
	            if(script.readyState=="loaded"||script.readyState=="complete"){
	                script.onreadystatechange = null;
	                lazyJs(files,i+1,callback);
	            }
	        }
	    }else{
	        script.onload = function(){
	           lazyJs(files,i+1,callback);
	        }
	    }
	 
	    script.src= files[i];
	    document.getElementsByTagName("head")[0].appendChild(script);
	}
</script>