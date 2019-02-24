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
							<div class="mgb-10">当前版本：deituiCMS V1.0 </div>
							<div class="mgb-10">最新版本：deituiCMS V1.0 更新日志 </div>
							<div class="mgb-10">
								deituiCMS包含绝大多数网站所需要的基础功能，采用基础功能+插件模式架构，
								通过插件可以轻松扩展无限的功能。
							</div>
							<div>
								<div class="btn">在线更新</div>
							</div>
						</div>
					</div>
					<div class="row-box">
						<div class="row-box-hd mgb-5">软件服务</div>
						<div>
							<div class="mgb-10">官网：<a href="http://www.deituicms.com" target="_blank">http://www.deituicms.com</a></div>
							<div class="mgb-10">QQ群：48353999</div>
							<div class="mgb-10 btn">购买授权</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/echarts/echarts.common.min.js"></script>
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