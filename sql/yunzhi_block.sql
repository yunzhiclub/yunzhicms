/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-09-22 12:25:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_block`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_block`;
CREATE TABLE `yunzhi_block` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `block_type_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk block_type',
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk menu 菜单FK。模块如果想实现LCURD，则必然需要组件支持。而组件则需要菜单支持。所以关系是区块对应菜单，菜单对应组件。',
  `position_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk position',
  `title` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0启用 1禁用',
  `weight` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `config` varchar(255) NOT NULL DEFAULT '[]' COMMENT '配置信息json',
  `filter` varchar(255) NOT NULL DEFAULT '[]' COMMENT '过滤器信息json',
  `update_time` smallint(6) unsigned NOT NULL,
  `create_time` smallint(6) unsigned NOT NULL,
  `delete_time` smallint(6) unsigned NOT NULL,
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `'is_delete'` (`is_delete`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='区块表';

-- ----------------------------
-- Records of yunzhi_block
-- ----------------------------
INSERT INTO `yunzhi_block` VALUES ('1', 'Menu', '0', 'menu', '主菜单', '显示在页面上方', '0', '0', '{\"menu_type_name\":\"main\",\"id\":\"mu-menu\"}', '[]', '65535', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('2', 'Slider', '0', 'slider', '幻灯片', '', '0', '0', '[]', '[]', '0', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('3', 'ContentVideo', '0', 'main', '文字视频介绍', '', '0', '3', '[]', '[]', '0', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('4', 'DataCounter', '0', 'main', '数据统计', '', '0', '2', '[]', '[]', '0', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('5', 'CaseShow', '0', 'main', '案例展示', '', '0', '0', '[]', '[]', '0', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('6', 'ShowCaseSlider', '0', 'main', '动态案例展示', '', '0', '0', '[]', '[]', '0', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('7', 'BreadCrumb', '0', 'breadCrumb', '面包屑', '', '0', '0', '[]', '[]', '65535', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('8', 'Footer', '0', 'main', '页脚', '', '0', '0', '[]', '[]', '65535', '0', '0', '0');
INSERT INTO `yunzhi_block` VALUES ('9', 'PictureNews', '0', 'main', 'PictureNews', '图文新闻列表', '0', '1', '[]', '[]', '65535', '65535', '0', '0');
