<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
<?php echo $this->fetch('gread_shop_apply/nav.html'); ?>
 <table class="tbs">
<thead>  <tr>
   <td>shopid</td>
   <td>店名</td>
   <td>简介</td>
   <td>图片</td>
   <td>地址</td>
   <td>createtime</td>
   <td>手机</td>
   <td>店主</td>
   <td>status</td>
   <td>配送费</td>
   <td>lat</td>
   <td>lng</td>
<td>操作</td></tr>
  </tr>
</thead> <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['shopid']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php echo $this->_var['c']['imgurl']; ?></td>
   <td><?php echo $this->_var['c']['address']; ?></td>
   <td><?php echo $this->_var['c']['createtime']; ?></td>
   <td><?php echo $this->_var['c']['telephone']; ?></td>
   <td><?php echo $this->_var['c']['nickname']; ?></td>
   <td><?php echo $this->_var['c']['status']; ?></td>
   <td><?php echo $this->_var['c']['sendmoney']; ?></td>
   <td><?php echo $this->_var['c']['lat']; ?></td>
   <td><?php echo $this->_var['c']['lng']; ?></td>
<td><a href="/module.php?m=gread_shop_apply&a=add&shopid=<?php echo $this->_var['c']['shopid']; ?>">编辑</a> <a href="/module.php?m=gread_shop_apply&a=show&shopid=<?php echo $this->_var['c']['shopid']; ?>">查看</a> <a href="javascript:;" class="delete" url="/module.php?m=gread_shop_apply&a=delete&shopid=<?php echo $this->_var['c']['shopid']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>