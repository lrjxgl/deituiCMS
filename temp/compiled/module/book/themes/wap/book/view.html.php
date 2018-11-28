<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<title><?php echo $this->_var['book']['title']; ?></title>
		<script src="/plugin/jquery/jquery-2.1.3.min.js"></script>
		<script src="/plugin/skyweb/skyweb.js"></script>
		<link href="/plugin/skyweb/skyweb.css" rel="stylesheet"  />
		<link href="/plugin/iconfont/iconfont.css?v=2s13x" rel="stylesheet">
	</head>
	<style>
		.back{
			display: inline-block;
			width: 50px;
			height: 50px;
			line-height: 50px;
			text-align: center;
		}
		table{
		 		width: 100%;
		 		border-collapse: collapse;
		 	}
		 	table td{
		 		border:1px solid #ddd;
		 		padding: 10px 5px;
		 	}
		.page-index{
			padding-top: 50px;
		}
		
		.topbox{
			height: 50px;
			border-bottom: 1px solid #eee;
			font-size: 16px;
			position: fixed;
			left: 0;
			right: 0;
			top: 0;
			background-color: #fff;
			z-index: 99;
		}
		.topbox .title{
			padding: 10px;
			font-size: 24px;
			display: block;
			flex: 1;
			text-align: center;
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
			 
		  
		}
		.menulist .aitem{
			position: relative;
		}
		.menulist .aitem .atitle{
			border-bottom: 1px solid #eee;
			padding: 10px 5px;
			font-size: 18px;
			color: #333;
			cursor: pointer;
			display:block;
			text-decoration: none;
		}
		.menulist .bitem{
			position: relative;
		}
		.menulist .bitem .btitle{
			border-bottom: 1px solid #eee;
			padding: 10px 5px;
			padding-left: 20px;
			font-size: 16px;
			color: #444;
			cursor: pointer;
			display:block;
			text-decoration: none;
		}
		.menulist .citem{
			border-bottom: 1px solid #eee;
			padding: 10px 5px;
			padding-left: 40px;
			font-size: 16px;
			color: #555;
			cursor: pointer;
			display:block;
			text-decoration: none;
			position: relative;
		}
		.page-show{
			display: block;
			position: relative; 
			padding-top: 45px; 
			background-color: #fff;
			display: none;
			z-index: 99;
		}
		.page-show .hd{
			line-height: 40px;
			text-align: center;
			position: relative;
			font-size: 16px;
			border-bottom: 1px solid #eee;
			margin-bottom: 10px;
			position: fixed;
		    left: 0;
		    right: 0;
		    top: 0;
		    background-color: #fff;
		    z-index: 99;
		}
		.page-show-close{
			right: 2px;
			top: 2px;
			width: 46px;
			height: 36px;
			text-align: center;
			display: block;
			position: absolute;
			cursor: pointer;
			background-color: #eee;
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
		.topbox{
			display: flex;
		}
		.topbox .copyright{
			padding-top: 15px;
		}
		.search-box{
			display: none;
			padding: 10px;
			 
			position: absolute;
			background-color: #fff;
			left: 0;
			top: 45px;
			right: 0px;
			z-index: 5;
		}
		 .resbox{
		 	display:none;
			position: fixed;
			top: 90px;
			bottom: 0px;
			left: 0px;
			right: 0px;
			padding: 10px;
			background-color: #fff;
			z-index: 999;
			overflow: auto;
			display: none;
		}
		.resbox-hd{
			height: 40px;
			line-height: 40px;
			border-bottom: 1px solid #eee;
			font-size: 18px;
		}
		.resbox-hd .close{
			float: right;
			display: block;
			color: red;
		}
		.reslist-item{
			line-height: 30px;
			border-bottom: 1px solid #eee;
			font-size: 16px;
			cursor: pointer;
		}
		.search-box .text{
			width: 200px;
			margin-right: 10px;
		}
		.search-box .bt{
			line-height: 36px;
			background-color: #0088cc;
			text-align: center;
			color: #fff;
			height: 36px;
			width: 80px;
			border-radius: 10px;
		}
		.fold-toggle{
			cursor: pointer;
			display: block;
			position: absolute;
			right: 0px;
			top: 0px;
			width: 45px;
			height: 45px;
			background: url(<?php echo $this->_var['skins']; ?>img/fold.png) no-repeat 20px 13px ;
			z-index: 10;
		}
		.fold-toggle.active{
			background: url(<?php echo $this->_var['skins']; ?>img/unfold.png) no-repeat 20px 13px;
		}
		.fold-right{
			cursor: pointer;
			display: block;
			position: absolute;
			right: 0px;
			top: 12px;
			width: 20px;
			height: 20px;
			background: url(<?php echo $this->_var['skins']; ?>img/right.png) no-repeat 100%;
			z-index: 10;
		}
		.menulist  .aitem.close{
			height: 45px;
			overflow: hidden;
		}
		.menulist  .bitem.close{
			height: 42px;
			overflow: hidden;
		}
		.ueditor-content{
			font-size: 16px;
			padding: 0px 10px;
			word-break: break-all;
		}
		.ueditor-content img{
			max-width: 100%;
		}
		.page-show-title{
			margin-bottom: 10px;
			font-size: 16px;
			font-weight: 600;
			color: #333;
			padding: 0px 5px;
		}
		.audio{
			display: block;
			clear: both;
			margin-bottom: 10px;
		}
		.video{
			clear: both;
		}
	</style>
 
	<body>
		<div style="position: fixed; top: -5000px;">
			<img src="<?php echo images_site($this->_var['book']['imgurl']); ?>"  />
		</div>
		<div class="resbox" >
			<div class="resbox-hd">搜索结果
			<a class="close" id="resbox-close" href="javascript:;">关闭</a>
			</div>
			<div id="reslist" class="reslist"></div>
		</div>
		<div id="page-index" class="page-index">
			<div id="top" class="topbox">
				<a class="back" href="/module.php?m=book"><i class="iconfont icon-back"></i></a>
				<div class="title"><?php echo $this->_var['book']['title']; ?></div>		 
			</div>
			<div class="search-box">
					<input type="text" id="searchWord" class="text" /><div id="searchSubmit" class="bt">搜索</div>
			</div>
			<div id="leftbox" class="menulist">
					 
				<?php $_from = $this->_var['artlist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'a');if (count($_from)):
    foreach ($_from AS $this->_var['a']):
?>
					<div class="aitem close" id="aitem<?php echo $this->_var['a']['id']; ?>" >
						<?php if (! $this->_var['a']['child']): ?>
						<div class="fold-right"></div>
						<?php else: ?>
						<div class="fold-toggle fold-toggle-a "></div>
						<?php endif; ?>
						<a href="/module.php?m=book_article&a=show&bookid=<?php echo $this->_var['book']['bookid']; ?>&id=<?php echo $this->_var['a']['id']; ?>" class="atitle js-go" vid="<?php echo $this->_var['a']['id']; ?>" ><?php echo $this->_var['a']['title']; ?></a>
						<?php if ($this->_var['a']['child']): ?>
							<?php $_from = $this->_var['a']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'b');if (count($_from)):
    foreach ($_from AS $this->_var['b']):
?>
							<div class="bitem close" id="bitem<?php echo $this->_var['b']['id']; ?>" >
								<?php if (! $this->_var['b']['child']): ?>
								<div class="fold-right"></div>
								<?php else: ?>
								<div class="fold-toggle fold-toggle-b"></div>
								<?php endif; ?>
								<a href="/module.php?m=book_article&a=show&bookid=<?php echo $this->_var['book']['bookid']; ?>&id=<?php echo $this->_var['b']['id']; ?>" class="btitle js-go" vid="<?php echo $this->_var['b']['id']; ?>" ><?php echo $this->_var['b']['title']; ?></a>
								<?php if ($this->_var['b']['child']): ?>
									<?php $_from = $this->_var['b']['child']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
									<a href="/module.php?m=book_article&a=show&bookid=<?php echo $this->_var['book']['bookid']; ?>&id=<?php echo $this->_var['c']['id']; ?>" id="citem<?php echo $this->_var['c']['id']; ?>" class="citem js-go" vid="<?php echo $this->_var['c']['id']; ?>"  ><?php echo $this->_var['c']['title']; ?>
									<div class="fold-right"></div>
									</a>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								<?php endif; ?>
								</div>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						<?php endif; ?>
					</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		</div>		
		<div id="page-show" class="page-show" >
			<div class="hd">
				详情
				<div id="page-show-close" class="page-show-close">关闭</div>
			</div>
			<div id="page-show-title" class="page-show-title"><?php echo $this->_var['book']['title']; ?></div>
			<div id="mediaBox">
				
			</div>
			<div id="page-show-frame" class="ueditor-content">
				<?php echo $this->_var['book']['content']; ?>
				
			</div>
		</div>
			<script type="text/javascript" charset="utf-8" src="/plugin/ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
<link rel="stylesheet" type="text/css" href="/plugin/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css"/>
		<script>
			var bookTitle="<?php echo $this->_var['book']['title']; ?>";
			function getShow(id){
				var id=id;
				$.get("/module.php?m=book_article&a=view&ajax=1&id="+id,function(data){
					if(data.error){
						skyToast(data.message);
						return false;
					}
					$("#page-show-frame").html(data.data.data.content);					 
					$("#page-show-title").html(data.data.data.title);
					$("title").html(bookTitle+data.data.data.title);
					var d=data.data.data;
					var mds="";
					if(d.mp3url!=""){
						mds+='<audio class="audio" controls="" src="'+d.mp3url+'"></audio>';
					}
					if(d.mp4url!=""){
						mds+='<video class="video" controls="" src="'+d.mp4url+'"></video>';
					}
					$("#mediaBox").html(mds);
					$("#page-show").show();
					$("#page-index").hide();
					window.history.pushState(null, null, "http://www.deitui.com/module.php?m=book&a=view&bookid=<?php echo $this->_var['book']['bookid']; ?>&vid="+id);
					SyntaxHighlighter.highlight();
					$.get("/module.php?m=book_article&a=addClick&id="+id);
				},"json")
			}
			$(document).on("click","#page-show-close",function(){
				$("#page-show").hide();
				$("#page-index").show();
				$("title").html(bookTitle);
			})
			$(document).on("click",".js-go",function(event){
				event.preventDefault();
				var id=$(this).attr("vid");
				$(".js-go").removeClass("active");
				$(this).addClass("active");
				getShow(id);
			})
			
			$(document).on("click","#searchSubmit",function(){
				var word=$("#searchWord").val();
				var bookid="<?php echo $this->_var['book']['bookid']; ?>";
				$.get("/module.php?m=book_article&a=search&ajax=1",{
					bookid:bookid,
					word:word
				},function(data){
					if(data.error){
						skyToast(data.message);
					}else{
						var html='';
						var sdata=data.data.data;
						for(var i=0;i<sdata.length;i++){
							html+='<div class="reslist-item" vid="'+sdata[i].id+'">'+sdata[i].title+'</div>';
						}
						$(".resbox").show();
						$(".reslist").html(html);
					}
				},"json")
			})
			
			$(document).on("click",".reslist-item",function(){
				var id=$(this).attr("vid");
				$(".resbox").hide();
				$(".js-go").removeClass("active");
				$(".js-go[vid='"+id+"']").addClass("active");
				getShow(id);
			})
			$(document).on("click","#resbox-close",function(){
				$(".resbox").hide();
			});
			$(document).on("click",".fold-toggle-a",function(){
				$(this).toggleClass("active");
				$(this).parents(".aitem").toggleClass("close");
			})
			$(document).on("click",".fold-toggle-b",function(){
				$(this).toggleClass("active");
				$(this).parents(".bitem").toggleClass("close");
			})
		</script>
		<?php if (get ( 'vid' )): ?>
		<script>
			
				var id="<?php echo intval($_GET['vid']); ?>";
				$(".js-go").removeClass("active");
				$(".js-go[vid='"+id+"']").addClass("active");
				getShow(id);
			
		</script>
		<?php endif; ?>

<script language="javascript">
SyntaxHighlighter.highlight();
</script>		
	</body>
</html>
