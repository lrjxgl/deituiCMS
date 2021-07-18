<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="shd"><?php echo $this->_var['typename']; ?></div>
		<div class="main-body">
			<form autocomplete="off" class="search-form" action="/moduleadmin.php"> 
				<input type="hidden" name="m" value="b2b_order">
				<input type="hidden" name="type" value="<?php echo html($_GET['type']); ?>" />
				ID <input type="text"  class="w50" name="orderid" value="<?php echo intval($_GET['orderid']); ?>" />
				订单号 <input type="text" class="w150" name="orderno" value="<?php echo html($_GET['orderno']); ?>" />
				用户 <input type="text" name="nickname" class="w100" value="<?php echo html($_GET['nickname']); ?>" />	 
				 
				下单时间 <input name="stime" type="text" id="stime" value="<?php echo $_GET['stime']; ?>" class="w100" /> 到 <input  class="w100" type="text"  name="etime" id="etime"  value="<?php echo $_GET['etime']; ?>" /> 
				<button type="submit" class="btn" >搜索</button>
			</form>
			<div class="bg-ef">
			<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
			<div class="row-box mgb-10" v-for="(item,index) in list" :key="index">
					<div class="flex bd-mp-5">
						<?php if ($this->_var['item']['ispin'] == 1): ?>
						<div class="mgr-5">
							<div class="btn-mini btn-outline-primary ">拼</div>
						</div>
						<?php endif; ?>
						<div class="flex-1 cl2">订单号：<?php echo $this->_var['item']['orderno']; ?></div>
						
						<div class="cl-primary"><?php echo $this->_var['item']['status_name']; ?></div>
					</div>
					<div class="flex flex-wrap">
					<?php $_from = $this->_var['item']['prolist']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'pro');if (count($_from)):
    foreach ($_from AS $this->_var['pro']):
?>
					<div class="flexlist-item" style="width: 20%; margin-right: 5px;">
						<img class="flexlist-img" src="<?php echo $this->_var['pro']['imgurl']; ?>.100x100.jpg">
						<div class="flex-1">
							<div class="flexlist-title"><?php echo $this->_var['pro']['title']; ?></div>
							<div class="flexlist-ks"><?php echo $this->_var['pro']['ks_title']; ?></div>
							<div class="flex ">
								<div class="flex-1 cl-money">￥<?php echo $this->_var['pro']['price']; ?></div>
								<div class="cl3">x <?php echo $this->_var['pro']['amount']; ?></div>
							</div>
							
						</div>
					</div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
					</div>
					<div class="flex mgb-5">
						 共<div class="cl-num"><?php echo $this->_var['item']['total_num']; ?></div>件商品  
						 订单金额：<div class="cl-money">￥<?php echo $this->_var['item']['money']; ?></div>元
						 
						 <div class="flex-1"></div> 
						 
					</div>
					 
					<div  class="flex flex-jc-end">
						<div class="cl3 f12"><?php echo $this->_var['item']['timeago']; ?></div>
						<div class="flex-1"></div>
						
						 
						<div class="btn-small  btn-outline-danger" gourl="/moduleadmin.php?m=b2b_order&a=show&orderid=<?php echo $this->_var['item']['orderid']; ?>">查看</div>
					</div>
					 
			</div>
					 
					  
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 
			 
			<div><?php echo $this->_var['pagelist']; ?></div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/laydate/laydate.js"></script>
		<script>
			laydate.render({
				elem:"#stime"
			})
			laydate.render({
				elem:"#etime"
			});
		</script>
	</body>
</html>
