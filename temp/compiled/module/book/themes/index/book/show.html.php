<!DOCTYPE html>
<html>
<?php echo $this->fetch('head.html'); ?>

<body>
<header class="mui-bar mui-bar-nav">
    <a href="/module.php?m=book" class="goBack mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">课程介绍</h1>
</header>
<style>
	.p-price{
		padding: 20px 6px;
		color: #666;
		font-size: 16px;
		line-height: 2;
	}
	.p-price .price{
		color: #f60;
		font-size: 18px;
	}
	.p-price .buy-btn{
	 
		margin-left: 10px;
		background-color: #5f98d2;
		color: #fff;
		display: inline-block;
		text-align: center;
		line-height: 30px;
		font-size: 14px;
		padding: 0px 10px;
		border-radius: 5px;
		cursor: pointer;
	}
</style>
<div class="mui-content bg-fff">
	<div class="mui-content-padded">
		<div class="pdetail-title"><?php echo $this->_var['data']['title']; ?></div>
		<div class="pdetail-desc">
			描述：<?php echo $this->_var['data']['description']; ?>
		</div>
		
		<div class="p-price">
			<?php if ($this->_var['data']['ispay']): ?>
			价格：<span class="price"><?php echo $this->_var['data']['money']; ?></span> 元
			<?php endif; ?>
			<?php if (! $this->_var['isbuy']): ?>
				<a href="JavaScript:;" class="js-buy buy-btn" bookid="<?php echo $this->_var['data']['bookid']; ?>">立即购买</a>
			<?php else: ?>
			<a class="buy-btn" target="_blank" href="/module.php?m=book&a=view&bookid=<?php echo $this->_var['data']['bookid']; ?>">去阅读</a>
			<?php endif; ?>
		</div>
		
		<div class="pdetail-content">
			<div class="pdetail-content-hd"><span class="bd">内容介绍</span> </div>
			<div class="d-content">
		    	<?php echo $this->_var['data']['content']; ?>
		    </div>
		</div> 
		
	</div>
    
</div>
<?php echo $this->fetch('footer.html'); ?>

<script>
	$(document).on("click",".js-buy",function(){
		var bookid=$(this).attr("bookid");
		$.post("/module.php?m=book_order&a=order&ajax=1",{
			bookid:bookid
		},function(data){
			mui.toast(data.message);
			if(data.error==1000){
				window.location='/index.php?m=login';
				return false;
			}
			if(data.error==0){
				if(data.data.action=='success'){
					window.location="/module.php?m=book&a=view&bookid="+bookid
				}else if(data.data.action=="pay"){
					window.location=data.data.payurl
				}
				
			}
		},"json")
	})
</script>
<?php wx_jssdk();?>
<script type="text/javascript">
	wxshare_title="<?php echo $this->_var['data']['title']; ?>";
	 
	 wxshare_imgUrl="<?php echo images_site($this->_var['data']['imgurl']); ?>.100x100.jpg";
</script>
</body>
</html>