/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-09-22 12:25:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_block_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_block_type`;
CREATE TABLE `yunzhi_block_type` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='区块类型表';

-- ----------------------------
-- Records of yunzhi_block_type
-- ----------------------------
INSERT INTO `yunzhi_block_type` VALUES ('Menu', '菜单', '显示菜单');
INSERT INTO `yunzhi_block_type` VALUES ('BreadCrumb', '面包屑', '');
INSERT INTO `yunzhi_block_type` VALUES ('Slider', '幻灯片', '');
INSERT INTO `yunzhi_block_type` VALUES ('ContentVideo', '文字视频介绍', '通常用于首页的关于我们');
INSERT INTO `yunzhi_block_type` VALUES ('DataCounter', '数据统计', '数据统计');
INSERT INTO `yunzhi_block_type` VALUES ('CaseShow', '案例展示', '');
INSERT INTO `yunzhi_block_type` VALUES ('ShowCaseSlider', '动态案例展示', '');
INSERT INTO `yunzhi_block_type` VALUES ('Footer', '页脚显示', '');
INSERT INTO `yunzhi_block_type` VALUES ('PictureNews', '图文新闻', '通常用于首页展示图文新闻');
