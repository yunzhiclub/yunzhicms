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

 Date: 09/01/2016 16:07:32 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `yunzhi_plugin_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_plugin_type`;
CREATE TABLE `yunzhi_plugin_type` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='插件类型表';

-- ----------------------------
--  Records of `yunzhi_plugin_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_plugin_type` VALUES ('PreNextContent', '上一篇、下一篇文章', '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
