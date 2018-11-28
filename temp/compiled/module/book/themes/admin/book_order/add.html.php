<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<a class="item" href="/moduleadmin.php?m=book_order">订单列表</a>
			<a class="item active" href="/moduleadmin.php?m=book_order&a=add">添加订单</a>
		</div>
		<div class="mui-content">
		    <form action="/moduleadmin.php?m=book_order&a=save&ajax=1">
		    	<table class="table table-add">
		    		<tr>
		    			<td>书籍</td>
		    			<td>
		    				<input type="text" style="width: 160px;" id="title"  /> 
		    				ID <input type="text" style="width: 100px;" readonly="" id="bookid" name="bookid"  />
		    				
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>用户</td>
		    			<td>
		    				<input type="text" style="width: 160px;" id="nickname" />
		    				ID <input type="text" style="width: 100px;" readonly="" id="userid" name="userid"  />
		    			</td>
		    		</tr>
		    	</table>
		    	<div class="btn-row-submit js-submit">添加订单</div>
		    </form>
		</div>
	<?php echo $this->fetch('footer.html'); ?>	
<script>
	$(document).on("keyup","#title",function(){
		$.get("/moduleadmin.php?m=book_order&a=searchTitle&ajax=1",{
			title:$("#title").val()
		},function(data){
			if(!data.error){
				$("#bookid").val(data.data);
			}
		},"json")
	})
	
	$(document).on("keyup","#nickname",function(){
		$.get("/moduleadmin.php?m=book_order&a=searchUser&ajax=1",{
			nickname:$("#nickname").val()
		},function(data){
			if(!data.error){
				$("#userid").val(data.data);
			}
		},"json")
	})
</script>		
	</body>
</html>
