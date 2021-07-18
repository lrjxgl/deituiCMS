<!doctype html>
<html>
<?php echo $this->fetch('head.html'); ?>
 
<body>
<div class="tabs-border">
	<div class="item active">跳转提示</div>
</div>
<script language="javascript">
function movenew()
{
	document.location='<?php echo $this->_var['url']; ?>';
}
setTimeout(movenew,2000);

</script>
<div class="main-body">
<div class="well">
<?php echo $this->_var['message']; ?>，如果没有自动跳转请点击 <a href="<?php echo $this->_var['url']; ?>">跳转</a>

</div> 
</div>

<?php echo $this->fetch('footer.html'); ?>
</body>
</html>