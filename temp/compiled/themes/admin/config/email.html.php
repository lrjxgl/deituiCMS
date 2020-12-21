<table class="table-add">
<tr>
          <td>邮箱服务器：</td>
          <td><input type='text' name='smtphost' id='smtphost' value='<?php echo $this->_var['data']['smtphost']; ?>' ></td>
        </tr>
        <tr>
          <td>邮箱端口：</td>
          <td><input type='text' name='smtpport' id='smtpport' value='<?php echo $this->_var['data']['smtpport']; ?>' ></td>
        </tr>
        <tr>
          <td>邮箱：</td>
          <td><input type='text' name='smtpemail' id='smtpemail' value='<?php echo $this->_var['data']['smtpemail']; ?>' ></td>
        </tr>
        <tr>
          <td>邮箱用户：</td>
          <td><input type='text' name='smtpuser' id='smtpuser' value='<?php echo $this->_var['data']['smtpuser']; ?>' ></td>
        </tr>
        <tr>
          <td>邮箱密码：</td>
          <td><input type="password" name='smtppwd' id='smtppwd' value='<?php echo $this->_var['data']['smtppwd']; ?>' ></td>
        </tr>
        <tr><td></td><td><span class="btn" id="testemail">测试邮件</span><div class="testemail_res"></div></td></tr>

</table>