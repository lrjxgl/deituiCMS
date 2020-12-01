// JavaScript Document
function replace_faces(str){
	return str.replace(/\[(emo_\d+)\]/g ,"<img src=\"/static/emo/$1.gif\">");
}
function replace_img(str){
	return str.replace(/\[:img-(\d+)\]/g ,"<img class=\"msg-r-img\" src=\"/index.php?m=attach&a=getimg&id=$1\">");
}

function replace_audio(str){
	return str.replace(/\[:audio-(\d+)\]/g ,"<audio controls  class=\"msg-r-audio\" src=\"/index.php?m=attach&a=get&id=$1\">");
}

function replace_file(str){
	return str.replace(/\[:file-(\d+)\]/g ,'<a href="/index.php?m=attach&a=get&id=$1" target="_blank" class="msg-r-file">附件$1</a>');
}
function replace_msg(str){
	str=replace_faces(str);
	str=replace_img(str);
	str=replace_file(str);
	str=replace_audio(str);
	return str;
}



function cache_set($k,$v){
	localStorage.setItem($k,$v);
}

function cache_get($k){
	var data=localStorage.getItem($k);
	 
	if(data==null) return '';
	return data;
}

Date.prototype.Format = function(fmt)   
{ //author: meizz   
  var o = {   
    "M+" : this.getMonth()+1,                 //月份   
    "d+" : this.getDate(),                    //日   
    "h+" : this.getHours(),                   //小时   
    "m+" : this.getMinutes(),                 //分   
    "s+" : this.getSeconds(),                 //秒   
    "q+" : Math.floor((this.getMonth()+3)/3), //季度   
    "S"  : this.getMilliseconds()             //毫秒   
  };   
  if(/(y+)/.test(fmt))   
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
  for(var k in o)   
    if(new RegExp("("+ k +")").test(fmt))   
  fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
  return fmt;   
}