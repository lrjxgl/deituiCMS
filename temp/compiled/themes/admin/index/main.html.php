<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<style>
		body{
			background-color: #efefef;
		}
		.w350{
			width: 350px;
		}
	</style>
	<body>
		<div class="main-body ">
			<div class="flex">
				<div class="flex-1 mgr-10">
					<div class="row-box">
						<div class="row-box-hd mgb-5">数据统计</div>
						<div>
							<div id="pv" style="width: 100%;height:400px;"></div>
						</div>
					</div>
				</div>
				<div class="w350">
					<div class="row-box mgb-10">
						<div class="row-box-hd mgb-5">软件信息</div>
						<div>
							<div class="mgb-10">当前版本：<?php echo $this->_var['version']['version']; ?> V<?php echo $this->_var['version']['version_num']; ?> </div>
							<div class="mgb-5 flex">最新版本：<?php echo $this->_var['version']['version']; ?> 
								<div id="newVersion"></div> 
							</div>
							<div id="newVersion-desc" class="mgb-10 cl2"></div>
							<div class="mgb-10">
								<?php echo $this->_var['version']['description']; ?>
							</div>
							<div id="sqRes" class="cl2 mgb-5"></div>
							<div>
								
								<div class="btn" id="update-btn" style="display: none;">在线更新</div>
							</div>
						</div>
					</div>
					<div class="row-box">
						<div class="row-box-hd mgb-5">软件服务</div>
						<div>
							<div class="mgb-10">官网：<a href="http://www.deituicms.com" target="_blank">http://www.deituicms.com</a></div>
							<div class="mgb-10">QQ群：48353999</div>
							<div class="mgb-10">QQ：362606856</div>
							<div class="mgb-10">电话：15985840591</div>
							<div class="mgb-10">购买商业授权可以提供更多服务</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/echarts/echarts.common.min.js"></script>
		<script src="<?php echo $this->_var['skins']; ?>index/version.js"></script>
		<script>
		var myChart = echarts.init(document.getElementById('pv'));
		getPvStat();
		function getPvStat(){
			$.get("/admin.php?m=index&a=statWeekAll&ajax=1",function(res){
				var option = {
				    title: {
				        text: ''
				    },
				    tooltip: {
						trigger: 'axis'
					},
					legend: {
						data:['pv','ip','uv',"新用户"]
					},
				    xAxis: {
						type: 'category',
						data: res.data.labels
					},
					yAxis: {
						type: 'value'
					},
					series: [
						{
							name:"pv",
							data: res.data.pvMoneys,
							type: 'line',
							smooth: true
						},{
							name:"ip",
							data: res.data.ipMoneys,
							type: 'line',
							smooth: true,
						},{
							name:"uv",
							data: res.data.uvMoneys,
							type: 'line',
							smooth: true,
						},{
							name:"新用户",
							data: res.data.userMoneys,
							type: 'line',
							smooth: true,
						}			
						
					]
				};
				 myChart.setOption(option);
			},"json")
		}
        // 指定图表的配置项和数据
        

        // 使用刚指定的配置项和数据显示图表。
       
		</script>
	</body>
</html>