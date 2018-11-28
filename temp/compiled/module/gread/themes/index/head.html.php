<head>
	<meta charset="UTF-8">
	<title><?php if ($this->_var['seo']): ?><?php echo $this->_var['seo']['title']; ?><?php else: ?>Gread<?php endif; ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<link href="/plugin/mui/css/mui.min.css" rel="stylesheet" />
	<link href="/plugin/mui_skyweb/skyweb.css?<?php echo time(); ?>" rel="stylesheet" />
	<link href="//at.alicdn.com/t/font_788644_g501yfj5dnv.css" rel="stylesheet"  />
	<link href="<?php echo $this->_var['skins']; ?>css/app.css?<?php echo time(); ?>" rel="stylesheet" />
	<script src="/plugin/jquery/jquery.js"></script>
	<script src="/plugin/mui_skyweb/skyweb.js"></script>
	<script src="/plugin/mui/js/mui.min.js"></script>
	<script>
		var IMAGES_SITE="<?php echo IMAGES_SITE; ?>";
	</script>
	<script src="<?php echo $this->_var['skins']; ?>js/app.js?<?php echo time(); ?>"></script>
	<script src="/static/js/notice.js" async="async"></script>
</head>