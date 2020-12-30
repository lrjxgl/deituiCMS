var tablename = "mod_forum";
var Vm = new Vue({
	el: "#app",
	data: function() {
		return {
			pageLoad: false,
			pageData: {},
			per_page:0,
			isFirst:true
		}
	},
	created: function() {
		this.getList();
	},
	methods: {
		getList: function() {
			var that = this;
			$.ajax({
				url: "/module.php?m=forum_fav&a=mylist&tablename=" + tablename + "&ajax=1",
				dataType: "json",
				success: function(res) {
					that.pageLoad = true;
					that.pageData = res.data;
					that.per_page = res.data.per_page;
					that.isFirst = false;
				}
			})

		},
		loadMore: function() {
			var that = this;
			if (!that.isFirst && that.per_page == 0) return false;
			$.ajax({
				url: "/module.php?m=forum_fav&a=mylist&tablename=" + tablename + "&ajax=1",
				data: {
					per_page: that.per_page
				},
				dataType: "json",
				success: function(res) {
					var pageData = that.pageData;
					var list = pageData.list;
					for (var i in res.data.list) {
						list.push(res.data.list[i]);
					}
					that.per_page = res.data.per_page;
					that.pageData = pageData;
				}
			})

		},
		del: function(id) {
			var that = this;
			var id = id;
			$.ajax({
				url: "/module.php?m=forum_fav&a=delete&tablename=" + tablename + "&ajax=1&id=" + id,
				dataType: "json",
				success: function(res) {
					var list = that.pageData.list;
					var nlist = [];
					for (var i = 0; i < list.length; i++) {
						if (list[i].id != id) {
							nlist.push(list[i]);
						}
					}
					 
					var pageData = that.pageData;
					pageData.list = nlist;
					that.pageData = pageData;
				}
			})

		}
	}
});
