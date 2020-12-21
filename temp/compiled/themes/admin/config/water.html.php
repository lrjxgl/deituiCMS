 
<table class="table-add">

            <tr>
    <td height="30" align="right">开启水印：</td>
    <td height="30"><input name="water_on" type="radio"  value="1" <?php if ($this->_var['data']['water_on'] == 1): ?> checked="checked" <?php endif; ?> />开启 
        <input type="radio" name="water_on"  value="0" <?php if ($this->_var['data']['water_on'] == 0): ?> checked="checked" <?php endif; ?> />关闭</td>
  </tr>
  <tr>
    <td width="156" height="30" align="right">水印类型：</td>
    <td width="581" height="30"><input name="water_type" type="radio"  value="0" <?php if ($this->_var['data']['water_type'] == 0): ?> checked="checked" <?php endif; ?>/>图片水印 
        <input type="radio" name="water_type"  value="1"  <?php if ($this->_var['data']['water_type'] == 1): ?> checked="checked" <?php endif; ?> />文字水印</td>
  </tr>
  <tr>
    <td height="30" align="right">水印位置：</td>
    <td height="30">
    <select name="water_pos" id="water_pos">
    <option value="9" <?php if ($this->_var['data']['water_pos'] == 9): ?> selected="selected"<?php endif; ?>>右下</option>
    <option value="0" <?php if ($this->_var['data']['water_pos'] == 0): ?> selected="selected"<?php endif; ?>>随机</option>
    <option value="1" <?php if ($this->_var['data']['water_pos'] == 1): ?> selected="selected"<?php endif; ?>>左上</option>
    <option value="2" <?php if ($this->_var['data']['water_pos'] == 2): ?> selected="selected"<?php endif; ?>>中上</option>
    <option value="3" <?php if ($this->_var['data']['water_pos'] == 3): ?> selected="selected"<?php endif; ?>>右上</option>
    <option value="4" <?php if ($this->_var['data']['water_pos'] == 4): ?> selected="selected"<?php endif; ?>>左中</option>
    <option value="5" <?php if ($this->_var['data']['water_pos'] == 5): ?> selected="selected"<?php endif; ?>>中中</option>
    <option value="6" <?php if ($this->_var['data']['water_pos'] == 6): ?> selected="selected"<?php endif; ?>>右中</option>
    <option value="7" <?php if ($this->_var['data']['water_pos'] == 7): ?> selected="selected"<?php endif; ?>>左下</option>
    <option value="8" <?php if ($this->_var['data']['water_pos'] == 8): ?> selected="selected"<?php endif; ?>>中下</option>
    </select></td>
  </tr>
  <tr>
    <td height="30" align="right">文字大小：</td>
    <td height="30"><input class="w100" name="water_size" type="text" id="water_size" size="8" value="<?php echo $this->_var['data']['water_size']; ?>" />
      px</td>
  </tr>
  <tr>
    <td height="30" align="right">水印文字：</td>
    <td height="30"><input name="water_str" type="text" id="water_str" size="40" value="<?php echo $this->_var['data']['water_str']; ?>" /></td>
  </tr>
  <tr>
    <td height="30" align="right">水印图片：</td>
    <td height="30">
			<div class="js-upload-item">
				<input type="file" id="upa" class="js-upload-file" style="display: none;" />
				<div class="upimg-btn js-upload-btn">+</div>
				<input type="hidden" name="water_img" class="js-imgurl" value="<?php echo $this->_var['data']['water_img']; ?>" />
				<div class="js-imgbox">
					<?php if ($this->_var['data']['water_img']): ?>
					<img src="<?php echo images_site($this->_var['data']['water_img']); ?>.100x100.jpg">
					<?php endif; ?>
				</div>
			</div>
		</td>
  </tr>
</table>