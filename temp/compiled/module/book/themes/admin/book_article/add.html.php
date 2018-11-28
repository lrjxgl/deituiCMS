<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<style>
			.flex-table{
				display: flex;
				padding: 10px;
				background-color: #fff;
			}
			.flex-table .flex-60{
				width: 60px;
				margin-right: 10px;
			}
			.flex-table .flex-1{
				flex: 1;
			}
			.textarea{
				width: 90%;
				height: 60px;
				padding: 5px;
			}
			.btn-upload{
				width: 80px;
				text-align: center;
				height: 36px;
				line-height: 36px;
				background-color: #006699;
				cursor: pointer;
			}
		</style>
	<body >
		<div class="tabs-border">
			<a class="item" href="/moduleadmin.php?m=book_article">文章列表</a>
			<a class="item active" href="/moduleadmin.php?m=book_article&a=add">添加文章</a>
		</div>	
 <div class="main-body">
<form method="post" id="form" action="/module.php?m=book_article&a=save&ajax=1">
<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>" >
<div class="flex-table">
	<div class="flex-60">标题</div>
	<div class="flex-1">
		<input type="text" name="title" value="<?php echo $this->_var['data']['title']; ?>" />
	</div>
</div>
<div class="flex-table">
	<div class="flex-60">描述</div>
	<div class="flex-1">
		<textarea class="textarea" name="description" id="description" ><?php echo $this->_var['data']['description']; ?></textarea>
	</div>
</div>
<div class="flex-table">
	<div class="flex-60">Mp3</div>
	<div class="flex-1">
  		<div id="upmp3-btn" class="btn">上传mp3</div>
			<span id="mp3progress"></span>
			<div style="padding: 10px; color: #f60;">mp3小于5G，只支持mp3格式</div>
			<div id="mp3box">
				<?php if ($this->_var['data']['mp3url']): ?>
				<audio controls="" src="<?php echo images_site($this->_var['data']['mp3url']); ?>" ></audio>
				<?php endif; ?>
			</div>
			
			<input type="hidden" name="mp3url" id="mp3url" value="<?php echo $this->_var['data']['mp3url']; ?>" />
		 
			<div style="display: none;">
				<input type="file" id="upMp3" name="upfile" />
			</div>
	</div>
</div>

<div class="flex-table">
	<div class="flex-60">Mp4</div>
	<div class="flex-1">
  		
			<div id="upmp4-btn" class="btn">上传Mp4</div>
			<span id="progress"></span>
			<div style="padding: 10px; color: #f60;">视频小于5G，只支持mp4格式</div>
			<div id="mp4box">
				<?php if ($this->_var['data']['mp4url']): ?>
				<video controls="" src="<?php echo images_site($this->_var['data']['mp4url']); ?>" class="video"></video>
				<?php endif; ?>
			</div>
			
			<input type="hidden" name="mp4url" id="mp4url" value="<?php echo $this->_var['data']['mp4url']; ?>" />
		 
			<div style="display: none;">
				<input type="file" id="upMp4" name="upfile" />
			</div>
             
	</div>
</div>

 

<div class="flex-table">
	<div class="flex-60">内容</div>
	<div class="flex-1">
		<script type="text/plain" id="content"  name="content" ><?php echo $this->_var['data']['content']; ?></script>
	</div>
</div>
<div class="flex-table">
	<div class="flex-60">&nbsp;</div>
	<div class="flex-1">
		 <div class="btn-row-submit" id="submit">保存</div> 
	</div>
</div>	

</form>
<?php echo $this->fetch('footer.html'); ?>
<script src="<?php echo $this->_var['skins']; ?>js/oss.js"></script> 
<?php loadEditor();?>
<script language="javascript">
 
var editor=UE.getEditor('content',options);
$(document).on("click","#submit",function(){
	$.post("/moduleadmin.php?m=book_article&a=save&ajax=1",$("#form").serialize(),function(data){
		skyToast(data.message);
	},"json")
})
</script>
</body>
</html>