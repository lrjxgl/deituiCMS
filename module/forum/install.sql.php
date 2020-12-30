<?php
$content=<<<eof
CREATE TABLE `sky_mod_forum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `gid` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `love_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `fav_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `forward_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `keywords` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comment_num` int(11) unsigned NOT NULL DEFAULT '0',
  `imgurl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `last_time` int(11) unsigned NOT NULL DEFAULT '0',
  `grade` int(11) unsigned NOT NULL DEFAULT '0',
  `isrecommend` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `view_num` int(11) unsigned NOT NULL DEFAULT '0',
  `isnew` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `tags` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `videourl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `money` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `gold` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '奖励',
  `imgsdata` text CHARACTER SET utf8,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`catid`,`id`) USING BTREE,
  KEY `gid` (`gid`) USING BTREE,
  KEY `uid_id` (`userid`,`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_forum_category` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '描述',
  `orderindex` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `imgurl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`catid`),
  KEY `gid` (`gid`,`orderindex`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='论坛分类';
CREATE TABLE `sky_mod_forum_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `objectid` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级评论',
  `createtime` datetime NOT NULL DEFAULT '2018-07-02 18:52:01',
  `content` text CHARACTER SET utf8,
  `ip` varchar(32) CHARACTER SET utf8 NOT NULL,
  `ip_city` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `objectid` (`objectid`,`status`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='帖子评论';
CREATE TABLE `sky_mod_forum_data` (
  `id` bigint(20) NOT NULL,
  `content` mediumtext CHARACTER SET utf8 NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
CREATE TABLE `sky_mod_forum_feeds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `objectid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `fuserid` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`objectid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='帖子-订阅';
CREATE TABLE `sky_mod_forum_group` (
  `gid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `imgurl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '图片',
  `description` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '描述',
  `orderindex` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `topic_num` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_num` int(10) unsigned NOT NULL DEFAULT '0',
  `view_num` int(10) unsigned NOT NULL DEFAULT '0',
  `isrecommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='板块';
CREATE TABLE `sky_mod_forum_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `objectid` int(10) unsigned NOT NULL DEFAULT '0',
  `shopid` int(10) unsigned DEFAULT '0',
  `orderindex` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL DEFAULT '2018-06-10 10:05:01',
  `imgurl` varchar(225) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `object_id` (`objectid`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='帖子图片';
CREATE TABLE `sky_mod_forum_tags` (
  `tagid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `total_num` int(10) unsigned NOT NULL DEFAULT '0',
  `view_num` int(10) unsigned NOT NULL DEFAULT '0',
  `gkey` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `gnum` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='标签';
CREATE TABLE `sky_mod_forum_tags_index` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagid` int(10) unsigned NOT NULL DEFAULT '0',
  `objectid` int(10) unsigned NOT NULL DEFAULT '0',
  `orderindex` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tagid` (`tagid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='标签数据';

eof;
?>