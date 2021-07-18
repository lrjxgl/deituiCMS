
getPvStat();
getUserStat();
getRechargeStat();
function getPvStat() {
	var myChart = echarts.init(document.getElementById('pv'));
	$.get("/admin.php?m=stat&a=statWeekAll&ajax=1", function(res) {
		var option = {
			title: {
				text: ''
			},
			tooltip: {
				trigger: 'axis'
			},
			legend: {
				data: ['pv', 'ip']
			},
			xAxis: {
				type: 'category',
				data: res.data.labels
			},
			yAxis: {
				type: 'value'
			},
			series: [{
					name: "pv",
					data: res.data.pvMoneys,
					type: 'line',
					smooth: true
				}, {
					name: "ip",
					data: res.data.ipMoneys,
					type: 'line',
					smooth: true,
				}

			]
		};
		myChart.setOption(option);
	}, "json")
}

function getUserStat() {
	var myChart = echarts.init(document.getElementById('userStat'));
	$.get("/admin.php?m=stat&a=WeekUser&ajax=1", function(res) {
		var option = {
			title: {
				text: ''
			},
			tooltip: {
				trigger: 'axis'
			},
			legend: {
				data: ["日增用户"]
			},
			xAxis: {
				type: 'category',
				data: res.data.labels
			},
			yAxis: {
				type: 'value'
			},
			series: [ {
					name: "日增用户",
					data: res.data.list,
					type: 'line',
					smooth: true,
				}

			]
		};
		myChart.setOption(option);
	}, "json")
}

function getRechargeStat() {
	var myChart = echarts.init(document.getElementById('moneyStat'));
	$.get("/admin.php?m=stat&a=WeekRecharge&ajax=1", function(res) {
		var option = {
			title: {
				text: ''
			},
			tooltip: {
				trigger: 'axis'
			},
			legend: {
				data: ["支付金额"]
			},
			xAxis: {
				type: 'category',
				data: res.data.labels
			},
			yAxis: {
				type: 'value'
			},
			series: [ {
					name: "支付金额",
					data: res.data.list,
					type: 'line',
					smooth: true,
				}

			]
		};
		myChart.setOption(option);
	}, "json")
}