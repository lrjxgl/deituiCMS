<!DOCTYPE html>
<html>
	<?php
		$domain=$_SERVER["HTTP_HOST"];
		$SERVER_SOFTWARE=$_SERVER["SERVER_SOFTWARE"];
	?> 
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
					<li class="now">环境检测</li>
					<li >参数配置</li>
					<li>正在安装</li>
					<li>安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>

<div class="pright">
  <div class"enter_lf">
   <div class="Envin_lf">
      <div class="menter_lf"><span>服务器信息</span></div>
      <div class="menter_table_lf">
      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabletable">
        <thead>
            <tr>
              <th>参数</th>
              <th>值</th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>服务器域名</td>
              <td style=" color:#999;"><?=$domain?></td>
            </tr>
            <tr>
              <td>服务器操作系统</td>
              <td style=" color:#999;"><?=PHP_OS?> (强烈推荐使用Linux系统)</td>
            </tr>
            <tr>
              <td>服务器翻译引擎</td>
              <td style="color:#999;"><?=$SERVER_SOFTWARE?></td>
            </tr>
            <tr>
              <td>PHP版本</td>
              <td style="color:#999;"><?=phpversion()?> (强烈推荐php7.2+)</td>
            </tr>
            <tr>
              <td>系统安装目录</td>
              <td style=" color:#999;"><?=__DIR__?></td>
            </tr>
        </tbody>
      </table>

      </div>
</div>
<div class="Envin_lf">
      <div class="menter_lf"><span>系统环境检测</span></div>
      <div class="menter_table_lf" style="height: 140px;">
      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabletable">
        <thead>
            <tr>
              <th>需呀开启变量的函数</th>
              <th>要求</th>
              <th>实际状态和建议</th>
            </tr>
        </thead>
        <tbody>
            
             
            <tr>
              <td>GD支持</td>
              <td>Off</td>
              <td>
								<?php if(function_exists("imagepng")){?>
										on
										<?php }else{?>
										off
										<?php } ?>
							</td>
            </tr>
             <tr>
              <td>MySQLi</td>
              <td>On</td>
              <td><?php if(function_exists("mysqli_query")){?>
									on
									<?php }else{?>
									off
									<?php } ?></td>
            </tr>
						 
            
        </tbody>
      </table>

      </div>
</div>
<div class="Envin_lf">
      <div class="menter_lf"><span>目录权限检测</span></div>
      <div class="menter_table_lf" style="height: 300px;">
      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabletable">
        <thead>
            <tr>
              <th>目录名</th>
              <th>要求权限</th>
               
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>/</td>
              <td>[/]可读写执行</td>
               
            </tr>
            <tr>
              <td>/config/*</td>
              <td>[/]读写执行</td>
               
            </tr>
            <tr>
              <td>/attach/*</td>
              <td>[/]可读写</td>
              
            </tr>
             
            <tr>
              <td>/temp/*</td>
              <td>[/]可读写</td>
               
            </tr>
              <tr>
              <td>/source/*</td>
              <td>[/]执行</td>
              
            </tr>
              <tr>
              <td>/themes/*</td>
              <td>[/]读</td>
              
            </tr>
						</tr>
						  <tr>
						  <td>/plugin/*</td>
						  <td>[/]读</td>
						  
						</tr>
        </tbody>
      </table>

      </div>
</div>
    <div class="menter_btn_lf"></div>
    <div class="menter_btn_a_lf">
           <a href="index.php?step=3"><input name="" type="button" class="menter_btn_a_a_lf"value="继续"></a>
           <a href="javascript:history.back();"><input name="" type="button" class="menter_btn_a_a_lf" value="后退"></a>
           
    </div>
</div>


</div>
 
</body>
</html>
