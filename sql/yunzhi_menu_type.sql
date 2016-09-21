/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-09-21 13:38:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_menu_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_menu_type`;
CREATE TABLE `yunzhi_menu_type` (
  `name` varchar(40) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单类型表（主要为了可以使用区块进行菜单的调用）';

-- ----------------------------
-- Records of yunzhi_menu_type
-- ----------------------------
INSERT INTO `yunzhi_menu_type` VALUES ('main', '主菜单', '主菜单', '0');
