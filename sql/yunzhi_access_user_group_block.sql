/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-09-22 12:25:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_access_user_group_block`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_access_user_group_block`;
CREATE TABLE `yunzhi_access_user_group_block` (
  `user_group_name` varchar(40) NOT NULL COMMENT 'fk user_group 用户组外键',
  `block_id` int(11) unsigned NOT NULL COMMENT 'fk block 区块外键',
  `action` varchar(40) NOT NULL DEFAULT '',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_group_name`,`block_id`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-菜单 权限表。权限设置(LCURD)';

-- ----------------------------
-- Records of yunzhi_access_user_group_block
-- ----------------------------
INSERT INTO `yunzhi_access_user_group_block` VALUES ('admin', '2', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('editor', '2', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '1', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '2', 'edit', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '2', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '2', 'read', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '3', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '4', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '5', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '6', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '6', 'login', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '6', 'logout', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('register', '2', 'index', null, null);
INSERT INTO `yunzhi_access_user_group_block` VALUES ('public', '9', 'index', null, null);
