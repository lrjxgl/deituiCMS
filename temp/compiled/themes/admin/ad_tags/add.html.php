<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('ad/nav.html'); ?>
<div class="main-body">
  
    <form method='post' action='admin.php?m=ad_tags&a=save'>
    <input type='hidden' name='tag_id' style='display:none;' value='<?php echo $this->_var['data']['tag_id']; ?>' >
      <table class='table table-bordered' width='100%'>
        <col style="width: 90px; text-align: right;" />
        <tr>
          <td>标题：</td>
          <td><input type='text' name='title' id='title' value='<?php echo $this->_var['data']['title']; ?>' ></td>
        </tr>
        
        <tr>
          <td>上级分类：</td>
          <td><select name="pid">
          	<option value="0">请选择</option>
            <?php $_from = $this->_var['pid_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
            <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['pid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['title']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select> </td>
        </tr>
        
        <tr>
        	<td>唯一代号：</td>
            <td><input type="text" name="tagno" value="<?php echo $this->_var['data']['tagno']; ?>" /></td>
        </tr>
        
        <tr>
          <td>排序：</td>
          <td><input type='text' name='orderindex' id='orderindex' value='<?php echo $this->_var['data']['orderindex']; ?>' ></td>
        </tr>
        <tr>
          <td>状态：</td>
          <td><input type="radio" name="status" value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked="checked"<?php endif; ?> />隐藏 &nbsp; 
          <input type="radio" name="status" value="2" <?php if ($this->_var['data']['status'] == 2): ?> checked="checked"<?php endif; ?> />显示</td>
        </tr>
        <?php if ($this->_var['data']): ?>
        <tr>
          <td>添加时间：</td>
          <td><?php echo date("Y-m-d H:i:s",$this->_var['data']['dateline']); ?></td>
        </tr>
        <?php endif; ?>
         
        <tr>
          <td>图片宽度：</td>
          <td><input type='text' name='width' id='width' value='<?php echo $this->_var['data']['width']; ?>' ></td>
        </tr>
        <tr>
          <td>图片高度：</td>
          <td><input type='text' name='height' id='height' value='<?php echo $this->_var['data']['height']; ?>' ></td>
        </tr>
        
      </table>
      <div class="btn-row-submit js-submit">保存</div>
    </form>
  </div>
 
<?php echo $this->fetch('footer.html'); ?>