/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50505
 Source Host           : localhost
 Source Database       : english_study_0726

 Target Server Type    : MySQL
 Target Server Version : 50505
 File Encoding         : utf-8

 Date: 09/07/2016 07:58:17 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `english_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `english_attachment`;
CREATE TABLE `english_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '附件原文件名',
  `savename` varchar(100) NOT NULL DEFAULT '' COMMENT '附件存在服务器上的名字',
  `type` varchar(100) NOT NULL DEFAULT '0' COMMENT '附件类型',
  `source` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联记录ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) NOT NULL DEFAULT '0' COMMENT '附件大小',
  `savepath` varchar(40) NOT NULL DEFAULT '' COMMENT '上级目录',
  `sort` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `sha1` char(40) NOT NULL DEFAULT '',
  `md5` char(32) NOT NULL DEFAULT '',
  `ext` varchar(10) NOT NULL DEFAULT '' COMMENT '扩展名',
  PRIMARY KEY (`id`),
  KEY `idx_record_status` (`record_id`,`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12497 DEFAULT CHARSET=utf8 COMMENT='附件表';

SET FOREIGN_KEY_CHECKS = 1;
