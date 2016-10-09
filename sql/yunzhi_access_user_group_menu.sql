/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-30 11:13:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunzhi_access_user_group_menu`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_access_user_group_menu`;
CREATE TABLE `yunzhi_access_user_group_menu` (
  `user_group_name` varchar(40) NOT NULL COMMENT 'fk user_group 用户组外键',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'fk menu 菜单外键',
  `action` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_group_name`,`menu_id`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-菜单 权限表。权限设置(LCURD)';

-- ----------------------------
-- Records of yunzhi_access_user_group_menu
-- ----------------------------
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '0', '');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '0', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '0', 'read');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '1', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '2', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '3', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '4', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '5', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '6', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '7', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '8', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '9', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '10', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '11', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '12', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '13', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '14', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '15', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '16', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '17', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '18', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '19', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '20', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '21', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '22', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '23', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '24', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '25', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '26', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '27', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '28', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '29', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '30', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '31', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '32', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '33', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '34', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '35', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '36', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '37', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '38', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '39', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '40', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '41', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '42', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '43', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '44', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '45', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '46', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '47', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '48', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '49', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '50', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '51', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '52', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '53', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '54', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '55', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '56', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '57', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '58', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '59', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '60', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '61', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '62', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '63', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '64', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '65', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '66', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '67', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '68', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '69', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '70', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '71', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '72', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '73', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '74', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '75', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '76', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '77', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '78', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '79', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '80', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '81', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '82', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '83', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '84', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '85', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '86', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '87', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '88', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '89', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '90', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '91', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '92', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '93', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '94', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '95', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '96', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '97', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '98', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '99', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '100', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '101', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '102', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '103', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '104', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '105', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '106', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '107', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '108', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '109', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '110', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '111', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '112', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '113', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '114', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '115', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '116', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '117', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '118', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '119', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '120', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '121', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '122', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '123', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '124', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '125', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '126', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '127', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '128', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '129', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '130', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '131', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '132', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '133', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '134', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '135', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '136', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '137', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '138', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '139', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '140', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '141', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '142', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '143', 'index');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '143', 'read');
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '144', 'index');
