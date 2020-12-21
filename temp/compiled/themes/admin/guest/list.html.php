<table class='table table-bordered' width='100%'>
  <tr>
   <td>id</td>
  
 
 
   <td>发布时间</td>
 	<td>内容</td>
<td>操作</td>
  </tr>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
 
 
   <td><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
   <td><div style="width:200px; overflow:hidden;"><?php echo strip_tags($this->_var['c']['content']); ?></div></td>
<td><?php if ($this->_var['c']['type_id'] != 6): ?><a href="<?php echo $this->_var['appadmin']; ?>?m=guest&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a><?php endif; ?> <a href="<?php echo $this->_var['appadmin']; ?>?m=guest&a=show&id=<?php echo $this->_var['c']['id']; ?>">查看</a> <a href="javascript:;" class="delete" url="<?php echo $this->_var['appadmin']; ?>?m=guest&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>