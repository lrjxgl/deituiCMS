<!DOCTYPE html>
<html>
	 
	<?php include "head.php";?>
	<body>
		<?php include "header.php";?>

<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="succeed">环境检测</li>
					<li class="now">参数配置</li>
					<li>正在安装</li>
					<li>安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
       
       <!--参数配置-->
<div class="index_mian_right_ly">
 
  <form id="installForm">
  <!--数据库设定-->
  <div class="index_mian_right_two_ly">
   <div class="index_mian_right_two_one_ly"><span>数据库设定</span></div>
   <div class="index_mian_right_two_two_ly">
   
     <div class="index_mian_right_two_two_o_ly"><b>数据库主机：</b><input class="index_mian_right_two_two_text_ly" name="mysql_host" value="localhost" type="text" /><span>一般为localhost</span></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据库用户：</b><input class="index_mian_right_two_two_text_ly" name="mysql_user" type="text" /></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据库密码：</b><input class="index_mian_right_two_two_text_ly" name="mysql_pwd" type="text" /></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据表前缀：</b><input class="index_mian_right_two_two_text_ly" name="tblpre" type="text" value="sky_" /></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据库名称：</b><input class="index_mian_right_two_two_text_ly" name="mysql_db" type="text" /></div>
     
   </div>
  </div>
  <!--数据库设定结束-->
  
  <!--管理员初始密码-->
  <div class="index_mian_right_three_ly">
   <div class="index_mian_right_three_one_ly"><span>管理员初始密码</span></div>
   <div class="index_mian_right_three_two_ly">
   
     <div class="index_mian_right_three_two_o_ly"><b>用户名：</b><input class="index_mian_right_two_two_text_ly" name="adminname" type="text" /></div>
     <div class="index_mian_right_three_two_n_ly"><b>密码：</b><input class="index_mian_right_two_two_text_ly" name="pwd1" type="text" /></div>
      <div class="index_mian_right_three_two_n_ly"><b style="margin-left: 46px;">确认密码：</b><input class="index_mian_right_two_two_text_ly" name="pwd2" type="text" /></div>
   </div>
  </div>
  <!--管理员初始密码结束-->
  </form>
  
  
 
  <!--线-->
  <div class="index_mian_right_six_ly"></div>
  
  <!--后退,继续-->
  <div class="index_mian_right_seven_ly">
     <a href="javascript:;" id="goInstall"><input name="" class="index_mian_right_seven_Forward_ly" type="button" value="继续" /></a>
     <a href="javascript:history.back();"><input name=""  class="index_mian_right_seven_Forward_ly" type="button" value="后退" /></a>
  </div>
  </form>
  <!--后退,继续结束-->
</div>
    
    
    
    </div>

</div>

<div class="foot">

</div>
 
</body>
</html>
