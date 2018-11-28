<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>

 <?php echo $this->fetch('weixin/side.html'); ?>
<div class="main-body">
<?php echo $this->fetch('weixin_sucai/nav.html'); ?>
<style>
.sucai_menu{list-style-type:none;}
.sucai_menu li{height:30px; line-height:30px; display:block; border-bottom:1px solid #ccc;}
</style>
<form method='post' id="f1" name="f1"  action='admin.php?m=weixin&a=save'>
       
      <table class='  table table-bordered' width='100%'>
        <tr>
          <td width="200" valign="top">
          <div class="f18 pd-5">素材列表</div>
          <ul class="sucai_menu">
          
          <li><a href="admin.php?m=weixin_sucai&a=addiframe&wid=<?php echo $this->_var['weixin']['id']; ?>&id=<?php echo $this->_var['data']['id']; ?>" target="addiframe"><?php echo $this->_var['data']['title']; ?></a> <a href="admin.php?m=weixin_sucai&a=addiframe&wid=<?php echo $this->_var['weixin']['id']; ?>&pid=<?php echo $this->_var['data']['id']; ?>" target="addiframe" style="float:right;color:red">+添加</a></li>
         <?php if ($this->_var['data']['child']): ?>
         <?php $_from = $this->_var['data']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
         <li><a href="admin.php?m=weixin_sucai&a=addiframe&wid=<?php echo $this->_var['c']['wid']; ?>&id=<?php echo $this->_var['c']['id']; ?>" target="addiframe"><?php echo $this->_var['c']['title']; ?></a></li>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         <?php endif; ?>
          
          </ul>
          </td>
          <td><iframe id="addiframe" name="addiframe" src="admin.php?m=weixin_sucai&a=addiframe&wid=<?php echo $this->_var['weixin']['id']; ?>&id=<?php echo $this->_var['data']['id']; ?>" style="border:0px; width:100%; height:500px;"></iframe></td>
          
        </tr>
        </table>
 </form>       
</div>



<?php echo $this->fetch('footer.html'); ?>
</body>
</html>