<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>
<style>
	.list{
		padding: 5px;
	}
	.list-item{
		background-color: #fff;
		padding: 10px;
		width: 49%;
		float: left;
		box-sizing: border-box;
		margin-right: 1%;
	}
	.list-img{
		width: 100%;
	}
	.list-title{
		font-size: 14px;
		line-height: 1.5; 
		color: #323232;
	}
	.list-price{
		color: #f60;
		font-size: 16px;
	}
</style>
<body>
 <header class="mui-bar mui-bar-nav">
     <a href="/" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
     <h1 class="mui-title">在线课程</h1>
 </header>
 <div class="mui-content">
	 <div class="list">
		 <?php $_from = $this->_var['data']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		 <div class="list-item">
			 <div gourl="/module.php?m=book&a=show&bookid=<?php echo $this->_var['c']['bookid']; ?>" class="img">
				 <img class="list-img" src="<?php echo images_site($this->_var['c']['imgurl']); ?>.100x100.jpg" />
			 </div>
			 <div gourl="/module.php?m=book&a=show&bookid=<?php echo $this->_var['c']['bookid']; ?>" class="list-title"><?php echo $this->_var['c']['title']; ?></div>
			 <div class="list-price">￥<?php echo $this->_var['c']['money']; ?></div>
		 </div>
		 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 </div>
    
 </div>
 
 <?php echo $this->fetch('footer.html'); ?>
</body>
</html>