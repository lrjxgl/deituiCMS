<table class="table-add">
	<tr>
  	<td>订单打印机</td>
    <td>
    	<input type="radio" name="has_printer" <?php if (! $this->_var['data']['has_printer']): ?> checked<?php endif; ?> value="0" >关闭
        <input type="radio" name="has_printer" <?php if ($this->_var['data']['has_printer']): ?> checked<?php endif; ?> value="1"> 开启
    </td>
  </tr>
  
  <tr>
  	<td>快递众包</td>
    <td>
    	<div class="pd-5">
    	<input type="radio" name="plugin_kdyuan" <?php if (! $this->_var['data']['plugin_kdyuan']): ?> checked<?php endif; ?> value="0" >关闭
        <input type="radio" name="plugin_kdyuan" <?php if ($this->_var['data']['plugin_kdyuan']): ?> checked<?php endif; ?> value="1"> 开启
        </div>
        
        <div  class="pd-5">
        	推送方式 <input type="radio" name="plugin_kdyuan_type" <?php if (! $this->_var['data']['plugin_kdyuan_type']): ?> checked<?php endif; ?> value="0">校园 
        	<input type="radio" name="plugin_kdyuan_type" <?php if ($this->_var['data']['plugin_kdyuan_type']): ?> checked<?php endif; ?> value="1">地理位置
        </div>
        
        <div  class="pd-5">
        	推送范围 <input type="text" class="w100" name="plugin_kdyuan_mi" value="<?php if (! $this->_var['data']['plugin_kdyuan_mi']): ?>3000<?php else: ?><?php echo $this->_var['data']['plugin_kdyuan_mi']; ?><?php endif; ?>"> 米
        </div>
        
    </td>
  </tr>

</table>