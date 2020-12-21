<table class="table-add">
   <tr>
    <td height="30" align="right">开启短信通知：</td>
    <td height="30"><input type="radio" name="phone_on"  value="1" <?php if ($this->_var['data']['phone_on'] == 1): ?> checked="checked"<?php endif; ?> />开启 
        <input name="phone_on" type="radio"  value="0"<?php if ($this->_var['data']['phone_on'] != 1): ?> checked="checked"<?php endif; ?> />不开启</td>
  </tr>
  
    
	<tr >
  	<td height="30" align="right">短信方</td>
    <td>
    	<input type="radio" name="sms_type" <?php if ($this->_var['data']['sms_type'] != 'alisms'): ?>checked<?php endif; ?>  value="default"> 短信宝
    	<input type="radio" name="sms_type" <?php if ($this->_var['data']['sms_type'] == 'alisms'): ?>checked<?php endif; ?> value="alisms"> 阿里云
        
    </td>
  </tr>
  <tr >
    <td height="30" align="right">短信签名：</td>
    <td height="30"><input  class="w100" name="sms_qianming" type="text" value="<?php echo $this->_var['data']['sms_qianming']; ?>"> （使用公司名称简写）</td>
  </tr>
  <tr>
    <td width="156" height="30" align="right">手机服务用户：</td>
    <td width="581" height="30"><input name="phone_user" class="w100" type="text" id="phone_user" value="<?php echo $this->_var['data']['phone_user']; ?>" /> 短信接口申请：<a href="http://www.smsbao.com/reg?r=10190" target="_blank">http://www.smsbao.com/</a></td>
  </tr>
  <tr>
    <td height="30" align="right">手机服务密码：</td>
    <td height="30"><input name="phone_pwd" type="text" id="phone_pwd" value="<?php echo $this->_var['data']['phone_pwd']; ?>" /></td>
  </tr>
  <tr>
    <td height="30" align="right">接收手机号码：</td>
    <td height="30"><input class="w100" name="phone_num" type="text" id="phone_num" value="<?php echo $this->_var['data']['phone_num']; ?>" /> 
    <button  type="button" id="testphone" class="btn">测试</button></td>
  </tr>
 
</table>
