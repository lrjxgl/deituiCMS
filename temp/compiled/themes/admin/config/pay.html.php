<table class="table-add">
  
  
  <tr>
    <td>货到付款</td>
    <td>
      <input type="radio" name="order_unpay" value="1" <?php if ($this->_var['data']['order_unpay'] == 1): ?> checked="checked"<?php endif; ?> /> 支持
	  <input type="radio" name="order_unpay" value="0" <?php if ($this->_var['data']['order_unpay'] == 0): ?> checked="checked"<?php endif; ?> /> 禁止</td>
  </tr>
  
   <tr>
    <td>余额支付</td>
    <td>
      <input type="radio" name="moneypay" value="1" <?php if ($this->_var['data']['moneypay'] == 1): ?> checked="checked"<?php endif; ?> /> 支持
	  <input type="radio" name="moneypay" value="0" <?php if ($this->_var['data']['moneypay'] == 0): ?> checked="checked"<?php endif; ?> /> 禁止</td>
  </tr>
 
  
  <tr>
    <td height="30" align="right">支付宝：</td>
    <td height="30"><input type="radio" name="alipay"  value="1" <?php if ($this->_var['data']['alipay'] == 1): ?> checked="checked"<?php endif; ?> />
      开启
      <input name="alipay" type="radio"  value="0"  <?php if ($this->_var['data']['alipay'] == 0): ?> checked="checked"<?php endif; ?> />
      关闭  
      (打开请在api/alipay/alipay.config.php配置相关参数) </td>
  </tr>
  <tr>
    <td width="158" height="30" align="right">微信支付：</td>
    <td width="938" height="30"><input type="radio" name="wxpay"  value="1" <?php if ($this->_var['data']['wxpay'] == 1): ?> checked="checked"<?php endif; ?> />
      开启
      <input name="wxpay" type="radio"  value="0"   <?php if ($this->_var['data']['wxpay'] == 0): ?> checked="checked"<?php endif; ?> />
      关闭 (打开请在api/wxpay/WxPayPubHelperWxPay.pub.config.php配置相关参数) </td>
  </tr>
   
</table>
