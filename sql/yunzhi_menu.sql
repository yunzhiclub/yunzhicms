/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-09-21 13:37:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_menu`
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
  `config` varchar(255) NOT NULL DEFAULT '[]' COMMENT '配置参数（json）',
  `filter` varchar(255) NOT NULL DEFAULT '[]' COMMENT '过滤器参数',
  `is_home` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0启用，1禁用',
  `update_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `create_time` smallint(6) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `list` (`weight`,`is_deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='菜单表（每一个菜单对应唯一的一个组件）';

-- ----------------------------
-- Records of yunzhi_menu
-- ----------------------------
INSERT INTO `yunzhi_menu` VALUES ('1', 'main', 'Home', '首页', '0', '', '0', '0', '首页', '{\"count\":\"3\"}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"6\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeFrontpageContentUrl\",\"param\":[]}}', '1', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('2', 'main', 'ContentList', '新闻通知', '0', 'news', '0', '0', '这里是描述信息', '{\"contentTypeName\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"30\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]},\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('3', 'main', 'ContentList', '院级新闻', '2', 'news/school', '0', '0', '', '{\"contentTypeName\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('4', 'main', 'Content', '关于我们', '0', 'aboutus', '0', '0', '测试', '{\"id\":\"1\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('5', 'main', 'ContentList', '热点新闻', '0', 'hotnews', '1', '0', '用于显示首页链接过来的新闻', '{\"contentType\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('6', 'main', 'Login', '个人中心', '0', 'personalcenter', '1', '0', '用于用户登陆与注销', '[]', '[]', '0', '0', '0', '0', '0');
