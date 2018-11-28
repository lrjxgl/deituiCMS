<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>写书</title>
		<script src="/plugin/jquery/jquery-2.1.3.min.js"></script>
		<link href="/plugin/skyweb/skyweb.css" rel="stylesheet"  />
	</head>
	<style>
		.topbox{
			height: 50px;
			border-bottom: 1px solid #eee;
		}
		.topbox .title{
			padding: 10px;
			font-size: 24px;
			display: inline-block;
			margin-right: 10px;
		}
	 	#menuEdit{
	 		height: 30px;
	 		line-height: 30px;
	 		padding-left: 5px;
	 		font-size: 18px;
	 		cursor: pointer;
	 		color: #F76260;
	 	}
		.menulist{
			width: 200px;
			border-right: 1px solid #eee;
			margin-right: 10px;
			position: absolute;
			top: 60px;
			bottom: 10px;
			overflow: auto;
		}
		.menulist .aitem .atitle{
			border-bottom: 1px solid #eee;
			padding: 5px;
			font-size: 14px;
			color: #333;
			cursor: pointer;
		}
		.menulist .bitem .btitle{
			border-bottom: 1px solid #eee;
			padding: 5px 5px 5px 5px;
			padding-left: 20px;
			font-size: 14px;
			color: #444;
			cursor: pointer;
		}
		.menulist .citem{
			border-bottom: 1px solid #eee;
			padding: 5px 5px 5px 5px;
			padding-left: 40px;
			font-size: 16px;
			color: #555;
			cursor: pointer;
		}
		#rightbox{
			display: block;
			position: absolute;
			left: 210px;
			right: 10px;
			top: 60px;
			bottom: 10px;
		}
		.edit-article-btn{
			float: right;
			display: inline-block;
			width: 30px;
			height: 30px;
			line-height: 30px;
			text-align: center;
			font-size: 20px;
			cursor: pointer;
		}
		#iframe{
			width: 100%;
			height: 100%;
			overflow: auto;
			border: 0;
		}
		.tanbox-bg{
			position: fixed;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			opacity: 0.8;
			background-color: #aaa;
			display: none;
		}
		.tanbox{
			position: fixed;
			z-index: 100;
			width: 400px;
			height: 100px;
			background-color: #fff;
			left: 50%;
			margin-left: -200px;
			top: 50%;
			margin-top: -50px;
			padding: 10px;
			display: none;
		}
		.tanbox .row{
			margin-bottom: 10px;
		}
		.tanbox .text{
			width: 96%;
		}
		.tanbox .btns{
			text-align: center;
		}
		.tanbox .btns .btn{
			margin-right: 20px;
		}
		.js-go.active{
			color: red !important;
		}
	</style>
 
	<body>
		<div id="top" class="topbox">
			<div class="title"><?php echo $this->_var['book']['title']; ?></div>
			<a href="/module.php?m=book&a=show&bookid=<?php echo $this->_var['book']['bookid']; ?>" style="font-size: 16px;" target="_blank">查看</a>
		</div>
		<div id="leftbox" class="menulist">
				 <div id="menuEdit" bookid="<?php echo $this->_var['book']['bookid']; ?>">编辑章节</div>
				<?php $_from = $this->_var['artlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'a');if (count($_from)):
    foreach ($_from AS $this->_var['a']):
?>
					<div class="aitem" id="aitem<?php echo $this->_var['a']['id']; ?>" >
						<div class="atitle js-go" vid="<?php echo $this->_var['a']['id']; ?>" ><?php echo $this->_var['a']['title']; ?></div>
						<?php if ($this->_var['a']['child']): ?>
							<?php $_from = $this->_var['a']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'b');if (count($_from)):
    foreach ($_from AS $this->_var['b']):
?>
							<div class="bitem" id="bitem<?php echo $this->_var['b']['id']; ?>" >
								<div class="btitle js-go" vid="<?php echo $this->_var['b']['id']; ?>" ><?php echo $this->_var['b']['title']; ?></div>
								<?php if ($this->_var['b']['child']): ?>
									<?php $_from = $this->_var['b']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
									<div id="citem<?php echo $this->_var['c']['id']; ?>" class="citem js-go" vid="<?php echo $this->_var['c']['id']; ?>"  ><?php echo $this->_var['c']['title']; ?></div>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								<?php endif; ?>
								</div>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						<?php endif; ?>
					</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		<div id="rightbox" >
				<iframe id="iframe" ></iframe>
			</div>
		<div class="tanbox-bg"></div>	
		<div id="artbox" class="tanbox">
			<div class="row"><input class="text" type="text" name="title" id="add-title"  /></div>
			<div class="btns">
				<div class="btn btn-submit" id="add-submit">添加</div>
				<div class="btn btn-submit" id="add-cancel">取消</div>
			</div>
			
		</div>	
		<script>
			$(document).on("click",".js-go",function(){
				var id=$(this).attr("vid");
				$(".js-go").removeClass("active");
				$(this).addClass("active");
				var url="/moduleadmin.php?m=book_article&a=add&id="+id;
				var iframe='<iframe id="iframe" src="'+url+'"></iframe>';
				$("#rightbox").html(iframe);
			})
			 
			$(document).on("click","#menuEdit",function(){
				var bookid=$(this).attr("bookid");
				var url="/moduleadmin.php?m=book&a=menu&bookid="+bookid;
				var iframe='<iframe id="iframe" src="'+url+'"></iframe>';
				$("#rightbox").html(iframe);
			})
		</script>
	</body>
</html>
