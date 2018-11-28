<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>deituiCMS系统安装</title>
<style type="text/css">
*{margin:0; padding:0;}
.body{width:800px; margin:0 auto; margin-top:100px;}
.head{height:50px; width:800px; line-height:50px; background-color:#E44242; color:#fff; text-align:center; font-size:24px; font-weight:900;}
.title{height:30px; line-height:30px; font-size:20px; padding:3px 6px; background-color:#D38D34; color:#fff;}
.box{width:100%;}
.box-content{background-color:#fff;   width:100%; min-height:60px; line-height:60px; text-align:center;}
table{background-color:#fff; border-collapse:collapse;}
td{border-bottom:1px solid #ccc; padding:3px 4px;}
.btn{padding:4px 8px; background-color: #C9390B;color: #FFF;font-size: 22px;}
</style>
<script language="javascript" src="jquery.js"></script>
</head>

<body style="background:url(skins/bg.jpg);">
<div class="body" >
<div class="head">deituiCMS系统</div>
<?php if ($this->_var['step'] == 1): ?>
<div class="title">正在执行第一步：数据库配置</div>
<div  class="box">
<?php if ($this->_var['dirs']): ?>
<div class="box-content">请确保以下文件夹有写入权限 <a href="javascript:;" onclick="window.location.reload()">刷新</a></div>
<div>
<?php $_from = $this->_var['dirs']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<p><?php echo $this->_var['c']; ?></p>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php else: ?>
<form action="index.php?m=index&step=2" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="21%" height="25" align="right">服务器：</td>
    <td width="79%"><input name="mysql_host" type="text" id="mysql_host" value="localhost" />
    （mysql服务器）</td>
  </tr>
  <tr>
    <td height="25" align="right">用户名：</td>
    <td><input type="text" name="mysql_user" id="mysql_user" /></td>
  </tr>
  <tr>
    <td height="25" align="right">密码：</td>
    <td><input type="password" name="mysql_pwd" id="mysql_pwd" /></td>
  </tr>
  <tr>
    <td height="25" align="right">数据库：</td>
    <td><input type="text" name="mysql_db" id="mysql_db" /></td>
  </tr>
  <tr>
    <td height="25" align="right">表前缀：</td>
    <td><input name="tblpre" type="text" id="tblpre" value="sky_" /></td>
  </tr>
  
  
  <tr>
    <td height="25" align="right">&nbsp;</td>
    <td><button type="submit" name="button" id="button"  class="btn" value="下一步">下一步</button></td>
  </tr>
  </table>


</form>
<?php endif; ?>
</div>
<?php elseif ($this->_var['step'] == 2): ?>
<div class="title">正在执行第二步：安装配置文件</div>
<div class="box-content">
说明：安装数据库配置文件，数据库配置文件主要用于连接数据库，设置数据库。
</div>
<div class="title">正在执行第三步：安装数据库</div>
<div class="box-content"><iframe src='index.php?m=index&step=3' frameborder="0" style="border:0px; width:100%; height:200px;"></iframe></div>
<?php elseif ($this->_var['step'] == 3): ?>

<?php elseif ($this->_var['step'] == 4): ?>
<div class="title">正在执行第四步：创始人配置</div>
<div class="box">
<form action="index.php?m=index&step=5" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="22%" height="30" align="right">管理员：</td>
    <td width="78%"><input type="text" name="adminname" id="adminname" /></td>
  </tr>
  <tr>
    <td height="30" align="right">密码：</td>
    <td><input type="password" name="pwd1" id="pwd1" /></td>
  </tr>
  <tr>
    <td height="30" align="right">重复密码：</td>
    <td><input type="password" name="pwd2" id="pwd2" /></td>
  </tr>
  <tr>
    <td height="30" align="right">&nbsp;</td>
    <td><input type="submit" name="button2" class="btn" id="button2" value="确认" /></td>
  </tr>
  </table>

</form>

</div>
<?php elseif ($this->_var['step'] == 5): ?>
<div class="title">站点安装完毕</div>
<div class="box-content">
<a href="../index.php">查看首页</a> 

<a href="../admin.php?m=login">进入管理</a> </div>

<?php endif; ?>
</div>

</body>
</html>
