$(document).on("click", ".js-upimg-btn", function() {
	var p = $(this).parents(".upimg-box");
	p.find(".js-upimg-file").click();
})
$(document).on("change", ".js-upimg-file", function(e) {
	var p = $(this).parents(".upimg-box");
	var src, url = window.URL || window.webkitURL || window.mozURL,
		files = e.target.files;
	for (var i = 0, len = files.length; i < len; ++i) {
		var file = files[i];

		if (url) {
			src = url.createObjectURL(file);
		} else {
			src = e.target.result;
		}
		lrz(file, {
				width: 1024
			}).then(function(rst) {

				$.post("/index.php?m=upload&a=base64", {
						content: rst.base64,
						tablename: "mod_shopmap",
						object_id: 0,
						inimgs: 0,
					},
					function(data) {
						console.log(data);
						p.find(".upimg-item").removeClass("none");
						p.find(".upimg-img").attr("src", data.trueimgurl);
						p.find(".imgurl").val(data.imgurl);
				 
					}, "json")
			})
			.catch(function(err) {
				console.log(err)
			})

	}
});
