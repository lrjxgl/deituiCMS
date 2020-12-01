function onMp4Progress(evt) {
	var loaded = evt.loaded; //已经上传大小情况 
	var tot = evt.total; //附件总大小 
	var per = Math.floor(100 * loaded / tot); //已经上传的百分比 
	$("#progress").html(per + "%");
	$("#progress").css("width", per + "%");
}

$(document).on("click", "#upmp4-btn", function() {
	$("#upvideo").click();
})
$(document).on("change", "#upvideo", function() {
	var fdata = new FormData();

	$.get("/index.php?m=ossupload&a=auth", function(data) {
		var file = document.querySelector("#upvideo").files[0];

		if (file == undefined) {
			console.log("Empty");
			return false;
		}


		fdata.append("OSSAccessKeyId", data.accessid);
		fdata.append("policy", data.policy);
		fdata.append("Signature", data.sign);
		fdata.append("key", data.key + file.name);
		fdata.append("callback", data.callback);

		fdata.append("file", file);
		$.ajax({
			url: data.url,
			type: 'POST',
			data: fdata,
			contentType: false,
			processData: false,
			dataType: "json",
			xhr: function() {
				var xhr = $.ajaxSettings.xhr();
				if (onMp4Progress && xhr.upload) {
					xhr.upload.addEventListener("progress", onMp4Progress, false);
					return xhr;
				}
			},
			success: function(data) {
				console.log(data);
				$("#mp4url").val(data.filename);
				var html = '<video controls="" src="' + data.truename + '" class="video"></video>';
				$("#mp4box").html(html);
			},
			error: function(returndata) {
				console.log(returndata);
			}
		});
	}, "json")

})
