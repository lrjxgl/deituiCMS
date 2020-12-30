<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
<div class="header">
	<div class="header-back"></div>
	<div class="header-title">优惠券</div>
</div>
<div class="header-row"></div>
<div class="main-body none" :class="'flex-col'" id="App">
    <div class="list">
		<div class="row-box mgb-5" v-for="(item,index) in pageData.list" :key="index">
			<div class="flex mgb-5">
				<div class="cl-primary">{{item.title}}</div>
			</div>
			<div class="cl2 f12 mgb-5">
				金额 {{item.money}}元
				&nbsp;&nbsp;
				领取 {{item.get_num}} 人
				&nbsp;&nbsp;
				使用 {{item.use_num}} 人
			</div>
			<div class="flex flex-ai-center">
				<div class="cl3 f12">截止：{{item.etime}}</div>
				<div class="flex-1"></div>
				<div class="btn-small mgr-10" @click="getCoupon(item.id)" >领取</div>
				
			</div>
		</div>
	</div>

    
</div>
<?php echo $this->fetch('footer.html'); ?>
<script src="/plugin/vue/vue.min.js"></script>
<script src="<?php echo $this->_var['skins']; ?>coupon/index.js"></script>
</body>
</html>