var query
new Vue({
	el:"#App",
	data: function() {
		return {
			aaBoxClass: "",
			keyword: "",
			searchList: {},
			city: "厦门",
			cityGroup: {},
			zm: "A",
			zms: {},
			recList: {}
		}
	},
	created: function() {
		var that=this;
		that.city=localStorage.getItem("city");
		
		this.getPage();
		$(window).on("scroll",function(e){
			
			var y = $(window).scrollTop();
			 
			var zms = that.zms;
			for (var el in zms) {
				if (zms[el] > y+40) {
					that.zm = el;
					break;
				}
			}
		}) 

	},
 
	methods: {
		search: function() {
			var that = this;
			setTimeout(function() {
				$.ajax({
					dataType:"json",
					url: "/index.php?m=city&a=search&ajax=1&city=" + that.keyword,
					success: function(res) {
						that.searchList = res.data.list
					}
				})
			}, 30)

		},
		searchShow: function() {
			this.aaBoxClass = "flex-col";
		},
		setCity: function(acity,cityid) {
			localStorage.setItem("city",acity);
			localStorage.setItem("cityid",cityid);
			this.city = acity;
			goBack();
		},
		setZm: function(zm) {
			this.zm = zm;

			var y = this.zms[zm];
			$(window).scrollTop(y-50)
		},
		getZmsy: function() {
			var that = this;
			var zms = this.zms;
		 
			for (var el in zms) {
				zms[el] = document.getElementById("zms" + el).offsetTop;
			}
			this.zms = zms;
		},
		getPage: function() {
			var that = this;
			$.ajax({
				dataType:"json",
				url: "/index.php?m=city&ajax=1",
				success: function(res) {
					that.cityGroup = res.data.list;
					var zms = Array();
					for (var i in that.cityGroup) {
						zms[i] = 0;
					}
					that.zms = zms;
					that.recList = res.data.recList;
					setTimeout(function() {
						that.getZmsy();
					}, 300)
				}
			})
		}
	}
})
