var App=new Vue({
		el:"#App",
		data: function() {
			return {
				list: [],
				t_userid: 0,
				isFirst: true,
				per_page: 0,
				unLogin: true
			}
		},
		created: function(ops) {
			 
			this.getPage();
		},
		onShow: function() {
			this.getPage();
		},
		onReachBottom: function() {
			this.getList();
		},
		methods: {
			goPm: function(userid) {
				window.location="/index.php?m=pm&a=detail&userid="+userid

			},
			getPage: function() {
				var that = this;
				$.ajax({
					dataType:"json",
					url: "/index.php?m=pm&ajax=1",
					unLogin: true,
					success: function(res) {
						if (res.error == 1000) {
							return false;
						}
						that.unLogin = false;
						that.list = res.data.msglist;
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
					url: "/index.php?m=pm&ajax=1",
					data: {
						per_page: that.per_page
					},
					success: function(res) {
						that.per_page = res.data.per_page;
						if (that.isFirst) {
							for (var i in res.data.msglist) {
								that.list.push(res.data.msglist[i]);
							}
							that.isFirst = false;
						} else {
							that.list = res.data.msglist;
						}


					}
				})
			}

		}
	})