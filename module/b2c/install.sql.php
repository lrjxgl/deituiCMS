<?php
$content=<<<eof
CREATE TABLE `sky_mod_b2c_brand` (
  `brandid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `orderindex` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `imgurl` varchar(225) NOT NULL DEFAULT '' COMMENT '图片',
  `description` varchar(225) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`brandid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='品牌';
CREATE TABLE `sky_mod_b2c_cart` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `createtime` datetime NOT NULL DEFAULT '2019-01-30 08:01:01' COMMENT '创建时间',
  `userid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `amount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单数量',
  `ksid` int(11) NOT NULL DEFAULT '0' COMMENT '款式',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`) USING BTREE,
  KEY `createtime` (`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_b2c_category` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `orderindex` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `imgurl` varchar(225) CHARACTER SET utf8 DEFAULT '',
  `description` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '描述',
  `ex_table_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展表',
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='分类';
CREATE TABLE `sky_mod_b2c_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shoptype` varchar(12) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '类型',
  `vipcard` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='配置';
CREATE TABLE `sky_mod_b2c_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '截止日期',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `get_num` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '领取人数',
  `use_num` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '使用人数',
  `lower_money` decimal(9,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '最低使用价格',
  `limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限制领取数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_b2c_coupon_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '领取时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '使用状态',
  `notice_time` int(11) NOT NULL DEFAULT '0' COMMENT '上次通知',
  `money` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `lower_money` decimal(9,2) DEFAULT '0.00' COMMENT '最低使用价格',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '截止日期',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='优惠券用户';
CREATE TABLE `sky_mod_b2c_group` (
  `gid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `gkey` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '标签',
  `gnum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '记录数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`),
  KEY `gkey` (`gkey`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='产品聚合';
CREATE TABLE `sky_mod_b2c_group_product` (
  `gpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(10) unsigned NOT NULL DEFAULT '0',
  `productid` int(10) unsigned NOT NULL DEFAULT '0',
  `orderindex` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gpid`),
  KEY `gid` (`gid`),
  KEY `productid` (`productid`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='产品聚合';
CREATE TABLE `sky_mod_b2c_order` (
  `orderid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单',
  `orderno` varchar(36) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '订单号',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `israty` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否评论 0否 1是',
  `ispay` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否支付 1是 ',
  `userid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `isreceived` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否接收 0 否 1是',
  `money` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单价格',
  `paymoney` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '在线支付金额',
  `vipmoney` decimal(13,2) NOT NULL DEFAULT '0.00' COMMENT '会员卡支付金额',
  `user_address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址',
  `express_no` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '物流号',
  `goods_money` decimal(15,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品价格',
  `express_money` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '快递价格',
  `discount_money` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣价格',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券',
  `coupon_money` decimal(13,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券价格',
  `comment` varchar(225) CHARACTER SET utf8 NOT NULL COMMENT '评论内容',
  `paytype` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '支付方式',
  `whocancel` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '谁取消的',
  `daySn` smallint(6) NOT NULL DEFAULT '0' COMMENT '每日订单排序',
  `total_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL DEFAULT '2017-07-02 12:43:01',
  `recharge_id` int(10) unsigned NOT NULL,
  `weight` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `ispin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pin_num` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数',
  `productid` int(10) unsigned NOT NULL DEFAULT '0',
  `pin_success` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '拼团成功',
  `pin_orderid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`orderid`),
  KEY `userid` (`userid`) USING BTREE,
  KEY `orderno` (`orderno`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单';
CREATE TABLE `sky_mod_b2c_order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `truename` char(8) CHARACTER SET utf8 DEFAULT NULL,
  `telephone` char(12) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `createtime` datetime NOT NULL DEFAULT '2017-07-02 12:43:01',
  `province_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(11) NOT NULL DEFAULT '0',
  `town_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_b2c_order_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL DEFAULT '2018-07-17 09:01:01',
  `updatetime` datetime NOT NULL DEFAULT '2018-07-17 09:01:01',
  `content` mediumtext CHARACTER SET utf8,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_b2c_order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createtime` datetime NOT NULL DEFAULT '2019-02-28 06:01:01',
  `orderid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `adminid` int(11) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_b2c_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `productid` int(11) NOT NULL DEFAULT '0',
  `price` decimal(13,2) NOT NULL DEFAULT '0.00',
  `amount` int(11) NOT NULL DEFAULT '1',
  `createtime` datetime NOT NULL DEFAULT '2017-07-02 12:44:41',
  `ksid` int(11) NOT NULL DEFAULT '0' COMMENT '款式id',
  `iscomment` tinyint(4) NOT NULL DEFAULT '0',
  `raty_grade` tinyint(4) NOT NULL DEFAULT '0',
  `content` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`) USING BTREE,
  KEY `productid` (`productid`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_b2c_order_raty` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单',
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `createtime` datetime NOT NULL DEFAULT '2019-02-28 10:01:01' COMMENT '创建时间',
  `raty_express` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '快递',
  `raty_service` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '服务',
  `raty_quality` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '质量',
  `content` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单评价';
CREATE TABLE `sky_mod_b2c_pintuan_item` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL DEFAULT '2019-06-25 03:28:01',
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发起者',
  `join_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数',
  `total_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `need_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '需要人数',
  PRIMARY KEY (`itemid`),
  KEY `productid` (`productid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='拼团团购';
CREATE TABLE `sky_mod_b2c_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `description` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '描述',
  `imgurl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '图片',
  `price` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1上架',
  `weight` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `createtime` datetime NOT NULL DEFAULT '2019-01-30 08:01:01' COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT '2019-01-30 08:01:01' COMMENT '更新时间',
  `ks_label_name` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '颜色' COMMENT '款式名称',
  `ks_label_size` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '尺寸' COMMENT '款式尺寸',
  `month_buy_num` int(10) unsigned NOT NULL DEFAULT '0',
  `videourl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `isnew` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '最新',
  `ishot` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `isrecommend` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `total_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `buy_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `view_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问数',
  `lower_price` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '促销价',
  `market_price` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `isksid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有款式',
  `pt_open` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '开启拼团',
  `pt_price` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '拼团价格',
  `pt_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最低人数',
  `ex_table_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展表',
  `ex_table_data_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '扩展表id',
  `fav_num` int(10) unsigned NOT NULL DEFAULT '0',
  `otype` varchar(12) NOT NULL DEFAULT '' COMMENT '类型 ispin isflash',
  `etime` int(10) unsigned NOT NULL DEFAULT '0',
  `stime` int(10) unsigned NOT NULL DEFAULT '0',
  `imgsdata` text,
  `brandid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `catid_status` (`catid`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='产品';
CREATE TABLE `sky_mod_b2c_product_data` (
  `id` int(10) unsigned NOT NULL,
  `content` mediumtext CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='产品';
CREATE TABLE `sky_mod_b2c_product_ks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) unsigned NOT NULL COMMENT '产品',
  `title` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `size` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '尺寸',
  `price` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `createtime` datetime NOT NULL DEFAULT '2019-01-30 08:01:01' COMMENT '创建时间',
  `total_num` int(11) NOT NULL DEFAULT '0',
  `buy_num` int(11) NOT NULL DEFAULT '0',
  `imgurl` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pt_price` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '拼团价格',
  PRIMARY KEY (`id`),
  KEY `productid` (`productid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

eof;
?>