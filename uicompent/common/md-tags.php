<div class="md-tags">
	<div class="md-tags-hd">标签</div>
<?php
	if(!empty($mdDataList)):
	foreach($mdDataList as $v):
?>
	<a class="md-tags-item" href="<?=$v['url']?>"><?=$v['title']?></a>

<?php 
	endforeach;
	endif;
?>

</div>

