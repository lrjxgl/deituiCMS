<?php echo $this->fetch('header.html'); ?>
<?php echo $this->fetch('category/category_nav.html'); ?>
<div class="rbox"> 
<div class="tabs-border tabs-border-inner"> 
<?php $_from = $this->_var['modellist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
<a class="item  <?php if ($_GET['model_id'] == $this->_var['k']): ?>active<?php endif; ?>" href="<?php echo $this->_var['appadmin']; ?>?m=category&model_id=<?php echo $this->_var['k']; ?>"><?php echo $this->_var['c']; ?></a>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<span class="item"><a href="<?php echo $this->_var['appadmin']; ?>?m=category&pid=<?php echo $this->_var['nextpid']; ?>&model_id=<?php echo $this->_var['model_id']; ?>">&lt;&lt; <?php echo $this->_var['lang']['go_last']; ?></a></span>

</div>

 
<table  class="tbs">
	<thead>
<tr>
<td width="82" align="center"><?php echo $this->_var['lang']['category']; ?>ID</td>
<td  ><?php echo $this->_var['lang']['name']; ?></td>
<td width="97" align="center"><?php echo $this->_var['lang']['category_level']; ?></td>
 
<td width="100" align="center"><?php echo $this->_var['lang']['model']; ?></td>
<td width="49" align="center"><?php echo $this->_var['lang']['sort']; ?></td>
<td width="71" align="center"><?php echo $this->_var['lang']['show']; ?></td>
<td width="323" align="center"><?php echo $this->_var['lang']['operation']; ?></td>
</tr>
</thead>
<?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
  <td align="center"><?php echo $this->_var['c']['catid']; ?></td>
  <td align="left"><a href="<?php echo $this->_var['appadmin']; ?>?m=category&pid=<?php echo $this->_var['c']['catid']; ?>&model_id=<?php echo $this->_var['c']['model_id']; ?>"><?php echo $this->_var['c']['cname']; ?></a>  </td>
  <td align="center"><?php echo $this->_var['c']['level']; ?></td>
  
  <td align="center"><?php echo $this->_var['modellist'][$this->_var['c']['model_id']]; ?></td>
  <td align="center"><input type="text" class="w50 blur_update" value="<?php echo $this->_var['c']['orderindex']; ?>" size="6"   url="<?php echo $this->_var['appadmin']; ?>?m=category&a=orderindex&catid=<?php echo $this->_var['c']['catid']; ?>&model_id=<?php echo $this->_var['c']['model_id']; ?>" /></td>
  <td align="center"><?php if ($this->_var['c']['status'] == 1): ?><img class="ajax_no" src="static/images/yes.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=2" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=1" /><?php else: ?><img class="ajax_yes" src="static/images/no.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=1" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['c']['catid']; ?>&status=2" /><?php endif; ?></td>
  <td align="center"> 
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&pid=<?php echo $this->_var['c']['catid']; ?>&model_id=<?php echo $this->_var['c']['model_id']; ?>" style="color:red;"><?php echo $this->_var['lang']['add_child']; ?></a>
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=addmore&catid=<?php echo $this->_var['c']['catid']; ?>&model_id=<?php echo $this->_var['c']['model_id']; ?>" style="color:red;"><?php echo $this->_var['lang']['add_more_child']; ?></a>  
  <br>
  <a href="index.php?m=list&catid=<?php echo $this->_var['c']['catid']; ?>" target="_blank"><?php echo $this->_var['lang']['look']; ?></a>
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&catid=<?php echo $this->_var['c']['catid']; ?>&model_id=<?php echo $this->_var['c']['model_id']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> 
  <a href="javascript:;" class="del" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=delete&catid=<?php echo $this->_var['c']['catid']; ?>"><?php echo $this->_var['lang']['delete']; ?></a></td>
</tr>
<?php if ($this->_var['c']['child']): ?>
<?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'cc');if (count($_from)):
    foreach ($_from AS $this->_var['cc']):
?>
<tr>
  <td align="center"><?php echo $this->_var['cc']['catid']; ?></td>
  <td align="left">|__<a href="<?php echo $this->_var['appadmin']; ?>?m=category&pid=<?php echo $this->_var['cc']['catid']; ?>&model_id=<?php echo $this->_var['cc']['model_id']; ?>"><?php echo $this->_var['cc']['cname']; ?></a></td>
  <td align="center"><?php echo $this->_var['cc']['level']; ?></td>
 
  <td align="center"><?php echo $this->_var['modellist'][$this->_var['cc']['model_id']]; ?></td>
  <td align="center"><input type="text" class="w50 blur_update" value="<?php echo $this->_var['cc']['orderindex']; ?>" size="6"   url="<?php echo $this->_var['appadmin']; ?>?m=category&a=orderindex&catid=<?php echo $this->_var['cc']['catid']; ?>&model_id=<?php echo $this->_var['cc']['model_id']; ?>" /></td>
  <td align="center"><?php if ($this->_var['cc']['status'] == 1): ?><img class="ajax_no" src="static/images/yes.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=2" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=1" /><?php else: ?><img class="ajax_yes" src="static/images/no.gif" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=1" rurl="<?php echo $this->_var['appadmin']; ?>?m=category&a=changestatus&catid=<?php echo $this->_var['cc']['catid']; ?>&status=2" /><?php endif; ?></td>
  <td align="center">
   <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&pid=<?php echo $this->_var['cc']['catid']; ?>&model_id=<?php echo $this->_var['cc']['model_id']; ?>" style="color:red;"><?php echo $this->_var['lang']['add_child']; ?></a>
   <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=addmore&catid=<?php echo $this->_var['cc']['catid']; ?>&model_id=<?php echo $this->_var['cc']['model_id']; ?>" style="color:red;"><?php echo $this->_var['lang']['add_more_child']; ?></a>  
  <a href="index.php?m=list&catid=<?php echo $this->_var['cc']['catid']; ?>" target="_blank"><?php echo $this->_var['lang']['look']; ?></a> 
  <a href="<?php echo $this->_var['appadmin']; ?>?m=category&a=add&catid=<?php echo $this->_var['cc']['catid']; ?>&model_id=<?php echo $this->_var['cc']['model_id']; ?>"><?php echo $this->_var['lang']['edit']; ?></a>
  <a href="javascript:;" class="del" url="<?php echo $this->_var['appadmin']; ?>?m=category&a=delete&catid=<?php echo $this->_var['cc']['catid']; ?>&model_id=<?php echo $this->_var['cc']['model_id']; ?>"><?php echo $this->_var['lang']['delete']; ?></a>
  </td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 

<?php endif; ?>

<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
</table>

</div>

<?php echo $this->fetch('footer.html'); ?>