/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-30 11:21:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_content_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content_type`;
CREATE TABLE `yunzhi_content_type` (
  `name` varchar(40) NOT NULL,
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk 菜单。用于被区块调用后，生成LCURD的信息。',
  `pname` varchar(40) NOT NULL COMMENT '上级name',
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '描述',
  `weight` smallint(6) NOT NULL DEFAULT '0' COMMENT '权重',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `fileds` varchar(255) NOT NULL DEFAULT '[]' COMMENT '字段',
  `is_delete` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='类别(文章类型)表';

-- ----------------------------
-- Records of yunzhi_content_type
-- ----------------------------
INSERT INTO `yunzhi_content_type` VALUES ('news', '3', '', '新闻通知', '新闻通知', '0', '0', '[]', '0');
INSERT INTO `yunzhi_content_type` VALUES ('products', '2', '', '产品列表', '', '0', '0', '[]', '0');
