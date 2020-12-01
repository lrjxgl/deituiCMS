var app = new Vue({
	el: "#app",
	data: function() {
		return {
			pageData: {},
			pageLoad:false,
		}
	},
	created: function() {
		this.getPage();
		$("#app").show();
	},
	methods: {
		getPage: function() {
			var that = this;
			$.ajax({
				url: "/module.php?m=b2c_cart&ajax=1",
				dataType: "json",
				success: function(res) {
					if(res.error){
						skyToast(res.message);
						return false;
					}
					that.pageLoad=true;
					that.pageData = res.data;
				}
			})
		},
		plusCart: function(id, amount, ksid) {
			var that = this;
			var productid = id;
			var amount = amount;
			var ksid = ksid == undefined ? 0 : ksid;
			amount++;
			$.ajax({
				url: '/module.php?m=b2c_cart&a=add&ajax=1',
				data: {
					productid: productid,
					amount: amount,
					ksid: ksid
				},
				method: 'GET',
				dataType: "json",

				success: function(res) {
					that.getPage();
				}
			})
		},
		minusCart: function(id, amount, ksid) {
			var that = this;
			var productid = id;
			var amount = amount;
			var ksid = ksid == undefined ? 0 : ksid;
			amount--;
			var isdelete = 0;
			if (amount == 0) {
				isdelete = 1
			}
			$.ajax({
				url: '/module.php?m=b2c_cart&a=add&ajax=1',
				data: {
					productid: productid,
					amount: amount,
					ksid: ksid,
					isdelete: isdelete
				},
				method: 'GET',
				dataType: "json",

				success: function(res) {
					that.getPage();
				}
			})
		}
		 
	}
});
