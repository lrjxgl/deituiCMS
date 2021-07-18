<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body class="bg-ef">
		<div class="tabs-border">
			<div class="item active">产品列表</div>
		</div>
		 
		<div class="main-body" id="app">
			 
			<div style="display: none;" :class="'flex-col'" class="sglist">
				 
				<div v-for="(item,index) in list" :key="index"  class="sglist-item">
					
					<div @click="goDetail(item.productid)" class="sglist-title flex" v-html="item.content"></div>
					<div @click="goDetail(item.productid)" class="sglist-imglist">
						 
						<img v-for="(img,imgIndex) in item.imgslist" :key="imgIndex" :src="img+'.100x100.jpg'" class="sglist-imglist-img" />
						
					</div>
					<div class="flex flex-ai-center mgb-10">
						<div class="mgr-5 cl2">租金</div>
						<div class="cl-money mgr-5">￥{{item.money}}</div>
						<div class="cl2">/天</div>
						<div class="flex-1"></div> 
						<div class="cl2 f12 mgr-5">{{item.brand_title}}</div>
						
						
						 
						
					</div>
					<div class="sglist-ft">
						 
						<div class="flex">
							<div>推荐</div>
							<div  :class="item.isrecommend?'yes':'no'" @click="toggleRecommend(item)" ></div>
						</div>
						<div class="sglist-ft-cm">{{item.comment_num}}</div>
						<div class="sglist-ft-view">{{item.view_num}}</div>
						<div @click="del(item.productid)" class="flex-1 cl-danger iconfont pointer icon-delete"></div>
						<div @click="edit(item.productid)" class="pointer cl-primary">编辑</div>
					</div>
					
				</div>
				<div class="loadMore" v-if="per_page>0" @click="getList">加载更多</div>
			</div>
			
		</div>
		 
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			var type="<?php echo $this->_var['type']; ?>"
		</script>
		<script src="<?php echo $this->_var['skins']; ?>car_zuche/index.js?v=34"></script>
	</body>
</html>
