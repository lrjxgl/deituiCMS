<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
 
<div class="tabs-border">
	<a class="item active" href="<?php echo $this->_var['appadmin']; ?>?m=module">插件列表</a>
	<a class="item" href="http://www.deituicms.com/module.php?m=down" target="_blank">应用商店</a>
</div>
<div class="main-body">
 
<table  class="tbs">
<thead>
	<tr>
		<td>插件名称</td>
		<td>插件描述</td>
		<td>操作</td>
	</tr>
</thead>	 
<tr>
	<?php $_from = $this->_var['mods']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
	<td width="15%"><?php echo $this->_var['c']['title']; ?></td>
	<td width=" "><?php echo $this->_var['c']['info']; ?></td>
	<td width="22%">
	<?php if ($this->_var['c']['isinstall']): ?>
	<a href='javascript:;' class="cl-danger" onclick="if(confirm('确认卸载插件吗？')){window.location.href='<?php echo $this->_var['appadmin']; ?>?m=module&a=uninstall&inmodule=<?php echo $this->_var['c']['module']; ?>';}">卸载插件</a>
	
	<a href="/module.php?m=<?php echo $this->_var['c']['module']; ?>" target="_blank">查看</a>
	<a href="javascript:;" onclick="window.parent.goPluginMenu('<?php echo $this->_var['c']['adminurl']; ?>')" >管理</a>
	 
	<?php else: ?><a href='<?php echo $this->_var['appadmin']; ?>?m=module&a=install&inmodule=<?php echo $this->_var['c']['module']; ?>'>安装</a><?php endif; ?>
	 
	 
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
</div>

<?php echo $this->fetch('footer.html'); ?>
<script>
$(function(){
	$(document).on("click","#yun_app_install",function(){
		$.post("<?php echo $this->_var['appadmin']; ?>?m=module&a=DownInstall&ajax=1&downcode="+$("#downcode").val(),function(data){
			if(data.error){
				skyToast(data.message);
			}else{
				skyToast(data.message);
			}
		},"json");
	});
});
</script>
</body>
</html>