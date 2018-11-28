<table class="table-add">
   <tr>
    <td height="30" align="right">开启短信通知：</td>
    <td height="30"><input type="radio" name="phone_on"  value="1" <?php if ($this->_var['data']['phone_on'] == 1): ?> checked="checked"<?php endif; ?> />开启 
        <input name="phone_on" type="radio"  value="0"<?php if ($this->_var['data']['phone_on'] != 1): ?> checked="checked"<?php endif; ?> />不开启</td>
  </tr>
  
   <tr>
    <td height="30" align="right">开启短信注册：</td>
    <td height="30"><input type="radio" name="phone_reg"  value="1" <?php if ($this->_var['data']['phone_reg'] == 1): ?> checked="checked"<?php endif; ?> />开启 
        <input name="phone_reg" type="radio"  value="0"<?php if ($this->_var['data']['phone_reg'] != 1): ?> checked="checked"<?php endif; ?> />不开启</td>
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
