/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-09-22 12:24:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_access_menu_block`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_access_menu_block`;
CREATE TABLE `yunzhi_access_menu_block` (
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk menu',
  `block_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk block',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`,`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='菜单-区块 权限表';

-- ----------------------------
-- Records of yunzhi_access_menu_block
-- ----------------------------
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '1', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '2', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '3', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '4', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '8', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '9', '1474510230', '1474510230');
INSERT INTO `yunzhi_access_menu_block` VALUES ('2', '1', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('2', '7', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('3', '1', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('3', '7', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('4', '1', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('4', '7', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('5', '1', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('5', '7', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('6', '1', null, null);
INSERT INTO `yunzhi_access_menu_block` VALUES ('6', '7', null, null);
