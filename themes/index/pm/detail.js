var timer = 0;
var inAjax = false;
var windowHeight = 0;
var App = new Vue({
	el: "#App",
	data: function() {
		return {
			list: [],
			t_userid: 0,
			content: "",
			maxid: 0,
			hasNew: 0,
			per_page: 0,
			isFirst: true,
			sch: 0,
			oldsch: 0,
			scrollTop: 10000,
			time: 0
		}
	},
	created: function(ops) {
		var that = this;
	 
		this.t_userid =userid;
		this.getPage();

	},
	onHide: function() {
		clearInterval(timer);
		timer = 0;
	},
	onShow: function() {
		this.setTimer();
	},
	onPageScroll: function(e) {
		if (e.scrollTop == 0 && !inAjax) {
			this.getList();
			inAjax = true;
			setTimeout(function() {
				inAjax = false;
			}, 2000);
		}
	},
	methods: {
		scrollY: function(e) {
			this.sch = e.detail.scrollHeight;
		},
		scTop: function(e) {
			if (this.oldsch == 0) {
				this.oldsch = this.sch;
			}

			var that = this;
			that.scrollTop = 0;
			this.getList();
		},
		setTimer: function() {
			var that = this;
			if (timer > 0) {
				clearInterval(timer);
			}
			timer = setInterval(function() {
				that.getNew()
			}, 10000)
		},
		getNew: function() {
			var that = this;
			$.ajax({
				dataType:"json",
				url: "/index.php?m=pm&a=getnew&ajax=1",
				data: {
					t_userid: that.t_userid
				},
				success: function(res) {
					that.hasNew = res.data;

				}
			})
		},
		getPage: function() {
			var that = this;
			$.ajax({
				dataType:"json",
				url: "/index.php?m=pm&a=detail&ajax=1",
				data: {
					t_userid: that.t_userid
				},
				success: function(res) {
					that.setTimer();
					that.isFirst = false;
					that.hasNew = 0;
					that.list = res.data.pmlist;
					that.per_page = res.data.per_page;
					 
					 
				}
			})
		},
		getList: function() {
			var that = this;
			if (that.per_page == 0 && !that.isFirst) {
				return false;
			}
			$.ajax({
				dataType:"json",
				url: "/index.php?m=pm&a=detail&ajax=1",
				data: {
					t_userid: that.t_userid,
					per_page: that.per_page
				},
				success: function(res) {
					that.setTimer();
					that.hasNew = 0;
					that.per_page = res.data.per_page;
					var list = that.list;
					for (var i in res.data.pmlist) {
						list.unshift(res.data.pmlist[i]);
					}
					that.list = list;
					setTimeout(function() {
						that.scrollTop += 10;
					}, 100)
					 
				}
			})
		},
		sendPm: function() {
			var that = this;
			$.ajax({
				dataType:"json",
				url: "/index.php?m=pm&a=sendSave&ajax=1",
				data: {
					t_userid: that.t_userid,
					content: that.content
				},
				success: function(res) {
					if (res.error) {
						 
						skyToast(res.message)
						return false;
					}
					that.content = '';
					that.getPage();
				}
			})
		}
	}
})
