<?php echo $this->fetch('header.html'); ?>
<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<?php echo $this->fetch('weixin/side.html'); ?>
       
		<div class="main-body">		 
		<?php echo $this->fetch('weixin_menu/nav.html'); ?>
      <form method="post" action="<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=save">
        <input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
        <input type="hidden" name="wid" value="<?php if ($this->_var['data']['wid']): ?><?php echo $this->_var['data']['wid']; ?><?php else: ?><?php echo $_GET['wid']; ?><?php endif; ?>" />
        <table class="table-add">
          <tr>
            <td width="100">名称</td>
            <td><input type="text" class="w98" name="title" value="<?php echo $this->_var['data']['title']; ?>" /></td>
          </tr>
          
          <tr>
          	<td>类型</td>
            <td><select name="w_type">
            	<?php $_from = $this->_var['w_type_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
                <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['w_type']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select></td>
          </tr>
          
          <tr><td>key</td><td><input type="text" class="w98"  name="w_key" value="<?php echo $this->_var['data']['w_key']; ?>" /></td></tr>
         	
         <tr><td>链接</td><td><input type="text" class="w98"  name="w_url" value="<?php echo $this->_var['data']['w_url']; ?>" /></td></tr>
          
          <tr>
          	<td>排序</td>
            <td><input type="text" name="orderindex" value="<?php echo $this->_var['data']['orderindex']; ?>" /></td>
          </tr>
          
          <tr>
          	<td>素材</td>
            <td><input type="text" name="sc_id" value="<?php echo $this->_var['data']['sc_id']; ?>" /></td>
          </tr>
          <tr>
          	<td>内容</td>
          	<td>
          		<textarea name="content" ><?php echo $this->_var['data']['content']; ?></textarea>
          	</td>
          </tr>
          <tr>
            <td>上级分类</td>
            <td><select name="pid">
           		 <option value="0">作为一级菜单</option>
            	<?php $_from = $this->_var['pid_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
                <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['data']['pid'] == $this->_var['k']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select></td>
          </tr>
          
        </table>
         <div class="btn-row-submit js-submit"  >保存</div>
      </form>
    </div>
    </div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>