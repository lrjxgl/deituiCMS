<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<?php echo $this->fetch('weixin/side.html'); ?>
 
 <div class="main-body"><?php echo $this->fetch('weixin_command/nav.html'); ?>
    <form method='post' action='admin.php?m=weixin_command&a=save'>
     <input type='hidden' name='id' style='display:none;' value='<?php echo $this->_var['data']['id']; ?>' >
     <input type="hidden" name="wid" value="<?php if ($this->_var['data']): ?><?php echo $this->_var['data']['wid']; ?><?php else: ?><?php echo $this->_var['weixin']['id']; ?><?php endif; ?>" />
      <table class='table table-bordered' width='100%'>
 				<col style="width: 100px;" />
        <tr>
          <td>命令名称：</td>
          <td><input type='text' name='title' id='title' value='<?php echo $this->_var['data']['title']; ?>' ></td>
        </tr>
        
        <tr>
        	<td>默认命令：</td>
            <td><input type="radio" name="isdefault" value="1" <?php if ($this->_var['data']['isdefault']): ?> checked="checked"<?php endif; ?> />是 <input type="radio" name="isdefault" value="0"  <?php if (! $this->_var['data']['isdefault']): ?> checked="checked"<?php endif; ?> />否</td>
        </tr>
        
        <tr>
          <td>命令：</td>
          <td><input type='text' name='command' id='command' value='<?php echo $this->_var['data']['command']; ?>' ></td>
        </tr>
        
        <tr>
        	<td>方法：</td>
            <td><select name="fun">
            <option value="">无</option>
            <?php $_from = $this->_var['fun_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
            <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['fun']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select></td>
        </tr>
        
        <tr>
          <td>命令类型：</td>
          <td><select name="type_id">
          	<?php $_from = $this->_var['type_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
            <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['type_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select></td>
        </tr>
        
        <tr>
        	<td>素材：</td>
            <td><input type="text" name="sc_id" value="<?php echo $this->_var['data']['sc_id']; ?>" /> 素材id</td>
        </tr>
        
        <tr>
          <td>内容：</td>
          <td><textarea name='content' id='content'  ><?php echo $this->_var['data']['content']; ?></textarea> </td>
        </tr>
        <?php if ($this->_var['data']['dateline']): ?>
        <tr>
          <td>添加时间：</td>
          <td><?php echo date("Y-m-d H:i:s",$this->_var['data']['dateline']); ?></td>
        </tr>
        <?php endif; ?>
      
      </table>
      <div class="btn-row-submit js-submit"  >保存</div>
    </form>
  </div>
</div>
<?php echo $this->fetch('footer.html'); ?>