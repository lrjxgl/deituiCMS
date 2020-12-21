<!DOCTYPE  html>
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
 <div class="tabs-border">
 	<a class="item" href="/admin.php?m=article">文章列表</a>
 	<a class="item active" href="/admin.php?m=article&a=add">文章编辑</a>
 </div> 
<div class="main-body">
	<form method="post" action="admin.php?m=article&a=save">
		
		<input type="hidden" name="id" style="display:none;" value="<?php echo $this->_var['data']['id']; ?>">
		<div class="tabs-box">
			<div class="js-tabs tabs-border">
					<a class="item active" href="#base">基本信息</a>
						 
						<a class="item" href="#other">扩展</a>
				</div>
			<div class="tabs-item active" id="base">	
		<table class="table-add">
		<tr>
			<td>标题：</td>
			<td><input type="text" name="title" id="title" value="<?php echo $this->_var['data']['title']; ?>"></td>
		</tr>	
		<tr>
			<td>分类：</td>
			<td>
			<select name="catid" id="catid" class="input-flex-select w150">
			    <option value="0">请选择</option>
			    <?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			                <option value="<?php echo $this->_var['c']['catid']; ?>" <?php if ($this->_var['data']['catid'] == $this->_var['c']['catid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['cname']; ?></option>
			                <?php $_from = $this->_var['c']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_2');if (count($_from)):
    foreach ($_from AS $this->_var['c_2']):
?>
			                	<option value="<?php echo $this->_var['c_2']['catid']; ?>" <?php if ($this->_var['data']['catid'] == $this->_var['c_2']['catid']): ?> selected="selected"<?php endif; ?> class="o_c_2">|__<?php echo $this->_var['c_2']['cname']; ?></option>
			                    <?php $_from = $this->_var['c_2']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c_3');if (count($_from)):
    foreach ($_from AS $this->_var['c_3']):
?>
			                    <option value="<?php echo $this->_var['c_3']['catid']; ?>" <?php if ($this->_var['data']['catid'] == $this->_var['c_3']['catid']): ?> selected="selected"<?php endif; ?> class="o_c_3"> |____<?php echo $this->_var['c_3']['cname']; ?></option>
			                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			    </select>
			</td>		
		</tr>
		<tr>
			<td>图片：</td>
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
			<td>作者</td>
			<td>
				<input type="text" name="author" value="<?php echo $this->_var['data']['author']; ?>" />
			</td>
		</tr>
		<tr>
			<td>喜欢数：</td>
			<td><input type="text" name="love_num" id="love_num" value="<?php echo $this->_var['data']['love_num']; ?>"></td>
		</tr>	
		<tr>
			<td>收藏：</td>
			<td><input type="text" name="fav_num" id="fav_num" value="<?php echo $this->_var['data']['fav_num']; ?>"></td>
		<tr>
			<td>描述：</td>
			<td>
				<textarea name="description" id="description" class="w600 h60"><?php echo $this->_var['data']['description']; ?></textarea>
			</td>
		</tr>	
		 
		<tr>
			<td>推荐：</td>
			<td>
				<input type="radio" name="is_recommend" value="1" <?php if ($this->_var['data']['is_recommend']): ?> checked<?php endif; ?>  /> 推荐
				&nbsp;&nbsp;
				<input type="radio" name="is_recommend" value="0"  <?php if (! $this->_var['data']['is_recommend']): ?> checked<?php endif; ?>/> 不推荐
				
			</td>
		</tr>
		<tr>
        <td>访问数：</td>
        <td><input type="text" name="view_num" id="view_num" value="<?php echo $this->_var['data']['view_num']; ?>" ></td>
      </tr>
     
      
      
      <tr>
        <td>详情模板：</td>
        <td><input class="w300" type="text" name="tpl" id="tpl" value="<?php echo $this->_var['data']['tpl']; ?>" >(如果需要可以指定模板)</td>
      </tr>
		<tr>
			<td>创建时间：</td>
			<td><?php echo $this->_var['data']['createtime']; ?></td>
		</tr>
		<tr>
			<td>内容</td>
			<td>
				<script type="text/plain" id="content" name="content" ><?php echo $this->_var['data']['content']; ?></script>
			</td>
		</tr>
		</table>
		</div>
		 
        <div class="tabs-item active" id="other">
        	<table class="table-add">
            	 <tr>
        <td class="w90">产品价格：</td>
        <td><input type="text" name="price" id="price" value="<?php echo $this->_var['data']['price']; ?>" ></td>
      </tr>
      <tr>
        <td>市场价格：</td>
        <td><input type="text" name="market_price" id="market_price" value="<?php echo $this->_var['data']['market_price']; ?>" ></td>
      </tr>
      <tr>
        <td>库存数：</td>
        <td><input type="text" name="total_num" id="total_num" value="<?php echo $this->_var['data']['total_num']; ?>" ></td>
      </tr>
      <tr>
        <td>销售数：</td>
        <td><input type="text" name="sold_num" id="sold_num" value="<?php echo $this->_var['data']['sold_num']; ?>" ></td>
      </tr>
      <tr>
        <td>积分：</td>
        <td><input type="text" name="grade" id="sold_num" value="<?php echo $this->_var['data']['grade']; ?>" ></td>
      </tr>
       
       <tr>
      	<td>图集</td>
        <td>
        	<input type="hidden" id="imgsdata" name="imgsdata" value="<?php echo $this->_var['data']['imgsdata']; ?>" />
     	 <?php echo $this->fetch('inc/uploader-data.html'); ?> 
        </td>
      </tr>
      
            </table>
        </div>
		
		<div class="btn-row-submit js-submit">保存</div>
	</form>
</td>
<?php echo $this->fetch('footer.html'); ?>
<?php loadEditor();;?>
 
 
<script language="javascript" src="/static/admin/js/upload.js"></script>
<script src="/plugin/lrz/lrz.bundle.js"></script>
<script src="<?php echo $this->_var['skins']; ?>inc/uploader-data.js"></script>
<script language="javascript">
 
var editor=UE.getEditor('content',options);

$(document).on("click","#js-view",function(){
	var html=editor.getContent();
	html='<div class="d-content">'+html+'</td>'
	showbox("文章预览",html,375,500);
})
</script>
</body>
</html>