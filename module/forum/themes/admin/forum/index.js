laydate.render({
	elem: "#stime"
})
laydate.render({
	elem: "#etime"
});
var id=0;
$(".chkall").click(function() {
	if ($(this).prop("checked") == true) {
		$(".ids").prop("checked", true);
	} else {
		$(".ids").prop("checked", false);
	}
});
$(document).on("change", "#gid", function() {
	var gid = $(this).val();
	$.get("/module.php?m=forum_group&a=catlist&ajax=1&gid=" + gid, function(data) {
		var html = '<option value="0">请选择</option>';

		for (var i = 0; i < data.data.length; i++) {
			html = html + '<option value="' + data.data[i].catid + '">' + data.data[i].title + '</option>';
		}
		console.log(html);
		$("#catid").html(html);
	}, "json")
})
$(document).on("change", "#gid2", function() {
	var gid = $(this).val();
	$.get("/module.php?m=forum_group&a=catlist&ajax=1&gid=" + gid, function(data) {
		var html = '<option value="0">请选择</option>';

		for (var i = 0; i < data.data.length; i++) {
			html = html + '<option value="' + data.data[i].catid + '">' + data.data[i].title + '</option>';
		}
		console.log(html);
		$("#catid2").html(html);
	}, "json")
})
$(document).on("click", "#changeCategory", function() {
	$.post("/moduleadmin.php?m=forum&a=category&ajax=1", $("#cForm").serialize(), function(res) {
		skyToast(res.message);
		if (!res.error) {
			window.location.reload();
		}
	}, "json");
})
$(document).on("click", "#delAll", function() {
	$.post("/moduleadmin.php?m=forum&a=delAll&ajax=1", $("#cForm").serialize(), function(res) {
		skyToast(res.message);
		if (!res.error) {
			window.location.reload();
		}
	}, "json");
})
$(document).on("click", "#changeGroup", function() {
	$.post("/moduleadmin.php?m=forum&a=tags&ajax=1", $("#cForm").serialize(), function(res) {
		skyToast(res.message);
		if (!res.error) {
			window.location.reload();
		}
	}, "json");
})

$(document).on("click",".js-add-gold",function(){
	id=$(this).attr("v");
	$("#goldModal").show();
})
$(document).on("click","#js-send-gold",function(){
	$.ajax({
		url:"/moduleadmin.php?m=forum&a=sendgold&ajax=1",
		data:{
			gold:$("#js-gold-num").val(),
			id:id
		},
		dataType:"json",
		success:function(res){
			skyToast(res.message);
			if(res.error){
				return false;
			}
			$(".gold-num"+id).html(res.data);
			$("#goldModal").hide()
		}
	})
})