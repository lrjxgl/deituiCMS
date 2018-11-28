<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<form method='post' id="f1" name="f1"  action='admin.php?m=weixin_sucai&a=save'>
      <input type='hidden' name='id' style='display:none;' value='<?php echo $this->_var['data']['id']; ?>' >
      <input type="hidden" name="wid" value="<?php if ($this->_var['data']): ?><?php echo $this->_var['data']['wid']; ?><?php else: ?><?php echo $this->_var['weixin']['id']; ?><?php endif; ?>" />
      <input type="hidden" name="pid" value="<?php echo $this->_var['pid']; ?>">
      <table class="table-add">
         
        <tr>
          <td width="100">标题：</td>
          <td><input type='text' name='title' id='title' value='<?php echo $this->_var['data']['title']; ?>' ></td>
        </tr>
        
        <tr>
        	<td>链接：</td>
            <td><input type="text" name="linkurl" value="<?php echo $this->_var['data']['linkurl']; ?>"  /></td>
        </tr>
        
        <tr>
    <td align="right">封面：</td>
    <td>
     <div class="js-upload-item">
     	<input type="file" id="upa" class="js-upload-file" style="display: none;" />
     	<div class="upimg-btn js-upload-btn">+</div>
     	<input type="hidden" name="imgurl" class="js-imgurl" value="<?php echo $this->_var['data']['imgurl']; ?>" />
     	<div class="js-imgbox">
     		<?php if ($this->_var['data']['imgurl']): ?>
     		<img src="<?php echo images_site($this->_var['data']['imgurl']); ?>">
     		<?php endif; ?>
     	</div>
     </div>
      </td>
  </tr>
       
        
        <?php if ($this->_var['data']['dateline']): ?>
        <tr>
          <td>添加时间：</td>
          <td><?php echo date("Y-m-d H:i:s",$this->_var['data']['dateline']); ?></td>
        </tr>
        <?php endif; ?>
         
        
        <tr>
	
    <tr>
    	<td>描述</td>
    	<td><textarea name="description" style="width:90%; height:50px;"><?php echo $this->_var['data']['description']; ?></textarea></td>
    </tr>
  
  
        
        <tr><td>内容</td><td>
		 
		<script type="text/html" id="content" name="content" style="width:100%; height:400px;"><?php echo $this->_var['data']['content']; ?></script></td></tr>
      
      </table>
			<button class="btn-row-submit" type="submit">保存</button>
    </form>


 
 
<?php echo $this->fetch('footer.html'); ?>
<script src="<?php echo $this->_var['skins']; ?>js/upload.js"></script>
<?php loadEditor();?>
<script language="javascript">
 
var editor=UE.getEditor('content',options)
</script>
</body>
</html>
