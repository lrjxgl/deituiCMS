<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-title">找人</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body" id="App">
			<div v-if="Object.keys(list).length==0" class="emptyData">暂无</div>
			<div v-for="(item,index) in list" :key="index" class="row-box flex mgb-5">
				<img @click="goUser(item.userid)" class="wh-60 mgr-5" :src="item.user_head+'.100x100.jpg'" />
				<div class="flex-1">
					<div @click="goUser(item.userid)" class="mgb-5">{{item.nickname}}</div>
					<div class="flex">
						<div class="mgr-5">关注</div>
						<div class="mgr-5 cl-num">{{item.follow_num}}</div>
						<div class="mgr-5">粉丝</div>
						<div class="cl-num">{{item.followed_num}}</div>
					</div>
				</div>
				<div>
					<div v-if="item.isfollow" @click="followToggle(item)" class="btn-mini">取消关注</div>
					<div v-else @click="followToggle(item)" class="btn-mini">关注</div>
				</div>
			</div>
			<div @click="getList" v-if="per_page>0" class="loadMore">加载更多</div>
		</div>
		<?php $this->assign('ftnav','people'); ?>
		<?php echo $this->fetch('ftnav.html'); ?>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="<?php echo $this->_var['skins']; ?>sblog_people/index.js"></script>
	</body>
</html>
