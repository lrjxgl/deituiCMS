<table class="table-add">
	<tr>
		<td>邀请码注册</td>
		<td>
			<input <?php if ($this->_var['data']['reg_invitecode'] == 1): ?>checked<?php endif; ?> type="radio" name="reg_invitecode" value="1" />启用
			<input <?php if ($this->_var['data']['reg_invitecode'] != 1): ?>checked<?php endif; ?>  type="radio" name="reg_invitecode" value="0" />不用
		</td>
	</tr>
<tr>
    <td width="171" height="30" align="right">邀请推广：</td>
    <td width="925" height="30">
    <input name="spread_on" type="radio" id="radio" value="0" <?php if ($this->_var['data']['spread_on'] != 1): ?> checked="checked" <?php endif; ?> />
      关闭
      <input type="radio" name="spread_on" id="radio2" <?php if ($this->_var['data']['spread_on'] == 1): ?> checked="checked" <?php endif; ?> value="1" />
      开启 （当注册用户邀请其他用户来消费可以获得一定优惠）</td>
  </tr>
  <tr>
    <td height="30" align="right">邀请奖励：</td>
    <td height="30"> 
      <input class="w100" name="spread_discount" type="text" id="spread_discount" value="<?php echo $this->_var['data']['spread_discount']; ?>" size="6" />
      %（当邀请的用户消费时，邀请者可以获得相应比例的奖金）</td>
  </tr>
  <tr>
    <td height="30" align="right">积分优惠：</td>
    <td height="30"><input type="radio" name="grade_on" id="radio3" <?php if ($this->_var['data']['grade_on'] == 0): ?> checked="checked" <?php endif; ?> value="0" />
      关闭 
        <input type="radio" name="grade_on" id="radio4" value="1" <?php if ($this->_var['data']['grade_on'] == 1): ?> checked="checked"<?php endif; ?> />
        
 开启 (开启时，将根据用户的积分给予一定的优惠。) </td>
  </tr></table>