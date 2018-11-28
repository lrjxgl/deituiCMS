<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
	<?php echo $this->fetch('weixin/side.html'); ?>
    
     <div class="main-body">
		 <?php echo $this->fetch('weixin_menu/nav.html'); ?>
			 <div class="pd-10">当前微信：<?php echo $this->_var['weixin']['title']; ?></div>
      <table class="tbs">
        <thead>
        <tr>
          <td>id</td>
          <td>名称</td>
          <td>类型</td>
          <td>排序</td>
          <td>操作</td>
        </tr>
        </thead>
        <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
        <tr>
          <td><?php echo $this->_var['c']['id']; ?></td>
          <td><?php echo $this->_var['c']['title']; ?></td>
          <td><?php echo $this->_var['w_type_list'][$this->_var['c']['w_type']]; ?></td>
          <td><?php echo $this->_var['c']['orderindex']; ?></td>
          <td>[<a href="<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=add&id=<?php echo $this->_var['c']['id']; ?>&wid=<?php echo $_GET['wid']; ?>">编辑</a>]
					 [<a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=delete&id=<?php echo $this->_var['c']['id']; ?>&wid=<?php echo $_GET['wid']; ?>">删除</a>]</td>
        </tr>
        <?php if ($this->_var['c']['child']): ?>
        <?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'cc');if (count($_from)):
    foreach ($_from AS $this->_var['cc']):
?>
        <tr>
          <td><?php echo $this->_var['cc']['id']; ?></td>
          <td>|__<?php echo $this->_var['cc']['title']; ?></td>
          <td><?php echo $this->_var['w_type_list'][$this->_var['cc']['w_type']]; ?></td>
          <td><?php echo $this->_var['cc']['orderindex']; ?></td>
          <td>[<a href="<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=add&id=<?php echo $this->_var['cc']['id']; ?>&wid=<?php echo $_GET['wid']; ?>">编辑</a>]
           [<a href="javascript:;" class="js-delete" url="<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=delete&id=<?php echo $this->_var['cc']['id']; ?>&wid=<?php echo $_GET['wid']; ?>">删除</a>]</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?>
        
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </table>
      <div><?php echo $this->_var['pagelist']; ?></div>
    </div>
  
 


<?php echo $this->fetch('footer.html'); ?>
<script>
$(function(){
	$(".CreateMenu").bind("click",function(e){
		e.preventDefault();
		$.get("<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=createmenu&wid=<?php echo $this->_var['weixin']['id']; ?>",function(data){
			if(data.errcode==0){
				alert('生成成功');
			}else{
				alert('生成失败');
			}
		},"json");
	});
	
	$(".DeteleMenu").bind("click",function(e){
		e.preventDefault();
		$.get("<?php echo $this->_var['appadmin']; ?>?m=weixin_menu&a=deletemenu&wid=<?php echo $this->_var['weixin']['id']; ?>",function(data){
			if(data.errcode==0){
				alert('删除成功');
			}else{
				alert('删除失败');
			}
		},"json");
	});
	
	
});
</script>  
</body>
</html>