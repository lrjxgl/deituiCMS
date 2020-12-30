<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<div class="tabs-border">
		<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=user_auth">认证审核</a>
		<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=user_auth&a=old">认证会员</a>
	</div>
    
   <div class="main-body"> 
    <div class="pd-10">共<?php echo $this->_var['rscount']; ?>条记录</div>
     
    <form method="get" action="<?php echo $this->_var['appadmin']; ?>" class="search-form">
    <input type="hidden" name="m" value="user_auth" />
    userid:<input type="text" name="userid" value="<?php echo intval($_GET['userid']); ?>" class="w60" />
    姓名：<input type="text" name="truename" value="<?php echo html($_GET['truename']); ?>" class="w100" />
    电话：<input type="text" name="telephone" value="<?php echo html($_GET['telephone']); ?>" class="w100" />
    <input type="submit" value="搜索" class="btn btn-success" />
    </form>
     
    <table class="tbs">
    	<thead>
    	<tr>
        <td width="50">ID</td>
 
        <td width="100">姓名</td>
        <td >电话</td>
        <td  >身份证</td> 
        <td >提交时间</td>
        <td width="100">状态</td>
        <td >操作</td>
        </tr>
       </thead> 
       <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
       <tr>
        <td><?php echo $this->_var['c']['userid']; ?></td>
     
        <td><?php echo $this->_var['c']['truename']; ?></td>
        <td><?php echo $this->_var['c']['telephone']; ?></td>
        <td><?php echo $this->_var['c']['user_card']; ?></td>
        <td><?php echo date("Y-m-d",$this->_var['c']['lasttime']); ?></td>
        <td><?php if ($this->_var['c']['status'] == 0): ?>未审核<?php elseif ($this->_var['c']['status'] == 1): ?>已通过<?php else: ?>未通过<?php endif; ?></td> 
        <td> 
        	<a href="<?php echo APPADMIN; ?>?m=user_auth&a=show&userid=<?php echo $this->_var['c']['userid']; ?>">查看</a>  
        </td>
        </tr>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    
    </table>
    <?php echo $this->_var['pagelist']; ?>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
<script>
$(function(){
	$(".setLogin").on("click",function(){
		$.get($(this).attr("url"),function(data){
			skyToast('切换登录成功');
		});
	});
})
</script>
</body>
</html>