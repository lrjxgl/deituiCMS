<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<link href="<?php echo $this->_var['skins']; ?>imgdiy/design.css?<?php echo time(); ?>" rel="stylesheet" />
	<body>
		<div class="md-bg">
			<div class="md-picbox">
				<img class="md-pic" src="/module.php?m=imgdiy&a=img&id=2" />
			</div>
		</div>
		<div class="md-footer">
			<div class="md-tabs">
				 
				<div class="md-tabs-item">
					<div class="md-tabs-icon icon-moban"></div>
					<div class="md-tabs-title">换个模板</div> 
				</div>
				<div class="md-tabs-item">
					<div class="md-tabs-icon icon-pic"></div>
					<div class="md-tabs-title">换张图片</div> 
				</div>
				<div class="md-tabs-item">
					<div class="md-tabs-icon icon-wenzi"></div>
					<div class="md-tabs-title">修改文字</div> 
				</div>
				 
			</div>
			<div class="md-btn">完成制作,生成海报</div>
		</div>
	</body>
</html>
