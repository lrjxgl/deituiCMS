<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item active" href="admin.php?m=user">用户管理</a>
	<a class="item" href="admin.php?m=user&a=add">用户添加</a>
</div>
<div class="main-body">
	 
   
    <div class="pd-5 cl2"> 共<?php echo $this->_var['rscount']; ?>条记录</div>
    
    <form method="get" action="<?php echo $this->_var['appadmin']; ?>" class="search-form">
    <input type="hidden" name="m" value="user" />
    userid:<input type="text" name="userid" value="<?php echo intval($_GET['userid']); ?>" class="w60" />
    昵称：<input type="text" name="nickname" value="<?php echo $_GET['nickname']; ?>" class="w100"  />
    电话：<input type="text" name="telephone" value="<?php echo $_GET['telephone']; ?>" class="w100" />
    排序：<select name="orderby" class="w100">
    	<option value="userid DESC">注册</option>
    	<option value="money DESC">余额</option>
        <option value="gold DESC">金币</option>
        <option value="grade DESC">积分</option>
    </select>
    <input type="submit" value="搜索" class="btn btn-success" />
    </form>
    
    <table class="tbs">
    	<thead>
    	<tr>
        <td width="50">ID</td>
        
        <td width="60">昵称</td>
        <td width="70">电话</td>
        <td width="50">账户余额</td>
        <td width="50">金币</td>
        <td width="50">积分</td>
        <td width="30">状态</td>
        <td width="100">注册时间</td>
         
        <td width="100 ">操作</td>
        </tr>
       </thead> 
       <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
       <tr>
        <td><?php echo $this->_var['c']['userid']; ?></td>
         
        <td><?php echo $this->_var['c']['nickname']; ?></td>
        <td><?php echo $this->_var['c']['telephone']; ?></td>
        <td><?php echo $this->_var['c']['money']; ?></td>
        <td width="8%"><?php echo $this->_var['c']['gold']; ?></td>
        <td width="8%"><?php echo $this->_var['c']['grade']; ?></td>
        <td><?php if ($this->_var['c']['status'] == 1): ?>已通过<?php elseif ($this->_var['c']['status'] == 10): ?>未审核<?php else: ?>已禁止<?php endif; ?></td>
        <td><?php echo $this->cutstr($this->_var['c']['createtime'],11,''); ?></td>
         
        <td> 
				<a href="/admin.php?m=user&a=password&userid=<?php echo $this->_var['c']['userid']; ?>">修改密码</a>  
				<a href="/admin.php?m=user&a=add&userid=<?php echo $this->_var['c']['userid']; ?>">编辑</a>  
        <a href="javascript:;" class="setLogin" url="/admin.php?m=user&a=login&userid=<?php echo $this->_var['c']['userid']; ?>&ajax=1" >切换登陆</a>
        <br>
        <a href="/admin.php?m=recharge&a=man&userid=<?php echo $this->_var['c']['userid']; ?>" >充值</a>
        <a href="/admin.php?m=gold_log&a=man&userid=<?php echo $this->_var['c']['userid']; ?>">充金币</a>
         
        </td>
        </tr>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    
    </table>
    <?php echo $this->_var['pagelist']; ?>
    </div>
 <?php echo $this->fetch('footer.html'); ?>
<script>
$(function(){
	$(".setLogin").on("click",function(){
		$.get($(this).attr("url"),function(data){
			skyToast('切换登录成功');
		});
	});
	
	$(".js-regmoney").on("click",function(){
		$.get("<?php echo $this->_var['appadmin']; ?>?m=regmoney&a=set&ajax=1&userid="+$(this).attr("userid"),function(data){
			skyToast(data.message);
		},"json");
	})
})
</script>
</body>
</html>
