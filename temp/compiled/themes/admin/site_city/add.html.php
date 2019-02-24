<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('site_city/nav.html'); ?>
<div class="main-body">
    <form method='post' action='admin.php?m=site_city&a=save'>
      <input type='hidden' name='sc_id' style='display:none;' value='<?php echo $this->_var['data']['sc_id']; ?>' >
      <table class='table table-bordered' width='100%'>
      	<tr>
          <td width="83">上级分类：</td>
          <td colspan="2">
          
          	<select id="pid_top" name="pid[]">
            <option value="0">请选择</option>
            <?php $_from = $this->_var['pid_top_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
            <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['sc_top']['sc_id'] == $this->_var['k']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
            
            <select id="pid_2nd" name="pid[]">
            <option value="0">请选择</option>
            <?php $_from = $this->_var['pid_2nd_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
            <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['sc_2nd']['sc_id'] == $this->_var['k']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            
            </select>
          
          </td>
        </tr>
        <tr>
          <td>区域名称：</td>
          <td width="214"><input type='text' name='title' id='title' value='<?php echo $this->_var['data']['title']; ?>' ></td>
          <td width="720" rowspan="7">
          <div id="map_canvas" style="width:600px; height:300px;"></div>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo BDMAPKEY; ?>"></script>
    <script language="javascript">
   var map = new BMap.Map("map_canvas");
   map.enableScrollWheelZoom();
   var point = new BMap.Point(<?php if ($this->_var['data']['lat'] > 0): ?><?php echo $this->_var['data']['lng']; ?>,<?php echo $this->_var['data']['lat']; ?><?php else: ?>118.165810,24.485228<?php endif; ?>);
   map.centerAndZoom(point, 12);
   var marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);              // 将标注添加到地图中
	marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
   map.addEventListener("click", function(e){
	   map.removeOverlay(marker);
	   point = new BMap.Point(e.point.lng,e.point.lat);
	   marker = new BMap.Marker(point);  // 创建标注
	   
		map.addOverlay(marker);  
	   $("#lat").val(e.point.lat);
	   $("#lng").val(e.point.lng);
   });
   
   function localsearch(word){
	   var local = new BMap.LocalSearch(map, {
		  renderOptions:{map: map}
		});
		local.search(word);
   }
    </script>
          </td>
        </tr>
        <tr>
          <td>区域关联id：</td>
          <td><input type='text' name='cityid' id='cityid' value='<?php echo $this->_var['data']['cityid']; ?>' ></td>
        </tr>
        <tr>
          <td>纬度：</td>
          <td><input type='text' name='lat' id='lat' value='<?php echo $this->_var['data']['lat']; ?>' ></td>
        </tr>
        <tr>
          <td>精度：</td>
          <td><input type='text' name='lng' id='lng' value='<?php echo $this->_var['data']['lng']; ?>' ></td>
        </tr>
        <tr>
          <td>排序：</td>
          <td><input type='text' name='orderindex' id='orderindex' value='<?php echo $this->_var['data']['orderindex']; ?>' ></td>
        </tr>
        <tr>
          <td>状态：</td>
          <td> <input type="radio" name="status" value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked="checked"<?php endif; ?> />显示 
          <input type="radio" name="status" value="0"  <?php if ($this->_var['data']['status'] == 0): ?> checked="checked"<?php endif; ?>/>隐藏
           </td>
        </tr>
        
        <tr>
          <td></td>
          <td><input type='submit' value='保存' class='btn btn-success'></td>
        </tr>
      </table>
    </form>
  </div>
 
<?php echo $this->fetch('footer.html'); ?>
</body>
</html>
<script language="javascript">
$(document).ready(function(){
	$("#title").bind("keyup",function(){
			localsearch($(this).val());
		});
	$("#pid_top").bind("change",function(){
		$.get("<?php echo $this->_var['appadmin']; ?>?m=site_city&a=child&sc_id="+$(this).val(),function(data){
			$("#pid_2nd").empty().append(data);
		});
	});
});
</script>
<?php echo $this->fetch('footer.html'); ?>