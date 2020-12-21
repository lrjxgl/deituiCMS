<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=coupon">优惠券列表</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=add">添加优惠券</a>
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=user">优惠券用户</a>
</div>
<div class="main-body">
 <table class='table table-bordered' width='100%'>
  <tr>
   <td>id</td>
   <td>名称</td>
   <td>用户</td>
   
   <td>使用价格</td>
    
   <td>截止日期</td>
   <td>领取时间</td>
   <td>状态</td>
   <td>操作</td>
   </tr>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['userid']; ?>::<?php echo $this->_var['c']['nickname']; ?></td>
    
   <td><?php echo $this->_var['c']['money']; ?></td>
  
   <td><?php echo $this->cutstr($this->_var['c']['etime'],10,''); ?></td>
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td>
   		 <?php if ($this->_var['c']['status'] == 1): ?>
        已使用
           <?php else: ?>
           未使用
          <?php endif; ?>
   </td>
 <td><a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=coupon&a=userdelete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
</div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>