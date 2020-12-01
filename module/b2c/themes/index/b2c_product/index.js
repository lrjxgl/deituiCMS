var catid=0;
var app = new Vue({
	el: '#app',
	data: {
		pageData: {},
		pageLoad:false,
		show:"flex",
		catActive:"cl-money",
		ksShow:false,
		ksproduct:[],
		ksList:[],
		ksList2:[],
		ksid:0,
		ksid1:0,
		ksid2:0
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
					if(res.error==1000){
						window.location="/index.php?m=login"
						return false;
					}
					if(res.error){
						skyToast(res.message);
						return false;
					}
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
					if(res.error){
						skyToast(res.message);
						return false;
					}
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
					if(res.error){
						skyToast(res.message);
						return false;
					}
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
		},
		//规格操作
		ksBox:function(id){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_product_ks&ajax=1&productid="+id,
				dataType:"json",
				success:function(res){
					that.ksShow=true;
					that.ksproduct=res.data.product;
					that.ksList=res.data.ksList;
					that.ksList2=res.data.ksList2;
					that.ksid1=res.data.ksid;
					that.ksid=res.data.ksid;
				}
			})
		},
		ksHide:function(){
			this.ksid=0;
			this.ksShow=false;
		},
		ks1:function(id){
			var that=this;
			$.ajax({
				url:"/module.php?m=b2c_product_ks&a=sizeList&ajax=1&id="+id,
				dataType:"json",
				success:function(res){
					that.ksid1=res.data.ksid;
					that.ksid=res.data.ksid;
					that.ksproduct=res.data.product;
					that.ksList2=res.data.ksList2;
				}
			})
		},
		ks2:function(id){
			var that=this;
			that.ksid=id;
			 $.ajax({
			 	url:"/module.php?m=b2c_product_ks&a=get&ajax=1&id="+id,
			 	dataType:"json",
			 	success:function(res){
			 		 
			 		that.ksproduct=res.data.product;
			 		 
			 	}
			 })
		},
		ksAddCart: function(id) {
			var that = this;
			var id = id;
			var ksid=that.ksid;
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
					if(res.error==1000){
						window.location="/index.php?m=login"
						return false;
					}
					if(res.error){
						skyToast(res.message);
						return false;
					}
					that.ksproduct.incart=1;
					that.ksproduct.cart_amount=res.data.amount; 
				}
			})
		},
		ksPlusCart: function(id, amount) {
			var that = this;
			var id = id;
			var amount = amount;
			var ksid=that.ksid;
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
					if(res.error){
						skyToast(res.message);
						return false;
					}
					that.ksproduct.cart_amount=res.data.amount; 
				}
			})
		},
		ksMinusCart: function(id, amount) {
			var that = this;
			var id = id;
			var amount = amount;
			var ksid=that.ksid;
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
					if(res.error){
						skyToast(res.message);
						return false;
					}
					if(res.data.amount==0){
						that.ksproduct.cart_amount=0;
						that.ksproduct.incart=0;
					}else{
						that.ksproduct.cart_amount=res.data.amount;
					}
					
				}
			})
		},
	}
})
