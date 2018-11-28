<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<style>
			.relBox{
				 
				position: relative;
			}
			.relBoxLeft{
				 
				margin-right: 300px;
			}
			.flex-img-view{
				position: fixed;
				right: 0;
				top: 20px;
				width:300px;
				text-align: center;
			}
			.flex{
				display: flex;
			}
			.flex-1{
				flex: 1;
			}
			.add-text{
				display: flex;
			}
			.addItem{
				border: 1px solid #ddd;
				padding: 10px;
				display: none;
				position: relative;
				margin-bottom: 5px;
			}
			.addItem-close{
				position: absolute;
				right:10px;
				top: 10px;
				color: red;
				cursor: pointer;
				width: 30px;
				height: 30px;
				text-align: center;
				line-height: 30px;
			}
			.mImg{
				display: inline-block;
				margin-right: 5px;
			}
			.mImg img{
				max-width: 50px;
			}
		</style>
		<div class="main-body">
		<div class="pd-10">图片设计</div>
		<div class="relBox">
			<div class="relBoxLeft">
				<div id="list">
					
				</div>
				<div id="editBox"></div>
				<div id="addBox">
					<div class="tabs-border" id="addTabs">
						<div class="item active">文本</div>
						<div class="item">图片</div>
						<div class="item">边框</div>
					</div>
					<form class="addItem" style="display: block;">
						<input type="hidden" name="type" value="text" /> 
						<input type="hidden" name="imgid" value="<?php echo $this->_var['data']['id']; ?>"/>
						<div class="flex mgb-10">
							
							<div >文本：</div> 
							<div class="flex-1">
								<input   type="text" name="word" /> 
							</div>
						</div>
						<div class="mgb-10">
							排序：<input type="text" name="orderindex" class="w50" />
							名称：<input  class="w100"  type="text" name="title" />
							大小：<input class="w50" type="text" name="size" />
							x轴：<input class="w50" type="text" name="x" />
							y轴：<input class="w50" type="text" name="y" />
							方向：<input class="w50" type="text" name="direction" />
							角度：<input class="w50" type="text" name="angle" />
						颜色：<input class="w60 color" type="text" name="color" />
						字体：<select class="w100" name="font">
							<?php $_from = $this->_var['fontList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('k', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['c']):
?>
							<option value="<?php echo $this->_var['c']; ?>"><?php echo $this->_var['k']; ?></option>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select>
							<div class="btn js-addSubmit">添加</div>
						</div>
						
					</form>
					<form class="addItem">
						<input type="hidden" name="type" value="img" />
						<input type="hidden" name="imgid" value="<?php echo $this->_var['data']['id']; ?>"/>
						<div class="flex mgb-10">
							<div >
								<div class="js-upload-item">
									<input type="file" id="upadd" class="js-upload-file" style="display: none;" />
									<div class="upimg-btn js-upload-btn">+</div>
									<input type="hidden" name="imgurl" class="js-imgurl" value="" />
									<div class="js-imgbox mImg">
										
									</div>
								</div>
							</div> 
							<div class="flex-1">
								排序：<input type="text" name="orderindex" class="w50" />
								名称：<input type="text" class="w100" name="title" />
								
								宽：<input class="w50" type="text" name="w" />
								高：<input class="w50" type="text" name="h" />
								x轴：<input class="w50" type="text" name="x" />
								y轴：<input class="w50" type="text" name="y" />
								方向：<input class="w50" type="text" name="direction" />
								角度：<input class="w50" type="text" name="angle" />
								
								<div class="btn js-addSubmit">添加</div>
							</div>
							
						</div>
						 
					</form>
					
					<form class="addItem">
						<input type="hidden" name="type" value="rectangle" />
						<input type="hidden" name="imgid" value="<?php echo $this->_var['data']['id']; ?>"/>
						<div class="flex mgb-10">
							
							<div class="flex-1">
								排序：<input type="text" name="orderindex" class="w50" />
								名称：<input type="text" class="w100" name="title" />
								
								宽：<input class="w50" type="text" name="w" />
								高：<input class="w50" type="text" name="h" />
								x轴：<input class="w50" type="text" name="x" />
								y轴：<input class="w50" type="text" name="y" />
								 
								角度：<input class="w50" type="text" name="angle" />
								颜色：<input class="w60 color" type="text" name="color" />
								边框：<input class="w60 color" type="text" name="border" />
								<div class="btn js-addSubmit">添加</div>
							</div>
							
						</div>
						
					</form>
					
				</div>
			</div>
			<div class="flex-img-view" id="sbImg">
				<img id="sbImg-load"  style=" width: 90%;border:1px solid #eee;">
			</div>
		</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			var id="<?php echo $this->_var['data']['id']; ?>";
		</script>
		<script id="list-tpl" type="text/html">
			<%for(var i in data){%>
				<% var $c=data[i]%>
				 
				<form class="addItem" style="display: block;">
					<div class="addItem-close" v="<%=$c.id%>">x</div>
					<input type="hidden" name="type" value="<%=$c.type%>" /> 
					<input type="hidden" name="imgid" value="<%=$c.imgid%>"/>
					<input type="hidden" name="id" value="<%=$c.id%>" />
					<%if($c.type == 'text'){%>
					<div class="flex mgb-10">
						
						<div >文本：</div> 
						<div class="flex-1">
							<input   type="text" name="word" value="<%=$c.word%>" /> 
						</div>
					</div>
					<div class="mgb-10">
						排序：<input type="text" name="orderindex" class="w50" value="<%=$c.orderindex%>" />
						名称：<input  class="w100"  type="text" name="title" value="<%=$c.title%>" />
						大小：<input class="w50" type="text" name="size" value="<%=$c.size%>"" />
						x轴：<input class="w50" type="text" name="x" value="<%=$c.x%>" />
						y轴：<input class="w50" type="text" name="y" value="<%=$c.y%>" />
						 
						角度：<input class="w50" type="text" name="angle" value="<%=$c.angle%>" />
					颜色：<input class="w60 color" type="text"  name="color" value="<%=$c.color%>" />
					边框：<input class="w60 color" type="text" name="border" value="<%=$c.border%>" />
						<div class="btn js-addSubmit">保存</div>
					</div>
					<%}else if($c.type=='rectangle'){%>
					<div class="mgb-10">
						排序：<input type="text" name="orderindex" class="w50" value="<%=$c.orderindex%>" />
						名称：<input  class="w100"  type="text" name="title" value="<%=$c.title%>" />
						宽：<input class="w50" type="text" name="w"  value="<%=$c.w%>" />
						高：<input class="w50" type="text" name="h" value="<%=$c.h%>" />
						x轴：<input class="w50" type="text" name="x" value="<%=$c.x%>" />
						y轴：<input class="w50" type="text" name="y" value="<%=$c.y%>" />
					 
						角度：<input class="w50" type="text" name="angle" value="<%=$c.angle%>" />
					颜色：<input class="w60 color" type="text"  name="color" value="<%=$c.color%>" />
					 边框：<input class="w60 color" type="text" name="border" value="<%=$c.border%>" />
						<div class="btn js-addSubmit">保存</div>
					</div>
					<%}else{%>
					
					<div class="flex mgb-10">
						<div >
							<div class="js-upload-item">
								<input type="file" id="up<%=$c.id%>" class="js-upload-file" style="display: none;" />
								<div class="upimg-btn js-upload-btn">+</div>
								<input type="hidden" name="imgurl" class="js-imgurl" value="<%=$c.imgurl%>" />
								<div class="js-imgbox mImg">
									<img src="<%=$c.imgurl%>.100x100.jpg"   />
								</div>
							</div>
						</div> 
						<div class="flex-1">
							排序：<input type="text" name="orderindex" class="w50" value="<%=$c.orderindex%>" />
							名称：<input type="text" class="w100" name="title" value="<%=$c.title%>" />
							宽：<input class="w50" type="text" name="w"  value="<%=$c.w%>" />
							高：<input class="w50" type="text" name="h" value="<%=$c.h%>" />
							x轴：<input class="w50" type="text" name="x" value="<%=$c.x%>" />
							y轴：<input class="w50" type="text" name="y" value="<%=$c.y%>" />
							角度：<input class="w50" type="text" name="angle" value="<%=$c.angle%>" />
							<div class="btn js-addSubmit">保存</div>
						</div>
						
					</div>
					<%}%>
				</form>
			<%}%>
		</script>
		 
		<script src="/plugin/jquery/template-native.js"></script>
		<script src="<?php echo $this->_var['skins']; ?>imgdiy/design.js"></script>
		<script src="<?php echo $this->_var['skins']; ?>js/upload.js"></script>
		<script src="/plugin/colpick/js/colpick.js"></script>
		 <link href="/plugin/colpick/css/colpick.css" rel="stylesheet" />
		 <script>
		$('.color').colpick({
			color:'ff8800',		
			onSubmit:function(hsb,hex,rgb,el) {
		
				$(el).css('background-color', '#'+hex);
				$(el).val(hex);
				$(el).colpickHide();
		
			}
		
		})	
		.css('color', '#ff8800');
		 </script>
	</body>
</html>