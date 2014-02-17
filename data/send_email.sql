
CREATE DATABASE `test`;

USE `test`;

/*用户表*/

DROP TABLE IF EXISTS `czs_customer`;

CREATE TABLE `czs_customer` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态：0：默认；1：非活跃(黑名单)',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*每天发送邮件计数表*/

DROP TABLE IF EXISTS `czs_email_num`;

CREATE TABLE `czs_email_num` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `num` int(10) NOT NULL DEFAULT '0' COMMENT '发送数量',
  `send_day` date NOT NULL COMMENT '发送日期',
  PRIMARY KEY (`id`),
  KEY `send_day` (`send_day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*邮件发送表*/

DROP TABLE IF EXISTS `czs_email_sendlist`;

CREATE TABLE `czs_email_sendlist` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL COMMENT '用户uid',
  `email` varchar(100) NOT NULL COMMENT '邮箱地址',
  `email_title` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱标题',
  `email_content` text NOT NULL COMMENT '邮箱内容',
  `error` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发送成功：0成功发送；1发送失败',
  `will_send_time` int(10) NOT NULL COMMENT '预备发送时间',
  `send_time` int(10) NOT NULL COMMENT '真实发送时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '发送状态：1未发送；2已经发送',
  `priority` int(5) NOT NULL DEFAULT '0' COMMENT '优先级，值越大，最先被发送',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮件是否被用户点击',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

