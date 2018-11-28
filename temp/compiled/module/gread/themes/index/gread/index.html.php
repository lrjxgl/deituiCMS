<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title">GRead</h1>
		</header>
		<div class="mui-content">
		     		<style>
		     			.mui-slider-item{
		     				text-align: center;
		     				height: 200px;
		     				 overflow: hidden;
		     			}
		     		 
		     		</style>
		    	 	<div id="slider" class="mui-slider" >
		    	 	  <div class="mui-slider-group mui-slider-loop">
		    	 	    <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
		    	 	    <div class="mui-slider-item mui-slider-item-duplicate">
		    	 	      <a href="#">
		    	 	        <img src="<?php echo $this->_var['skins']; ?>img/bn3.jpg">
		    	 	      </a>
		    	 	    </div>
		    	 	    <!-- 第一张 -->
		    	 	    <div class="mui-slider-item">
		    	 	      <a href="#">
		    	 	        <img src="<?php echo $this->_var['skins']; ?>img/bn1.jpg">
		    	 	      </a>
		    	 	    </div>
		    	 	    <!-- 第二张 -->
		    	 	    <div class="mui-slider-item">
		    	 	      <a href="#">
		    	 	        <img src="<?php echo $this->_var['skins']; ?>img/bn2.jpg">
		    	 	      </a>
		    	 	    </div>
		    	 	    <!-- 第三张 -->
		    	 	    <div class="mui-slider-item">
		    	 	      <a href="#">
		    	 	        <img src="<?php echo $this->_var['skins']; ?>img/bn3.jpg">
		    	 	      </a>
		    	 	    </div>
		    	 	   
		    	 	    <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
		    	 	    <div class="mui-slider-item mui-slider-item-duplicate">
		    	 	      <a href="#">
		    	 	        <img src="<?php echo $this->_var['skins']; ?>img/bn1.jpg">
		    	 	      </a>
		    	 	    </div>
		    	 	  </div>
		    	 	  <div class="mui-slider-indicator">
		    	 	    <div class="mui-indicator mui-active"></div>
		    	 	    <div class="mui-indicator"></div>
		    	 	    <div class="mui-indicator"></div>
		    	 	   
		    	 	  </div>
		    	 	</div>
		    	
		    	<style>
		    		.mui-table-view .desc{
		    			margin-right: 15px;
		    			color: #999;
		    			display: block;
		    			white-space: normal;
		    			line-height: 1.5;
		    			font-size: 12px;
		    		}
		    	</style>
		    	<ul class="mui-table-view">
		    		<?php $_from = $this->_var['articlelist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
	    	        <li class="mui-table-view-cell">
	    	            <a href="/module.php?m=gread_article&a=show&id=<?php echo $this->_var['c']['id']; ?>" class="mui-navigate-right">
	    	               	<?php echo $this->_var['c']['title']; ?>
	    	               	<div class="desc"><?php echo $this->_var['c']['description']; ?></div>
	    	            </a>
	    	        </li>
	    	        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	    	    </ul>
		    
		</div>
		<?php $this->assign('mfooter','index'); ?>
		<?php echo $this->fetch('footer.html'); ?>
	</body>
</html>
