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
					<li class="succeed">参数配置</li>
					<li class="now">正在安装</li>
					<li class="succeed">安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
  <!--右边-->
  <form action="" method="get">
  <div class="index_mian_right_one_ly">
   <div class="index_mian_right_one_one_ly"><span>正在安装</span></div>
   <div class="font">请不要关闭当前页面，耐心等待，安装完成会自动跳转...</div>
   <div>
	   <iframe id="progress" src='index.php?m=index&step=44' frameborder="0" style="border:0px; width:100%; height:200px;"></iframe>
	 <script>
		 setInterval(function(){
			 var iwin = document.getElementById('progress').contentWindow; 
			 var doc = iwin.document; 
			 iwin.scroll(0,doc.body.scrollHeight+100); 
		  },600)
		 
	 </script>
   </div>
   
  </div>
  <!--进入系统-->
  
  </form>
</div>
 
</body>
</html>
