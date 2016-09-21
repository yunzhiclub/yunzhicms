/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-09-21 13:39:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_user_group`;
CREATE TABLE `yunzhi_user_group` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `update_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `is_system` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组（用户类型）表';

-- ----------------------------
-- Records of yunzhi_user_group
-- ----------------------------
INSERT INTO `yunzhi_user_group` VALUES ('admin', '超级管理员', '拥有开发权限', '0', '0', '0', '1', '1');
INSERT INTO `yunzhi_user_group` VALUES ('editor', '站点编辑人员', '对站点进行管理', '0', '0', '0', '1', '0');
INSERT INTO `yunzhi_user_group` VALUES ('register', '注册用户', '注册用户，拥有对权限新闻的查看权限', '0', '0', '0', '1', '0');
INSERT INTO `yunzhi_user_group` VALUES ('public', '公共用户', '浏览网站的用户', '0', '0', '0', '1', '0');
