<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<link href="<?php echo $this->_var['skins']; ?>home/index.css" rel="stylesheet" />
	<body >
		<div url="/module.php?m=forum" class="header-back-fixed goBack" style="z-index: 999; color: #fff;"></div>
		<div class="main-body"  id="App">
			 
			<template v-if="pageLoad" >
			<div class="uBox">
				<div @click="toggleFollow(user)" v-if="user.isFollow" class="fixFollow fixFollow-active">已关注</div>
				<div @click="toggleFollow(user)" v-else class="fixFollow fixFollow-active">+关注</div>
				<div class="flex flex-center">
					<img class="uBox-head" :src="user.user_head+'.100x100.jpg'"> 
				</div>
				<div class="flex flex-center">
					<div class="uBox-nick">{{user.nickname}}</div>
				</div>
				<div class="flex mgb-10 flex-center">
					<div class="mgr-5 cl-white">粉丝</div>
					<div class="mgr-10  cl-white">{{user.followed_num}}</div> 
					<div class="mgr-5  cl-white">关注</div>
					<div class="cl-white">{{user.follow_num}}</div>
					<div class="btn-pm none  cl-white" @click="goPm(user.userid)">私信</div>
				</div>
				<div v-if="user.description==''" class="uBox-desc">该用户一句话也没留下</div>
				<div v-else class="uBox-desc">{{user.description}}</div>
			</div>
			<div class="emptyData" v-if="!list || Object.keys(list).length==0">暂无帖子</div>
			<div v-for="(item,index) in list" :key="index" @click="goBlog(item.id)" class="sglist-item">
				<div class="sglist-title">{{item.title}}</div>
				<div class="sglist-desc">{{item.description}}</div>
				<div v-if="item.imgslist" class="sglist-imglist">
					 
					<img v-for="(cc,ii) in item.imgslist" :key="ii" :src="cc+'.100x100.jpg'" class="sglist-imglist-img" />
					 
				</div>
				<div class="sglist-ft">
					<div class="sglist-ft-love">{{item.love_num}}</div>
					<div class="sglist-ft-cm">{{item.comment_num}}</div>
					<div class="sglist-ft-div">{{item.view_num}}</div>
				</div> 
			</div>
			</template>
		</div>
		 
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			var  userid="<?php echo $this->_var['user']['userid']; ?>"
		</script>
		<script src="/plugin/vue/vue.min.js"></script>
		<script src="<?php echo $this->_var['skins']; ?>home/index.js"></script>
	</body>
</html>
