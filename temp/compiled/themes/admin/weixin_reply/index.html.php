<?php echo $this->fetch('header.html'); ?>
 <ul class="nav nav-tabs">
<li class="active"><a href="<?php echo $this->_var['appadmin']; ?>?m=weixin_reply&wid=<?php echo $this->_var['weixin']['id']; ?>">微信回复消息</a></li>
 
</ul>
<div class="main-body">
 
 
<div class="search-form">
<form method="get" action="<?php echo $this->_var['appadmin']; ?>">
<input type="hidden" name="m" value="weixin_reply" />
用户：<input type="text" name="openid" value="<?php echo $_GET['openid']; ?>" />
状态：<select name="s_status">
<option value="0">请选择</option>
<option value="1" <?php if (get ( 's_status' ) == 1): ?> selected="selected"<?php endif; ?>>已解决</option>
<option value="2" <?php if (get ( 's_status' ) == 2): ?> selected="selected"<?php endif; ?>>未解决</option>
</select>
<input type="submit" value="搜索" class="btn" />
</form>
</div>
 <table class="tbs">
 	<thead>
  <tr>
   <td>用户</td>
   <td>状态</td>
   <td>消息类型</td>
   <td>时间</td>
   <td>文本消息内容</td>
   <td>图片</td>
   <td>图文消息标题</td>
   <td>图文消息说明</td>
   <td>消息链接</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['openid']; ?></td>
   <td><?php if ($this->_var['c']['status']): ?>已解决<?php else: ?>未解决<?php endif; ?></td>
   <td><?php echo $this->_var['c']['msgtype']; ?></td>
   <td><?php echo date("m-d H:m",$this->_var['c']['createtime']); ?></td>
   <td><?php echo $this->_var['c']['content']; ?></td>
   <td><?php if ($this->_var['c']['picurl']): ?><img src="<?php echo $this->_var['c']['picurl']; ?>" style="width:50px; height:50px;" /><?php endif; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
   <td><?php echo $this->_var['c']['description']; ?></td>
   <td><?php if ($this->_var['c']['url']): ?><a href="<?php echo $this->_var['c']['url']; ?>" target="_blank">查看</a><?php endif; ?></td>
<td><a href="javascript:;" class="delete" url="admin.php?m=weixin_reply&a=delete&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
 
<?php echo $this->fetch('footer.html'); ?>