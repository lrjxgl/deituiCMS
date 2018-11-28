<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	 <a class="item " href="<?php echo $this->_var['appadmin']; ?>?m=user_rank">等级管理</a> 
   <a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=user_rank&a=add">等级添加</a> 
</div>
<div class="main-body">
<form method='post' action='admin.php?m=user_rank&a=save'>
<input type='hidden' name='id' style='display:none;' value='<?php echo $this->_var['data']['id']; ?>' >
 <table class='table table-bordered' width='100%'>
 	<col style="width: 90px;" />
  <tr><td>等级名称：</td><td><input type='text' name='rank_name' id='rank_name' value='<?php echo $this->_var['data']['rank_name']; ?>' ></td></tr>
  <tr><td>最低分：</td><td><input type='text' name='min_grade' id='min_grade' value='<?php echo $this->_var['data']['min_grade']; ?>' ></td></tr>
  <tr><td>最高分：</td><td><input type='text' name='max_grade' id='max_grade' value='<?php echo $this->_var['data']['max_grade']; ?>' ></td></tr>
  <tr><td>折扣：</td><td><input class="w100" type='text' name='discount' id='discount' value='<?php echo $this->_var['data']['discount']; ?>' >%</td></tr>
   <tr>
    <td align="right">图片：</td>
    <td>
     <div class="js-upload-item">
     	<input type="file" id="upa" class="js-upload-file" style="display: none;" />
     	<div class="upimg-btn js-upload-btn">+</div>
     	<input type="hidden" name="logo" class="js-imgurl" value="<?php echo $this->_var['data']['logo']; ?>" />
     	<div class="js-imgbox">
     		<?php if ($this->_var['data']['logo']): ?>
     		<img src="<?php echo images_site($this->_var['data']['logo']); ?>.100x100.jpg">
     		<?php endif; ?>
     	</div>
     </div>
      </td>
  </tr>
 </table>
  <div class="btn-row-submit js-submit"  >保存</div>
</form>
</div>
<?php echo $this->fetch('footer.html'); ?>
<script  src="/static/admin/js/upload.js"></script>
</body>
</html>