<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">我的邀请</div>
		</div>
		<div class="header-row"></div>
		<style>
			.stat{
				display: flex;
				flex-direction: row;
				line-height: 40px;
				margin-bottom: 10px;
				font-size: 14px;
				border-bottom: 1px solid #eee;
			}
			.stat-item{
				flex-direction: row;
				flex: 1;
			}
			.stat-n{
				padding: 0px 3px;
				color: #f60;
				font-size: 16px;
			}
			.row-box .hd{
				font-size: 16px;
				color: #333;
				margin-bottom: 5px;
			}
			.row-box .con{
				font-size: 14px;
				color: #555;
				padding-left: 10px;
				margin-bottom: 5px;
			}
			.row-box img{
				text-align: center;
			}
			.invitelist{
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
			}
			.invitelist:after{
				clear: both;
				display: block;
				content: ".";
				visibility: hidden;
				height: 0;
			}
			.invitelist-item{
				float: left;
				width: 25%;
				text-align: center;
			}
			.invitelist-img{
				width: 60px;
				display: block;
				margin: 0 auto;
			}
			.invitelist-nick{
				font-size: 12px;
				color: #444;
			}
		</style>
		<div class="main-body">
			<div class="row-box">
			    <div class="stat">
			    		<div class="stat-item">邀请 <span class="stat-n"><?php echo $this->_var['rscount']; ?></span>人</div>
			    		<div gourl="/index.php?m=invite_account_log" class="stat-item">总收益  <span class="stat-n"><?php echo $this->_var['iaccount']['income']; ?></span> 元</div>
			    		<div class="stat-item">余额 <span class="stat-n"><?php echo $this->_var['iaccount']['money']; ?></span> </div>
			    </div>
			    <div class="hd">邀请奖励</div>
			    <div class="con">
			    	<div>1.邀请一个用户奖励1元购物币，购物币可以在商城购买产品</div>
			    	<div>2.另外还可以获得邀请用户销售额1%的奖励</div>
			    </div>
			    <div class="hd">邀请方法</div>
			    <div class="con">
			    	<div> 
			    		
			    		1.保存二维码 将二维码分享给朋友 
			    		<br />
			    		<img class="w300" src="/index.php?m=invite&a=ewm"  />
			    	</div>
			    	<div>
			    		2.在微信可以直接分享当前页面给好友
			    	</div>
			    	
			    	
			    	
			    	 
			    </div>
		    </div>
		    
		    <div class="row-box">
		    	<div class="hd">邀请列表</div>
		    	<div class="invitelist">
		    		<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
		    		<div class="invitelist-item">
		    			<img class="invitelist-img" src="<?php echo $this->_var['c']['user_head']; ?>.100x100.jpg"  />
		    			<div class="invitelist-nick"><?php echo $this->_var['c']['nickname']; ?></div>
		    		</div>
		    		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		    	</div>
		    </div>
		    
		</div>
<?php echo $this->fetch('footer.html'); ?>

<?php wx_jssdk();?>
<script>
	wxshare_title="知福鼎上福鼎生活网，福鼎生活网打造一站式综合服务平台。";
	wxshare_link="http://www.fd175.com/?invite_uid=<?php echo $this->_var['userid']; ?>";
	
</script>		
	</body>
</html>
