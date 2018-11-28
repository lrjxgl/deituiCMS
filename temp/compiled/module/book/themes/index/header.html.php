<style>
	.fly-header .fly-nav a {
     padding: 0 20px;
     font-size: 16px; 
}
</style>
<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="/">
      <img src="/static/logo.png" height="37" alt="得推网">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
    	<li class="layui-nav-item <?php if ($this->_var['nav'] == 'index'): ?>layui-this<?php endif; ?>">
        <a href="/">首页</a>
      </li>
      
      <li class="layui-nav-item">
        <a href="/module.php?m=ask">交流</a>
      </li>
     <li class="layui-nav-item">
        <a href="/module.php?m=down">应用中心</a>
      </li>
			<li class="layui-nav-item  <?php if ($this->_var['navbar'] == 'anli'): ?>layui-this<?php endif; ?>">
				<a href="/index.php?m=anli">案例</a>
			</li>
      <li class="layui-nav-item layui-this">
        <a href="/module.php?m=book">图书</a>
      </li>
      <li class="layui-nav-item">
      	<a href="/module.php?m=gold">金币</a>
      </li>
      <li class="layui-nav-item">
        <a href="/module.php?m=sysq">商业授权</a>
      </li>
      <li class="layui-nav-item">
        <a href="/module.php?m=csg">众包</a>
      </li>
      <li class="layui-nav-item">
        <a href="http://weizhan.deitui.com">微站云</a>
      </li>
     
      
    <span class="layui-nav-bar" style="left: 56.5px; top: 55px; width: 0px; opacity: 0;"></span></ul>
    
    <ul class="layui-nav fly-nav-user">
      
      <!-- 未登入的状态 -->
      <?php if ($this->_var['ssuser']): ?>
      
      <li class="layui-nav-item header-toggle">
          <a class="fly-nav-avatar" href="/index.php?m=user">
            <cite class="layui-hide-xs"><?php echo $this->_var['ssuser']['nickname']; ?></cite>
            
            <img src="<?php echo images_site($this->_var['ssuser']['user_head']); ?>.100x100.jpg">
          </a>
          <dl class="layui-nav-child layui-anim layui-anim-upbit">
            <dd><a href="/index.php?m=user&a=set"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
            <dd><a href="/index.php?m=notice&a=my"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
            <dd><a href="/index.php?m=home"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
            <hr style="margin: 5px 0;">
            <dd><a href="/index.php?m=login&a=logout" style="text-align: center;">退出</a></dd>
          </dl>
        </li>
      <?php else: ?>
      <li class="layui-nav-item">
        <a href="/index.php?m=login">登入</a>
      </li>
      <li class="layui-nav-item">
        <a href="/index.php?m=register">注册</a>
      </li>
      <?php endif; ?>
      
 
    <span class="layui-nav-bar" style="left: 24px; top: 55px; width: 0px; opacity: 0;"></span></ul>
  </div>
</div>
<style>
	.kf-box{
		position: fixed; top: 300px; right: 0px; background-color: #eee;
		padding: 10px;
		width: 20px;
		color: #444;
		cursor: pointer;
		z-index: 999;
	}
	.kf-box .tel{
		display: none;
	}
	.kf-box:hover{
		width: auto;
		
	}
	.kf-box:hover .hd{
		font-size: 20px;
		margin-bottom: 20px;
	}
	.kf-box:hover .tel{
		display: block;
		font-size: 18px;
	}
</style>
 <div class="kf-box">
 	<div class="hd">联系客服</div>
 	<div class="tel">
 		15985840591
 	</div>
 </div>