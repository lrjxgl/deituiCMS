var App=new Vue({
	el:"#app",
	data:{
		pageLoad:false,
		pageData:{}
	},
	created:function(){
		this.getPage();
	},
	methods:{
		getPage:function(){
			var that=this;
			$.ajax({
				url:"/admin.php?m=table_fields&ajax=1&tableid="+tableid,
				dataType:"json",
				success:function(res){
					that.pageData=res.data;
					that.pageLoad=true;
				}
			})
		},
		save:function(el){
			var that=this;
			var form=$(el);
			$.ajax({
				url:"/admin.php?m=table_fields&a=save&ajax=1",
				data:$(el).serialize(),
				method:"POST",
				dataType:"json",
				success:function(res){
					$(el).find("input[type='text']").val("");
					skyToast(res.message);
					that.getPage();
				}
			})
		},
		del:function(id){
			var that=this;
			var form=$("#addForm"+id);
			if(confirm("确认要删除字段吗？")){				
				$.ajax({
					url:"/admin.php?m=table_fields&a=delete&ajax=1&id="+id,
					 
					method:"POST",
					dataType:"json",
					success:function(res){
						form.remove();
						skyToast(res.message);
						that.getPage();
					}
				})
			}
		}
	}
})