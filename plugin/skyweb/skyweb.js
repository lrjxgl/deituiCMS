var SITE="http://"+window.location.host+"/";
var INDEXPAGE="/index.php";

if(typeof(Zepto)!="undefined"){
	 jQuery=Zepto;
}

function goBack(goindex){
	if(typeof(goindex)=="undefined") goindex="-1";
	if (document.referrer != null && document.referrer != "") {
          window.history.go(goindex);
     } else{
			window.location=INDEXPAGE;
	}
}
/*图片缩放*/
function thumb(ImgD,FitWidth,FitHeight){
     var image=new Image();
     image.src=ImgD.src;
     if(image.width>0 && image.height>0){
         if(image.width/image.height>= FitWidth/FitHeight){
             if(image.width>FitWidth){
                 ImgD.width=FitWidth;
                 ImgD.height=(image.height*FitWidth)/image.width;
             }else{
                 ImgD.width=image.width; 
                ImgD.height=image.height;
             }
         } else{
             if(image.height>FitHeight){
                 ImgD.height=FitHeight;
                 ImgD.width=(image.width*FitHeight)/image.height;
             }else{
                 ImgD.width=image.width; 
                ImgD.height=image.height;
             } 
        }
     }
 }
/*弹框*/
function showbox(title,content,width,height){
	if($("#showbox_container").length==0){
		var html='<div id="showBox_opac" ></div><div id="showBox" onDblClick="showboxClose()" style=" width:100%;  "><div id="showbox_container"><div id="showBox_nav"><div id="showBox_title">  </div><div id="showBox_close" onclick="showboxClose()">关闭</a></div></div><div id="showBox_content"></div><div id="showBox_footer"></div></div></div>'; 
		$("body").append(html); 
	}
	$("#showBox_title").html(title);
	$("#showBox_content").html(content);
	$("#showBox").show();
	$("#showBox_opac").show();
	var mt= Math.max(10,( window.innerHeight-parseInt(height))/2);
	$("#showbox_container").css({width:width-10,minHeight:height,marginTop:mt});
	setTimeout(function(){
		width=$("#showbox_container").css("width");
		height=$("#showbox_container").css("height");
		height=parseInt(height);
		width=parseInt(width);
		var mt= Math.max(10,( window.innerHeight-parseInt(height))/2);
		$("#showbox_container").css({width:width-10,minHeight:height,marginTop:mt});
	},300);
	 
}

function showboxClose(){
	$("#showBox_opac").hide();
	$("#showBox_content").html("");
	$("#showbox_container").css({"width":"100%",height:"inherit"});
	
	$("#showBox").css("display","none");
}
/*Start alert*/
function skyAlert(content,title,url,url2){
	var len=$("#alert").length;
	var html='';
	if(typeof(title)=='undefined'){
		var title='提醒';
	}
	if(typeof(url)=='undefined'){
		url='javascript:;';
	}
	html+='<div class="hd"><span>'+title+'</span><div class="close alert_close"><i class="fa fa-times"></i></div></div>';
	html+='<div class="cont"><div class="inner">'+content+'</div></div>';
	html+='<div class="ft">';
	html+='<a href="'+url+'" class="alert_close aurl success">确定</a>';
	if(typeof(url2)!=='undefined'){  
		html+='<a href="'+url2+'" class="aurl alert_close fail">取消</a>';
	}
	html+='</div>';
	if(len>0){
		$("#alert").html(html).show();
	}else{
		html='<div class="alert" id="alert">'+html+'</div>';
		$("body").append(html);
		$("#alert").show();
	}
	setTimeout(function(){
		width=$("#alert").css("width");
		height=$("#alert").css("height");
		var mt=($(window).height()-parseInt(height))/2;
		$("#alert").css({width:width,minHeight:height,top:mt});
	},100);
	$(document).on("click",".alert_close",function(){
		$("#alert").hide();
	});
}

/*End Alert*/


/*Start toast*/
function skyToast(message,type){
	if(typeof(type)=="undefined"){
		type="";
	}
	if($("#toast").length==0){
		var html="<div id='toast'><div class='bg "+type+"'>"+message+"</div></div>";
		$("body").append(html);		
	}else{
		$("#toast").html("<div class='bg "+type+"'>"+message+"</div>");
	}
	$("#toast").show();
	setTimeout(function(){
		$("#toast").hide();
	},2000);
}
/*End toast*/

function placeholder(obj){
		obj.bind({
			"focus":function(){  
			 if($(this).val()==$(this).attr("placeholder")){
				$(this).val(""); 
			 }
			},
			"blur":function(){
				if($(this).val()==""){
					$(this).val($(this).attr("placeholder")); 
				 }
			}
		 });
}

function imgLazy(o){
	setTimeout(function(){
		var obj=$("body").find(o);
		var len=obj.length;
		for(var i=0;i<len;i++){
			obj.eq(i).attr("src",obj.eq(i).attr("url"));
		}
	},200);
}

//Start DropDown
+function ($) {
  'use strict';

  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.dropdown-backdrop'
  var toggle   = '[data-toggle=dropdown]'
  var Dropdown = function (element) {
    $(element).on('click.bs.dropdown', this.toggle)
  }

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this)

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    clearMenus()

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $('<div class="dropdown-backdrop"/>').insertAfter($(this)).on('click', clearMenus)
      }

      var relatedTarget = { relatedTarget: this }
      $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $parent
        .toggleClass('open')
        .trigger('shown.bs.dropdown', relatedTarget)

      $this.focus()
    }

    return false
  }

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27)/.test(e.keyCode)) return

    var $this = $(this)

    e.preventDefault()
    e.stopPropagation()

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    if (!isActive || (isActive && e.keyCode == 27)) {
      if (e.which == 27) $parent.find(toggle).focus()
      return $this.click()
    }

    var desc = ' li:not(.divider):visible a'
    var $items = $parent.find('[role=menu]' + desc + ', [role=listbox]' + desc)

    if (!$items.length) return

    var index = $items.index($items.filter(':focus'))

    if (e.keyCode == 38 && index > 0)                 index--                        // up
    if (e.keyCode == 40 && index < $items.length - 1) index++                        // down
    if (!~index)                                      index = 0

    $items.eq(index).focus()
  }

  function clearMenus(e) {
    $(backdrop).remove()
    $(toggle).each(function () {
      var $parent = getParent($(this))
      var relatedTarget = { relatedTarget: this }
      if (!$parent.hasClass('open')) return
      $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))
      if (e.isDefaultPrevented()) return
      $parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
    })
  }

  function getParent($this) {
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
    }

    var $parent = selector && $(selector)

    return $parent && $parent.length ? $parent : $this.parent()
  }


  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  var old = $.fn.dropdown

  $.fn.dropdown = function (option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.dropdown')

      if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  $.fn.dropdown.Constructor = Dropdown


  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document)
    .on('click.bs.dropdown.data-api', clearMenus)
    .on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
    .on('keydown.bs.dropdown.data-api', toggle + ', [role=menu], [role=listbox]', Dropdown.prototype.keydown)

}(jQuery);
//ENd DropDown

 
var ajax_jsa_loaded=false;
function ajax_jsa(){
	 
	//加载js文件
	var sr=$("body").find(".jsa-src");
	var srlen=sr.length;
	for(var j=0;j<srlen;j++){
		var src=$(sr[j]).attr("src");
			loadScript($(sr[j]).attr("src"),ajax_jsa_isload);  
	}
	ajax_jsa_text();
}

function ajax_jsa_text(){
	//加载js片段 0.1s延时加载
	
	if(!ajax_jsa_loaded){
		setTimeout("ajax_jsa_text()",1);
	}else{	 
		var d=$("body").find(".jsa-text");
		var jslen=d.length;
		if(jslen>0){
		for(var i=0;i<jslen;i++){
							//alert(d[i].innerHTML);
			eval(d[i].innerHTML);
		}
		}
	}
}
function ajax_jsa_isload(){
	ajax_jsa_loaded=true;
}

function loadScript(url,callback) {
	var head = document.head || document.getElementsByTagName("head")[0] || document.documentElement,
	script,options,s;
	if (typeof url === "object") { 
		options = url;
		url = undefined;
	}
	s = options || {};
	url = url || s.url;
	callback = callback || s.success;
	script = document.createElement("script");
	script.async = s.async || false;
	script.type = "text/javascript";
	if (s.charset) {
		script.charset = s.charset;
	}
	if(s.cache === false){
		url = url+( /\?/.test( url ) ? "&" : "?" )+ "_=" +(new Date()).getTime();
	}
	script.src = url;
	head.insertBefore(script, head.firstChild);
	if(callback){
		ajax_jsa_loaded=false;
		document.addEventListener ? script.addEventListener("load", callback, false) : script.onreadystatechange = function() {
			if (/loaded|complete/.test(script.readyState)) {
			script.onreadystatechange = null
			
			callback()
			}
		}
	}
}

function setCookie(name,value)//两个参数，一个是cookie的名子，一个是值
{
	 
	var Days = 30; //此 cookie 将被保存 30 天
	var exp = new Date(); //new Date("December 31, 9998");
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//取cookies函数
{
	var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
	if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)//删除cookie
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

/*文件上传*/
function skyUpload(upid,url,success,error,uploadProgress)
{
		 var vFD = new FormData();
		 var f= document.getElementById(upid).files;
		 	$("#"+upid+"loading").show();
		 for(var i=0;i<f.length;i++){ 
		vFD.append('upimg', document.getElementById(upid).files[i]);
		// create XMLHttpRequest object, adding few event listeners, and POSTing our data
		var oXHR = new XMLHttpRequest();        
		oXHR.addEventListener('load', success, false);
		oXHR.addEventListener('error', error, false);
		if(uploadProgress!=undefined){
			oXHR.upload.addEventListener("progress", uploadProgress, false);
		}
		oXHR.open('POST',url);
		oXHR.send(vFD);
	
		 }
}
/*
function uploadFinish(e){
		var data=eval("("+e.target.responseText+")");
		$("#uploading").hide()
		if(data.error != '')
        {
           skyToast(data.msg);
        }else
        {
            $("#imgShow").html("<img src='/"+data.imgurl+".100x100.jpg' width='100'>");
			$("#imgurl").val(data.imgurl);
         }
}
	
function uploadError(e) { // upload error
		skyToast("上传出错了");
}
*/

$(function(){
	$(document).on("click mouseover",".tabs a",function(e){ 
		e.preventDefault();
		var p=$(this).parents(".tabs-box");
		p.find("a").removeClass("active");
		p.find(".tabs-hd").hide();
		$(this).addClass("active");
		
		var href=$(this).attr("href");
		if(href.match(/#/)){
			 var id=href.substr(1);
			 $(".tabs-item").hide();
			 $("#"+id).show();
		}else{
			var id=$(this).attr("data-id");
			if(id==null){
				window.location=href;
			}else{
				$.get(href,function(data){			
					$(".tabs-item").hide();				
					$("#"+id).html(data).show();
				});
			}
		}
	});
	
	/*Start Panel*/
	$(document).on("click",".panel-btn",function(e){
		e.preventDefault();
		$("#panel-box").toggle();
	});
	$(document).on("click",".panel-close",function(e){
		e.preventDefault();
		$("#panel-box").hide();
	});
	/*End Panel*/
	$(".goback").bind("click",function(){
		goBack();
		
	});
	
	
});