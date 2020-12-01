var catid=0;
var app = new Vue({
	el: '#app',
	data: {
		pageData: {},
		pageLoad:false,
		show:"flex",
		catActive:"cl-money",
	},
	created: function() {
		this.getPage();
	},
	methods: {
		goProduct:function(id){
			window.location="/module.php?m=b2c_product&a=show&id="+id;
		},
		getPage: function() {
			var that = this;
			$.get("/module.php?m=b2c_product&ajax=1", function(res) {
				that.pageData = res.data;
				that.pageLoad=true;
			}, "json")
		},
		getList:function(){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_product&ajax=1",
				data:{
					catid:catid
				},
				dataType:"json",
				success:function(res){
					for(var i in res.data.catList){
						if(res.data.catList[i].catid==catid){
							res.data.catList[i].isactive=1;
						}else{
							res.data.catList[i].isactive=0;
						}
					}
					that.pageData = res.data;
					
				}
			})
		},
		setCat:function(cid){
			var that=this;
			catid=cid;
			if(catid==0){
				that.catActive="cl-money";
			}else{
				that.catActive='';
			}
			this.getList();
		},
		addCart: function(id, ksid) {
			var that = this;
			var id = id;
			var ksid = ksid == undefined ? 0 : ksid;
			var amount = 1;
			$.ajax({
				url: '/module.php?m=b2c_cart&a=add&ajax=1',
				data: {
					productid: id,
					amount: amount,
					ksid: ksid
				},
				method: 'GET',
				dataType: "json",
				success: function(res) {
					var list = that.pageData.list;
					for (var i = 0; i < list.length; i++) {
						if (list[i].id == id) {
							if (res.data.amount > 0) {
								list[i].incart = 1;
							}
							list[i].cart_amount = res.data.amount;
							break;
						}
					}
					that.pageData.list = that.parseList(list);
				}
			})
		},
		plusCart: function(id, amount, ksid) {
			var that = this;
			var id = id;
			var amount = amount;
			var ksid = ksid == undefined ? 0 : ksid;
			amount++;
			$.ajax({
				url: '/module.php?m=b2c_cart&a=add&ajax=1',
				data: {
					productid: id,
					amount: amount,
					ksid: ksid
				},
				method: 'GET',
				dataType: "json",

				success: function(res) {

					var list = that.pageData.list;
					for (var i = 0; i < list.length; i++) {
						if (list[i].id == id) {

							list[i].cart_amount = res.data.amount;
							break;
						}
					}

					that.pageData.list = that.parseList(list);
				}
			})
		},
		minusCart: function(id, amount, ksid) {
			var that = this;
			var id = id;
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
					productid: id,
					amount: amount,
					ksid: ksid,
					isdelete: isdelete
				},
				method: 'GET',
				dataType: "json",

				success: function(res) {

					var list = that.pageData.list;
					for (var i = 0; i < list.length; i++) {
						if (list[i].id == id) {
							if (res.data.amount == 0) {
								list[i].incart = 0;
							}
							list[i].cart_amount = res.data.amount;
							break;
						}
					}

					that.pageData.list = that.parseList(list);
				}
			})
		},
		parseList: function(list) {
			for (var i = 0; i < list.length; i++) {
				if (list[i].cart_num > 0) {
					list[i].cart_num_class = "prolist-item-row-cart-active";
				} else {
					list[i].cart_num_class = "";
				}
			}
			return list;
		}
	}
})
