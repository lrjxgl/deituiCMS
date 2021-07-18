<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('zblive/nav.html'); ?>
<div class="main-body">
<div class="search-form">
<form method="get" action="/moduleadmin.php">
<input type="hidden" name="m" value="zblive" />
<div class="mgb-5">
ID:<input type="text" name="id" value="<?php echo intval($_GET['id']); ?>" class="w50" />
状态：<select name="statusType" class="w100">
	<option value="0">选择</option>
	
    <option value="online" <?php if (get ( 'statusType' ) == 'online'): ?>selected="selected"<?php endif; ?>>已审核</option>
	<option value="uncheck" <?php if (get ( 'statusType' ) == 'uncheck'): ?>selected="selected"<?php endif; ?>>待审核</option>
    <option value="offline" <?php if (get ( 'statusType' ) == 'offline'): ?>selected="selected"<?php endif; ?>>已禁止</option>
</select>
直播状态：<select name="zbtype" class="w100">
	<option value="">选择</option>
	<option value="unbegin" <?php if (get ( 'zbtype' ) == "unbegin"): ?>selected="selected"<?php endif; ?>>未开始</option>
    <option value="doing" <?php if (get ( 'zbtype' ) == "doing"): ?>selected="selected"<?php endif; ?>>直播中</option>
    <option value="finish" <?php if (get ( 'zbtype' ) == "finish"): ?>selected="selected"<?php endif; ?>>已结束</option>
</select>
主题：<input type="text" name="title" value="<?php echo $_GET['title']; ?>" class="w150" />
用户：<input class="w100" type="text" name="nickname" value="<?php echo html($_GET['nickname']); ?>" />
<input type="submit" value="搜索" class="btn" />
</div>
</form>
</div>
 <table class="tbs">
	 <thead>
  <tr>
   <td>id</td>
   <td>名称</td>
    
  <td>用户</td>
   
 
   <td>状态</td>
   <td>直播状态</td> 
   <td>可回放</td>
   <td>封面</t>
    
   <td>开始时间</td>
   <td>结束时间</td>
  
   <td>访问数</td>
<td>操作</td>
  </tr>
  </thead>
 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<tr>
   <td><?php echo $this->_var['c']['id']; ?></td>
   <td><?php echo $this->_var['c']['title']; ?></td>
 
   <td><?php echo $this->_var['c']['nickname']; ?></td> 
   
   
 
   <td>
	   <div class="<?php if ($this->_var['c']['status'] == 1): ?>yes<?php else: ?>no<?php endif; ?> js-toggle-status" url="/moduleadmin.php?m=zblive&a=status&ajax=1&id=<?php echo $this->_var['c']['id']; ?>"></div>
   </td>
  <td><?php if ($this->_var['c']['zbstatus'] == 1): ?>直播中<?php elseif ($this->_var['c']['zbstatus'] == 0): ?>未直播<?php else: ?>已结束<?php endif; ?></td>
  <td>
	  <div class="<?php if ($this->_var['c']['isback'] == 1): ?>yes<?php else: ?>no<?php endif; ?>"></div>
  </td> 
   
   <td><img src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg" width="50"></td>
    
   <td><?php echo date("m-d H:i",$this->_var['c']['starttime']); ?></td>
   <td><?php echo date("m-d H:i",$this->_var['c']['endtime']); ?></td>
   
   <td><?php echo $this->_var['c']['view_num']; ?></td>
<td> 
	<a class="js-setToken" v="<?php echo $this->_var['c']['id']; ?>" >刷新直播流</a>
	 <a class="js-getRecord" v="<?php echo $this->_var['c']['id']; ?>" >刷新回放</a> 
	 <a href="/moduleadmin.php?m=zblive_product&room_id=<?php echo $this->_var['c']['id']; ?>">产品列表</a>
	 <br/>
	 <a href="/moduleadmin.php?m=zblive&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a>
	<a href="/module.php?m=zblive&a=show&id=<?php echo $this->_var['c']['id']; ?>" target="_blank">查看</a> 
	<a href="javascript:;" class="js-delete" url="/moduleadmin.php?m=zblive&a=delete&ajax=1&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
  </tr>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </table>
<div><?php echo $this->_var['pagelist']; ?></div>
</div> 
</div>
<?php echo $this->fetch('footer.html'); ?>
<script>
	$(document).on("click",".js-getRecord",function(){
		var id=$(this).attr("v");
		$.ajax({
			url:"/moduleadmin.php?m=zblive&a=GetRecordUrl&ajax=1&id="+id,
			dataType:"json",
			success:function(res){
				skyToast(res.message)
			}
		})
	})
	$(document).on("click",".js-setToken",function(){
		var id=$(this).attr("v");
		$.ajax({
			url:"/moduleadmin.php?m=zblive&a=settoken&ajax=1&id="+id,
			dataType:"json",
			success:function(res){
				skyToast(res.message)
			}
		})
	})
</script>
</body>	
</html>