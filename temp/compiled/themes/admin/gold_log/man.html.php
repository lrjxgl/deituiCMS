<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>

<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=gold_log">金币记录</a>
	<a class="item " href="<?php echo $this->_var['appadmin']; ?>?m=gold_log&a=man">人工充金币</a>
</div>
<div class="main-body">
            <form  method="post" action="<?php echo $this->_var['appadmin']; ?>?m=gold_log&a=saveman" >
              
                <table  class="table table-bordered">
                  
                  <tr align="center">
                    <td width="100" align="right">充值账户：</td>
                    <td align="left"  >
											<input class="w100" type="text" name="userid" id="userid" placeholder="用户id" value="<?php echo $_GET['userid']; ?>">
											<span id="nickname"></span>
											</td>
                     
                  </tr>
                  
                  <tr align="center">
                    <td width="20%" align="right">充值金额：</td>
                    <td align="left"  ><input type="text" name="money"></td>
                     
                  </tr>
                  
                  <tr>
                  	<td align="right">备注：</td>
                    <td align="left"><input type="text" name="orderinfo" /></td>
                  </tr>
                 
                   </table>
									<div class="btn-row-submit" id="submit">确定充值</div>
            </form>
          </div>
           

<?php echo $this->fetch('footer.html'); ?>
<script>
	$(document).on("keyup","#userid",function(){
		$.get("/admin.php?m=recharge&a=getuser&ajax=1&userid="+$(this).val(),function(data){
			if(data.error){
				skyToast(data.message);
			}else{
				$("#nickname").html(data.data.nickname);
			}
		},"json")
	})
	$(document).on("click","#submit",function(){
			if(confirm("确认充值吗?")){
				var form=$(this).parents("form")
				$.post(form.attr("action")+"&ajax=1",form.serialize(),function(res){
					skyToast(res.message);
					
					if(res.error==0){
						goBack();
					}
				},"json")
			}
	})
</script>
</body>
</html>