// JavaScript Document
$(document).ready(function(e) {
	$("#goTwo").click(function(){
		if($(".check_boxId").is(":checked")){
			
	     	window.location.href="index.php?step=2";
		}
		else
		{
			alert("请同意安装协议");
		}
	});
	$("#goInstall").click(function(){
		$.post("index.php?step=33",$("#installForm").serialize(),function(res){
			if(res!="success"){
				alert(res);
			}else{
				window.location="index.php?step=4";
			}
		})
	})
});