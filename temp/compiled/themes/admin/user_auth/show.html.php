<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=user_auth">认证审核</a>
		<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=user_auth&a=old">认证会员</a>
	</div>
    
   <div class="main-body"> 
    	<style>
        	.ua .box{width:48%;  float:left;}
			.ua .box.m{margin-right:2%;}
        </style>
    	<div class="ua">
        	<div class="box m">
            	<table class="table-add">
                	<tr>
                    	<td width="100">姓名</td>
                        <td><?php echo $this->_var['data']['truename']; ?></td>
                    </tr>
                    <tr>
                    	<td width="100">身份证</td>
                        <td><?php echo $this->_var['data']['user_card']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="100">电话</td>
                        <td><?php echo $this->_var['data']['telephone']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="100">收入</td>
                        <td><?php echo $this->_var['data']['income']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="100">简介</td>
                        <td><?php echo $this->_var['data']['info']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td>照片</td>
                        <td>
                        	<?php $this->assign("imgs",M("imgs")->get("user_auth_new","".$this->_var["data"]["userid"]."")); ?>
                            <?php $_from = $this->_var['imgs']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
                            <a href="<?php echo images_site($this->_var['c']['imgurl']); ?>" target="_blank"><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.small.jpg" width="120"></a>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td width="100"></td>
                        <td> <div id="row-status">
						<?php if ($this->_var['data']['status'] == 0): ?>
						<a href="javascript:;" class="btn" id="apass" userid="<?php echo $this->_var['data']['userid']; ?>">通过</a>  
                        	<a href="javascript:;" class="btn btn-warning" id="aforbid" userid="<?php echo $this->_var['data']['userid']; ?>">不通过</a> 
                            <?php else: ?>
                            	<?php if ($this->_var['data']['status'] == 1): ?>审核通过<?php else: ?>审核不通过<?php endif; ?>
                            <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
       		<div class="box">
            <?php if ($this->_var['odata']['truename']): ?>
            	<table class="table-add">
                	<tr>
                    	<td width="100">姓名</td>
                        <td><?php echo $this->_var['odata']['truename']; ?></td>
                    </tr>
                    <tr>
                    	<td width="100">身份证</td>
                        <td><?php echo $this->_var['odata']['user_card']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="100">电话</td>
                        <td><?php echo $this->_var['odata']['telephone']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="100">收入</td>
                        <td><?php echo $this->_var['odata']['income']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="100">简介</td>
                        <td><?php echo $this->_var['odata']['info']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td>照片</td>
                        <td>
                        	<?php $this->assign("imgs",M("imgs")->get("user_auth","".$this->_var["odata"]["userid"]."")); ?>
                            <?php $_from = $this->_var['imgs']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
                            <a href="<?php echo images_site($this->_var['c']['imgurl']); ?>" target="_blank"><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.small.jpg" width="120"></a>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </td>
                    </tr>
                    
                     
                </table>
            <?php endif; ?>
            </div>
     	<div></div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
<script>
$(document).on("click","#apass",function(){
	$.get("<?php echo $this->_var['appadmin']; ?>?m=user_auth&a=pass&ajax=1&userid="+$(this).attr("userid"),function(data){
		if(data.error){
			skyToast(data.message);
		}else{
			$("#row-status").html(data.message);
		}
		
	},"json");
});

$(document).on("click","#aforbid",function(){
	$.get("<?php echo $this->_var['appadmin']; ?>?m=user_auth&a=forbid&ajax=1&userid="+$(this).attr("userid"),function(data){
		if(data.error){
			skyToast(data.message);
		}else{
			$("#row-status").html(data.message);
		}
	},"json");
});
</script>
 </body>
</html>