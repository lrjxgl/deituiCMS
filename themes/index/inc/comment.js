function commentlist(url) {
        $.get("/index.php?m=comment&tablename=" + comment_tablename + "&ajax=1&objectid=" + comment_objectid, function (
            data) {
            if (data.error) {
                return false;
            }
            var html = template("comment-list-tpl", data.data);
            $("#comment-list").html(html);
        }, "json")
    }

    $(function () {

        commentlist();


        $(document).on("click", "#comment-btn", function (e) {
            $("#comment-formbox-form").show();
			$("#comment-btn").hide();
        });
        $(document).on("click", "#comment-cancel", function (e) {
            $("#comment-content").val("");
            $("#comment-formbox-form").hide();
			$("#comment-btn").show();
            comment_pid = 0;
        });
        $(document).on("click", "#comment-submit", function () {
            if (comment_insubmit) return false;
            comment_insubmit = true;
            setTimeout(function () {
                comment_insubmit = false;
            }, 1000);
            var pdata = {
                content: $("#comment-content").val(),
                objectid: comment_objectid,
                tablename: comment_tablename,
				pid:comment_pid
				 
            }
            $.post("/index.php?m=comment&a=save&ajax=1", pdata, function (data) {
                if (data.error == 0) {
                    commentlist();
                    $("#comment-content").val("");
                    $("#comment-formbox-form").hide();
                    $("#comment-btn").show();
                    comment_pid = 0;
                    skyToast("评论成功");
                } else {
					skyToast(data.message);
                    if (data.error==1000) {
                        window.location="/index.php?m=login"
                    }  

                }
            }, "json")
        })

        $(document).on("click", ".js-comment-reply", function () {
            $("#commentbox").show();
            comment_pid = $(this).attr("pid");
			$("#comment-formbox-form").show();
			$("#comment-btn").hide();
            $("#comment-content").focus().val($(this).attr("title") + " ");
        });

    });