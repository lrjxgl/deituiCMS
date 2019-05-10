<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>
<script language="javascript">
function movenew()
{
	document.location="<?php echo $this->_var['url']; ?>";
}
setTimeout(movenew,2000);

</script>
<style>
	.gomsg{
		width: 300px;
		margin: 50px auto;
		border: 3px solid #ddd;
		border-radius: 5px;
		padding: 20px; 
		
	}
</style>
<body>
<div class="tabs-border">
	<div class="tabs-border-item tabs-border-active">跳转提示</div>
</div>
<div class="main-body">	 
    <div class="gomsg"><?php echo $this->_var['message']; ?>，如果没有自动跳转请点击 <a href="<?php echo $this->_var['url']; ?>">跳转</a></div>    
</div>
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>