/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-30 11:20:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_content`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content`;
CREATE TABLE `yunzhi_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 用户名',
  `content_type_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 类别名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(5) unsigned NOT NULL DEFAULT '0',
  `is_freezed` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否冻结',
  `weight` smallint(6) NOT NULL,
  `hit` int(11) NOT NULL,
  `is_delete` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_name` (`content_type_name`) USING BTREE,
  KEY `is_freezed` (`is_freezed`) USING BTREE,
  KEY `is_deleted` (`is_delete`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=271 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of yunzhi_content
-- ----------------------------
INSERT INTO `yunzhi_content` VALUES ('1', '', 'news', '这是一条新闻', '1232323111', '1472446015', '0', '0', '0', '442', '0');
INSERT INTO `yunzhi_content` VALUES ('2', '', 'news', '这是另一条新闻', '1232323111', '1472446019', '0', '0', '0', '142', '0');
INSERT INTO `yunzhi_content` VALUES ('3', '', 'products', ' 这是一个产品的新闻', '0', '1472446012', '0', '0', '0', '43', '0');
