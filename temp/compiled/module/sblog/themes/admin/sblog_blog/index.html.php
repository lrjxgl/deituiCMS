<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body class="bg-ef">

		<div id="app">
			<div class="tabs-border mgb-5">

				<div @click="setType('')" :class="{'tabs-border-active':type==''}" class="tabs-border-item">最新</div>
				<div @click="setType('recommend')" :class="{'tabs-border-active':type=='recommend'}" class="tabs-border-item">推荐</div>
				<div @click="setType('hot')" :class="{'tabs-border-active':type=='hot'}" class="tabs-border-item">热门</div>
			</div>
			<div class="main-body">
				<form class="search-form">
					关键字：<input type="text" v-model="keyword" :value="keyword" class="w100" />
					<div @click="search" class="btn-small">搜一下</div>
				</form>
				<div style="display: none;" :class="'flex-col'" class="sglist">

					<div v-for="(item,index) in list" :key="index" class="sglist-item">

						<div @click="goBlog(item.id)" class="sglist-title">{{item.content}}</div>
						<div @click="goBlog(item.id)" class="sglist-imglist">

							<img v-for="(img,imgIndex) in item.imgslist" :key="imgIndex" :src="img+'.100x100.jpg'" class="sglist-imglist-img" />

						</div>
						<div class="sglist-ft">
							<div class="cl-money pointer" @click="addGold(item)">奖金{{item.gold}}</div>
							<div class="sglist-ft-love">{{item.love_num}}</div>
							<div class="sglist-ft-cm">{{item.comment_num}}</div>
							<div class="sglist-ft-view">{{item.view_num}}</div>
							<div class="flex-1"></div>
							<div :class="item.isrecommend==1?'yes':'no'" class="js-toggle-status mgr-10" :url="'/moduleadmin.php?m=sblog_blog&a=recommend&ajax=1&id='+item.id">推荐&nbsp;</div>
							<div :class="item.status==1?'yes':'no'" class="js-toggle-status mgr-10" :url="'/moduleadmin.php?m=sblog_blog&a=status&ajax=1&id='+item.id">显示&nbsp;</div>
							<div @click="del(item.id)" class="flex-1 cl-danger iconfont pointer icon-delete"></div>
						</div>

					</div>

				</div>
			</div>
			<div class="modal-group" :class="{'flex-col':goldModalShow}">
				<div class="modal-mask" @click="hideGoldModal"></div>
				<div class="modal">
					<div class="modal-header">
					<div class="modal-title">追加金币</div>
					</div>
					<div class="input-flex">
						<div class="input-flex-label">金币</div>
						<input type="text" v-model="sendGoldNum" class="input-flex-text" />
					</div>
					<div @click="sendGold" class="btn-row-submit">发放奖励</div>
				</div>
			</div> 
		</div>

		<?php echo $this->fetch('footer.html'); ?>
		<style>
			.modal-body {
				max-height: 500px;
			}
		</style>
		<script>
			var type = "<?php echo $this->_var['type']; ?>";
		</script>
		<script src="/plugin/vue/vue.min.js"></script>
		<script src="/plugin/jquery/listload.js"></script>
		<script src="<?php echo $this->_var['skins']; ?>sblog_blog/index.js?cc"></script>

		<script>
			listload.showload(function() {
				App.getList();
			})
		</script>
	</body>
</html>
