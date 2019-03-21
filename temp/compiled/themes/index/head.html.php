<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<?php if (! $this->_var['site']): ?>
<?php $this->assign("site",M("site")->get()); ?>
<?php endif; ?>
<title><?php if ($this->_var['seo']): ?><?php echo $this->_var['seo']['title']; ?><?php else: ?><?php echo $this->_var['site']['title']; ?><?php endif; ?></title>
<meta name="description" content="<?php if ($this->_var['seo']): ?><?php echo $this->_var['seo']['description']; ?><?php else: ?><?php echo $this->_var['site']['description']; ?><?php endif; ?>" />
	<link href="//at.alicdn.com/t/font_811242_4k6v9f174g7.css" rel="stylesheet">
<link href="/plugin/dt-ui/dt-ui-h5.css?v3" rel="stylesheet" />
<link href="<?php echo $this->_var['skins']; ?>css/app.css" rel="stylesheet" />
</head>

