<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<div class="tabs-border">
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad&tag_id=<?php echo get_post('tag_id');?>&tag_2nd_id=<?php echo get_post('tag_2nd_id');?>">广告管理</a>
	<a class="item  active" href="<?php echo $this->_var['appadmin']; ?>?m=ad&a=add&tag_id=<?php echo get_post('tag_id');?>&tag_2nd_id=<?php echo get_post('tag_2nd_id');?>">广告添加</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad_tags">广告分类管理</a>
	<a class="item" href="<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=add">广告分类添加</a>
</div>
<div class="main-body">
 
    <form method="post" action="admin.php?m=ad&a=save">
    <input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>" >
    <input type="hidden" id="img_width" value="<?php if ($this->_var['tag_2nd']): ?><?php echo intval($this->_var['tag_2nd']['width']); ?><?php else: ?><?php echo intval($this->_var['tag']['width']); ?><?php endif; ?>" />
    <input type="hidden" id="img_height" value="<?php if ($this->_var['tag_2nd']): ?><?php echo intval($this->_var['tag_2nd']['height']); ?><?php else: ?><?php echo intval($this->_var['tag']['height']); ?><?php endif; ?>" />
      <table class="table-add">
        
        <tr>
          <td width="100">分类id：</td>
          <td>
          <select class="w100" name="tag_id" id="ajax_tag_id">
          <option value="0">请选择</option>
          <?php $_from = $this->_var['tag_list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
          <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['tag_id'] || $this->_var['k'] == get_post ( "tag_id" )): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['title']; ?>(<?php echo $this->_var['c']['width']; ?>*<?php echo $this->_var['c']['height']; ?>)</option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select>
        	
            <select class="w150" name="tag_id_2nd" id="ajax_tag_id_2nd" <?php if (! $this->_var['tag_list_2nd']): ?>style="display:none"<?php endif; ?>>
          <option value="0">请选择</option>
          <?php $_from = $this->_var['tag_list_2nd']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
          <option value="<?php echo $this->_var['k']; ?>" <?php if ($this->_var['k'] == $this->_var['data']['tag_id_2nd'] || $this->_var['k'] == get_post ( "tag_2nd_id" )): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['title']; ?>(<?php echo $this->_var['c']['width']; ?>*<?php echo $this->_var['c']['height']; ?>)</option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select>
        
        </td> 
        </tr>
        <tr>
          <td>标题：</td>
          <td><input type="text" name="title" id="title" class="w600" value="<?php echo $this->_var['data']['title']; ?>" ></td>
        </tr>
        <tr>
          <td>描述：</td>
          <td><textarea name="info" id="info"  class="w600" ><?php echo $this->_var['data']['info']; ?></textarea></td>
        </tr>
        <tr>
          <td>链接1：</td>
          <td><input type="text" name="link1" id="link1"  class="w600"  value="<?php echo $this->_var['data']['link1']; ?>" ></td>
        </tr>
        <tr>
          <td>链接2：</td>
          <td><input type="text" name="link2" id="link2"  class="w600"  value="<?php echo $this->_var['data']['link2']; ?>" ></td>
        </tr>
        <tr>
          <td>开始时间：</td>
          <td><input readonly="" type="text" name="starttime" id="starttime" value="<?php if ($this->_var['data']): ?><?php echo date("Y-m-d H:m:s",$this->_var['data']['starttime']); ?><?php else: ?>2019-07-17 09:03:01<?php endif; ?>" ></td>
        </tr>
        <tr>
          <td>结束时间：</td>
          <td><input readonly="" type="text" name="endtime" id="endtime" value="<?php if ($this->_var['data']): ?><?php echo date("Y-m-d H:m:s",$this->_var['data']['endtime']); ?><?php else: ?>2029-07-17 09:03:01<?php endif; ?>" ></td>
        </tr>
        <tr>
          <td>图片地址：</td>
          <td>
						<div class="js-upload-item">
							<input type="file" id="upa" class="js-upload-file" style="display: none;" />
							<div class="upimg-btn js-upload-btn">+</div>
							<input type="hidden" name="imgurl" class="js-imgurl" value="<?php echo $this->_var['data']['imgurl']; ?>" />
							<div class="js-imgbox">
								<?php if ($this->_var['data']['imgurl']): ?>
								<img src="<?php echo images_site($this->_var['data']['imgurl']); ?>.100x100.jpg">
								<?php endif; ?>
							</div>
						</div>
						
					</td>
        </tr>
        
        <tr>
          <td>图片地址2：</td>
          <td>
						<div class="js-upload-item">
							<input type="file" id="upa2" class="js-upload-file" style="display: none;" />
							<div class="upimg-btn js-upload-btn">+</div>
							<input type="hidden" name="imgurl2" class="js-imgurl" value="<?php echo $this->_var['data']['imgurl2']; ?>" />
							<div class="js-imgbox">
								<?php if ($this->_var['data']['imgurl2']): ?>
								<img src="<?php echo images_site($this->_var['data']['imgurl2']); ?>.100x100.jpg">
								<?php endif; ?>
							</div>
						</div>
					</td>
        </tr>
        
        <tr>
          <td>排序：</td>
          <td><input type="text" name="orderindex" id="orderindex" value="<?php echo $this->_var['data']['orderindex']; ?>" ></td>
        </tr>
        <tr>
          <td>状态：</td>
          <td><input type="radio" name="status" value="1" <?php if ($this->_var['data']['status'] == 1): ?> checked="checked"<?php endif; ?> />隐藏 &nbsp; 
          <input type="radio" name="status" value="2" <?php if (! $this->_var['data'] || $this->_var['data']['status'] == 2): ?> checked="checked"<?php endif; ?> />显示</td>
        </tr>
        <?php if ($this->_var['data']): ?>
        <tr>
          <td>添加时间：</td>
          <td><?php echo date("Y-m-d",$this->_var['data']['dateline']); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
          <td>价格：</td>
          <td><input type="text" name="price" id="price" value="<?php echo $this->_var['data']['price']; ?>" ></td>
        </tr>
        <tr>
          <td>对象ID：</td>
          <td><input type="text" name="object_id" id="object_id" value="<?php echo $this->_var['data']['object_id']; ?>" ></td>
        </tr>
        
    
      </table>
      <div class="btn-row-submit js-submit">保存</div>
    </form>
  </div>
 <?php echo $this->fetch('footer.html'); ?>
<script language="javascript">
$(document).ready(function(){
	$("#ajax_tag_id").bind("change",function(){
		$.get("<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=child&tag_id="+$(this).val(),function(data){
			$("#img_width").val(data.width);
			$("#img_height").val(data.height);
			if(data.error==0){
				var len=data.data.length;
				var opt="<option value=0>请选择</option>";
				for(var i=0;i<len;i++){
					opt+="<option value=\""+data.data[i].tag_id+"\">"+data.data[i].title+"("+data.data[i].width+"*"+data.data[i].height+")</option>";
				}
				$("#ajax_tag_id_2nd").empty().append(opt).show();
			}else{
				$("#ajax_tag_id_2nd").empty().append("<option value=0>请选择</option>").hide();
			}
		},"json");
	});
	
	$("#ajax_tag_id_2nd").bind("change",function(){
		$.get("<?php echo $this->_var['appadmin']; ?>?m=ad_tags&a=child&tag_id="+$(this).val(),function(data){
			$("#img_width").val(data.width);
			$("#img_height").val(data.height);
		},"json")
	});
	
});
</script>
<script src="/static/admin/js/upload.js"> </script>
<script src="/plugin/laydate/laydate.js"></script>
<script>
	laydate.render({
		elem:"#starttime",
		type: 'datetime'
	})
	laydate.render({
		elem:"#endtime",
		type: 'datetime'
	})
</script>
</body>
</html>
