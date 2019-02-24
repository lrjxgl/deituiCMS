<table class="table-add">
	<tr>
			<td>首页地址：</td>
			<td>
				<input class="w300" type="text" name="rurl301" value="<?php echo $this->_var['data']['rurl301']; ?>" /> <span>默认为空</span>
			</td>
		</tr>
	<tr>
		<td>百度地图：</td>
		<td>浏览器 <input type="text" name="bdmapkey" class="w300" value="<?php echo $this->_var['data']['bdmapkey']; ?>" /> 
		服务端 <input type="text" name="bdmapkey_php" class="w300" value="<?php echo $this->_var['data']['bdmapkey_php']; ?>" /> 
		<a href="http://developer.baidu.com/map/" target="_blank">点击申请</a></td>
	</tr>
	<tr>
		<td>伪静态：</td>
		<td><input name="rewrite_on" type="radio" value="0" <?php if ($this->_var['data'] [ 'rewrite_on' ] != 1): ?> checked="checked" <?php endif; ?> />
			关闭
			<input type="radio" name="rewrite_on" <?php if ($this->_var['data'] [ 'rewrite_on' ] == 1): ?> checked="checked" <?php endif; ?> value="1" />
			开启</td>
	</tr>
	<tr>
		<td>伪静态类型</td>
		<td><select name="rewrite_type">
				<option value="pathinfo" <?php if ($this->_var['data']['rewrite_type'] == 'pathinfo'): ?> selected="selected" <?php endif; ?>>pathinfo </option>
				 <option value="rewrite" <?php if ($this->_var['data']['rewrite_type'] == 'rewrite'): ?> selected="selected" <?php endif; ?>>rewrite </option> </select>
				 </td> </tr>  

</table>
