<div class="main-body">
	<div id="comment-list" class="comment-list">
	</div>
	<div class="h60"></div>
	<div class="comment-formbox">
		<div class="comment-input-btn" id="comment-btn">写跟帖</div>
		<form class="comment-formbox-form " id="comment-formbox-form">
			<textarea id="comment-content" class="comment-formbox-textarea"></textarea>
			<div class="comment-formbox-btns">
				<div class="comment-formbox-bt" id="comment-submit">评论</div>&nbsp;&nbsp;&nbsp;&nbsp;
				<div class="comment-formbox-bt " id="comment-cancel">取消</div>
			</div>
		</form>
	</div>
	<script id="comment-list-tpl" type="text/html">
		<%for(var i=0;i<list.length;i++){%>
		<% var $c=list[i];%>
		<div class="comment-item">
			<image class="comment-item-head" src="<%=$c.user_head%>.100x100.jpg"></image>
			<div class="flex-1">
				<div class="comment-item-nick">
					<%=$c.nickname%>
				</div>
				<div class="comment-item-tools">
					<div class="comment-item-addr">
						<%=$c.ip_city%>
					</div>
					<div class="comment-item-time">
						<%=$c.timeago%>
					</div>
				</div>
				<div class="comment-item-content js-comment-reply" pid="<%=$c.id%>" title="回复@<%=$c.nickname%>" >
					<%=$c.content%>
				</div>
			</div>
		</div>
		<%}%>
	</script>
</div>
<script src="/plugin/jquery/template-native.js"></script>
<script language="javascript">
    var comment_insubmit = false;
    var comment_objectid = '<?php echo $this->_var['comment_objectid']; ?>';
    var comment_tablename = '<?php echo $this->_var['comment_tablename']; ?>';
    var comment_f_userid = "<?php echo $this->_var['comment_f_userid']; ?>";
	var comment_pid=0;
 

</script>
