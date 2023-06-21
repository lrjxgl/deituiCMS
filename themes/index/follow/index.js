var App = new Vue({
	el: "#App",
	data: function() {
		return {
			list: [],
			tab: "follow"
		}
	},
	created: function() {
		this.tab=tab;
		this.getFollow();
	},
	methods: {
		getFollow: function() {
			var that = this;
			$.ajax({
				url: "/index.php?m=follow&ajax=1",
				dataType: "json",
				success: function(res) {
					that.list = res.data.list;
				}
			})
		},
		getFollowed: function() {
			var that = this;
			$.ajax({
				url: "/index.php?m=follow&a=followed&ajax=1",
				dataType: "json",
				success: function(res) {
					that.list = res.data.list;
				}
			})
		},
		setTab: function(t) {
			this.tab = t;
			if (t == 'follow') {
				this.getFollow();
			} else {
				this.getFollowed();
			}
		},
		followToggle: function(item) {
			var that = this;
			switch (that.tab) {
				case "follow":
					if (confirm("确认取消关注吗？")) {
						$.ajax({
							url: "/index.php?m=follow&a=Toggle&ajax=1",
							dataType: "json",
							data: {
								t_userid: item.userid
							},
							success: function(res) {
								var nlist = Array();
								for (var i in that.list) {
									if (that.list[i].userid != item.userid) {
										nlist.push(that.list[i]);
									}
								}
								that.list = nlist;
							}
						})
					}
					break;
				default:
					$.ajax({
						url: "/index.php?m=follow&a=Toggle&ajax=1",
						dataType: "json",
						data: {
							t_userid: item.userid
						},
						success: function(res) {
							item.isfollow = res.follow;

						}
					});
					break;
			}


		},
		goUser:function(userid){
			window.location="/module.php?m=sblog_home&userid="+userid;
		},
	}
})
