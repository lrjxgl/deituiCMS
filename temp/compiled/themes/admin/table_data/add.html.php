<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div><?php echo $this->_var['table']['title']; ?>:<?php echo $this->_var['table']['tablename']; ?></div>
			<a href="?m=table_data&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">数据列表</a>
			
			<a href="?m=table_data&a=add&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item active">发布</a>
			<a href="?m=table_fields&a=table&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">表设计</a>
		</div>
		<div class="main-body">
			<form  class="list">
				<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
				<input type="hidden" name="tableid" value="<?php echo $this->_var['table']['tableid']; ?>" />
				<?php $_from = $this->_var['fieldsList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<?php if ($this->_var['c']['fieldtype'] == 'text'): ?>
				<div class="input-flex">
					<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<input type="text" name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" value="<?php echo $this->_var['c']['value']; ?>" />
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'textarea'): ?>
				<div class="textarea-flex">
					<div class="textarea-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<textarea name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="textarea-flex-text h60"><?php echo $this->_var['c']['value']; ?></textarea>
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'select'): ?>
				<div class="input-flex">
					<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<select name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]">
						<option value="">请选择</option>
						<?php $_from = $this->_var['c']['opsList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'ss');if (count($_from)):
    foreach ($_from AS $this->_var['ss']):
?>
						<option value="<?php echo $this->_var['ss']; ?>" <?php if ($this->_var['ss'] == $this->_var['c']['value']): ?>selected<?php endif; ?>><?php echo $this->_var['ss']; ?></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>	
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'html'): ?>
				<div class="textarea-flex">
					<div class="textarea-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<div class="js-html-item">
						<textarea name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="none js-html-textarea"><?php echo $this->_var['c']['value']; ?></textarea>
						<div contenteditable="true" class="sky-editor-content textarea-flex-text "><?php echo $this->_var['c']['value']; ?></div>
					</div>
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'img'): ?>
				<div class="input-flex">
					<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
					<div class="flex-1">
						<div class="js-upload-item">
							<input type="file" id="tablefield<?php echo $this->_var['c']['id']; ?>" class="js-upload-file" style="display: none;" />
							<div class="upimg-btn js-upload-btn">+</div>
							<input type="hidden" name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="js-imgurl" value="<?php echo $this->_var['c']['value']; ?>" />
							<div class="js-imgbox">
								<?php if ($this->_var['c']['value']): ?>
								<img src="<?php echo images_site($this->_var['c']['value']); ?>.100x100.jpg" class="w60" />
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php elseif ($this->_var['c']['fieldtype'] == 'map'): ?>
				<div class="input-flex">
					<div class="input-flex-label">地图</div>
					<div class="flex-1  js-map">
						<input type="hidden" class="map-value"  name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]"  value="<?php echo $this->_var['c']['value']; ?>" />
						<div class="flex">
							<input type="text" id="mapWord" />
							<div id="mapSearch" class="input-flex-btn">搜一下</div>
						</div>
						<div class="map" id="map" style="width: 400px; height: 300px;"></div>
					</div>
				</div>	
				
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				<div class="btn-row-submit" id="submit">保存</div>
				
			</form>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script language="javascript" src="/static/admin/js/upload.js"></script>
		<script src="/plugin/lrz/lrz.bundle.js"></script>
		<script src="/plugin/skyeditor/skyeditor.js"></script>
		<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=<?php echo BDMAPKEY; ?>"></script>
		<script>
			var maps=$(".js-map");
			var $field=maps.find(".map-value");
			 var map = new BMap.Map("map");
			 map.enableScrollWheelZoom();
			  // 添加带有定位的导航控件
			  var navigationControl = new BMap.NavigationControl({
				// 靠左上角位置
				anchor: BMAP_ANCHOR_TOP_LEFT,
				// LARGE类型
				type: BMAP_NAVIGATION_CONTROL_LARGE,
				// 启用显示定位
				enableGeolocation: true
			  });
			  map.addControl(navigationControl);
			  var geolocationControl = new BMap.GeolocationControl();
			  map.addControl(geolocationControl);
			 var point = new BMap.Point(118.165810,24.485228);
			  map.centerAndZoom(point, 12);
			  var marker = new BMap.Marker(point);  // 创建标注
			 map.addOverlay(marker); 
			 map.addEventListener("click", function(e){
			   map.removeOverlay(marker);
			   point = new BMap.Point(e.point.lng,e.point.lat);
			   marker = new BMap.Marker(point);  // 创建标注
			   
			 		map.addOverlay(marker);  
			   $field.val(e.point.lng+","+e.point.lat);
			   
			 });
			  function localsearch(word){
			   var local = new BMap.LocalSearch(map, {
			 		  renderOptions:{map: map}
			 		});
			 		local.search(word);
			 }
			 var lastword="";
			 $(document).on("click","#mapSearch",function(){
				 var word=$("#mapWord").val();
				 if(word==lastword){
					 return false;
				 }
				 lastword=word;
				 if(word==""){
					 map.centerAndZoom(point, 12);
				 }else{
					 
					 localsearch(word) 
				 }
				
			 })
		</script>
		<script>
			$(document).on("click","#submit",function(){
				var form=$(this).parents("form");
				var len=$(".sky-editor-content").length;
				for(var i=0;i<len;i++){
					var $e=$(".sky-editor-content:eq("+i+")");
					$e.parents(".js-html-item").find(".js-html-textarea").val($e.html());
				}
				$.ajax({
					url:"?m=table_data&a=save&ajax=1",
					data:form.serialize(),
					method:"POST",
					success:function(res){
						goBack();
					}
				})
			})
		</script>
	</body>
</html>
