/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50505
 Source Host           : localhost
 Source Database       : yunzhicms

 Target Server Type    : MySQL
 Target Server Version : 50505
 File Encoding         : utf-8

 Date: 08/18/2016 22:39:33 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `yunzhi_category`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_category`;
CREATE TABLE `yunzhi_category` (
  `name` varchar(40) NOT NULL,
  `access_roles` varchar(255) NOT NULL DEFAULT '[]' COMMENT 'FK 拥有权限的角色',
  `pname` varchar(40) NOT NULL COMMENT '上级name',
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '描述',
  `weight` smallint(6) NOT NULL DEFAULT '0' COMMENT '权重',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `fileds` varchar(255) NOT NULL DEFAULT '[]' COMMENT '字段',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `yunzhi_component`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_component`;
CREATE TABLE `yunzhi_component` (
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '类名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `author` varchar(255) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(255) NOT NULL DEFAULT '' COMMENT '版本',
  `default_config` varchar(255) NOT NULL DEFAULT '{}' COMMENT '默认配置参数(json)',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_component`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_component` VALUES ('Home', '首页', '用于显示首页', 'panjie', '1.0.0', '[]'), ('ContentList', '新闻列表', '新闻列表页，显示新闻列表及展示新闻详情', 'panjie', '1.0.0', '[]');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_content`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content`;
CREATE TABLE `yunzhi_content` (
  `id` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 用户名',
  `category_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 类别名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `create_time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `update_time` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  `delete_time` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  `is_freezed` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否冻结',
  `weight` smallint(6) NOT NULL,
  `hit` int(11) NOT NULL,
  `access_group` varchar(255) NOT NULL DEFAULT '[]' COMMENT '权限列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `yunzhi_menu`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_menu`;
CREATE TABLE `yunzhi_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_type_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK(menu_type)菜单类型',
  `component_name` varchar(40) NOT NULL DEFAULT '' COMMENT '组件组',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题，用于直接显示在前台中',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The parent link ID (plid) is the mlid of the link above in the hierarchy, or zero if the link is at the top level in its menu.',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '在前台中显示的路径，即URL',
  `is_hidden` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '权重',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `param` varchar(255) NOT NULL DEFAULT '[]' COMMENT '参数（json）',
  `is_home` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页',
  PRIMARY KEY (`id`),
  KEY `path_menu` (`url`(128),`title`),
  KEY `menu_plid_expand_child` (`title`,`pid`),
  KEY `menu_parents` (`title`),
  KEY `router_path` (`component_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Contains the individual links within a menu.';

-- ----------------------------
--  Records of `yunzhi_menu`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_menu` VALUES ('1', 'main', 'Home', '首页', '0', '/', '0', '0', '首页', '[]', '1'), ('2', 'main', 'ContentList', '新闻通知', '0', 'news', '0', '0', '', '[]', '0'), ('3', 'main', 'ContentList', '院级新闻', '2', 'school', '0', '0', '', '[]', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_menu_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_menu_type`;
CREATE TABLE `yunzhi_menu_type` (
  `name` varchar(40) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_menu_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_menu_type` VALUES ('main', '主菜单', '主菜单');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
