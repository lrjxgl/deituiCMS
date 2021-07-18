<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<link href="/plugin/swiper/css/swiper.min.css" rel="stylesheet" />
	<link href="<?php echo $this->_var['skins']; ?>index.css" rel="stylesheet" />
	<body>
		<div class="header">
			<img src="<?php echo $this->_var['site']['logo']; ?>" class="header-logo" />
			<div class="header-title">好友圈</div>
			 
		</div>
		<div class="header-row"></div>
		<div class="main-body">
		<?php if ($this->_var['flashList']): ?>
		<div style="width: 100%;" class="swiper-container" id="indexFlash">
			<div class="swiper-wrapper" >
				<?php $_from = $this->_var['flashList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				<div class="swiper-slide">
					<img class="wmax" src="<?php echo $this->_var['c']['imgurl']; ?>" />
				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			 
			<div class="swiper-pagination"></div>
		 
		</div>
		<?php endif; ?>
		<?php if ($this->_var['navList']): ?>
		<div class="m-navPic">
		    <?php $_from = $this->_var['navList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		    <a href="<?php echo $this->_var['c']['link_url']; ?>" class="m-navPic-item">
				  <img class="m-navPic-img" src="<?php echo images_site($this->_var['c']['logo']); ?>" />
				  <div class="m-navPic-title"><?php echo $this->_var['c']['title']; ?></div>				   
		    </a>		
		    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		<?php endif; ?>
		<?php if ($this->_var['adList']): ?>
		<div class="adBox">
			<?php $_from = $this->_var['adList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<div class="adBox-item">
				<img gourl="<?php echo $this->_var['c']['link1']; ?>" src="<?php echo $this->_var['c']['imgurl']; ?>" class="adBox-img" />
			</div>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					 
		</div>
		<?php endif; ?>
		</div>
		<div id="tabAA"></div>
		<div class="main-body none" :class="'flex-col'"  id="app">
			
			<div id="tabBox" class="tabs-border mgb-5">
				<div @click="setType('')" :class="{'tabs-border-active':type==''}" class="tabs-border-item">关注</div>
				<div @click="setType('recommend')" :class="{'tabs-border-active':type=='recommend'}" class="tabs-border-item">推荐</div>
				<div @click="setType('new')" :class="{'tabs-border-active':type=='new'}" class="tabs-border-item">最新</div>
				<div @click="setType('topic')" :class="{'tabs-border-active':type=='topic'}"  class="tabs-border-item">话题</div>
				
			</div>
			
			<div v-if="page=='blog'" style="display: none;" :class="'flex-col'" class="sglist">
				 
				<div v-for="(item,index) in pageData.list" :key="index" @click="goBlog(item.id)" class="sglist-item">
					<div class="flex mgb-5">
						<img :src="item.user.user_head+'.100x100.jpg'" class="wh-40 bd-radius-50" />
						<div class="flex-1 mgl-5">
							<div class="f14 fw-600 mgb-5">{{item.user.nickname}}</div>
							<div class="flex">
								<div class="f12 cl3">{{item.timeago}}</div>
								
							</div>
						</div>
						 
					</div>
					<div class="sglist-title block" v-html="item.parsecontent"></div>
					<div class="sglist-imglist">
						 
						<img v-for="(img,imgIndex) in item.imgslist" :key="imgIndex" :src="img+'.100x100.jpg'" class="sglist-imglist-img" />
						
					</div>
					<div class="sglist-ft">
						<div class="sglist-ft-love">{{item.love_num}}</div>
						<div class="sglist-ft-cm">{{item.comment_num}}</div>
						<div class="sglist-ft-view">{{item.view_num}}</div>
					</div> 
				</div>
				<div @click="getList" v-if="per_page>0" class="loadMore">点我加载更多...</div>
			</div>
			<div  v-if="page=='topic'" class="blogList">
				<div @click="goTopic(item.title)" class="blogList-item" v-for="(item,index) in pageData.topicList" :key="index">{{item.title}}</div>
				
			</div>
		</div>
		<a href="/module.php?m=sblog_blog&a=add" class="fixedAdd">发布</a>
		<div class="flex-center pd-10">
			<a class="f12 cl3" href="http://www.beian.miit.gov.cn"><?php echo $this->_var['site']['icp']; ?></a>
		</div> 
		<?php $this->assign('ftnav','index'); ?>
		<?php echo $this->fetch('ftnav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			$(document).on("click","#search-btn",function(){
				var word=$("#search-word").val();
				window.location="/module.php?m=sblog_blog&a=search&keyword="+encodeURI(word)
			})
		</script>
		<script src="/plugin/swiper/js/swiper.min.js"></script>
		<script>
			$(function(){
				 
				var flash=new Swiper("#indexFlash");
				 $(window).scroll(function(e){
					 var ex=$("#tabAA").offset().top;
					 var st=$(window).scrollTop()+60;
					 console.log(st,ex);
					 if(st>ex){
						 $("#tabBox").addClass("tabFixed")
					 }else{
						  $("#tabBox").removeClass("tabFixed")
					 }
					 
				 })
			})
			
		</script>
		 
		<script src="<?php echo $this->_var['skins']; ?>index.js"></script>
		<?php wx_jssdk();?> 
	</body>
</html>
