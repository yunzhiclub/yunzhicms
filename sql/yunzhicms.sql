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

 Date: 09/13/2016 09:39:57 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `yunzhi_access_menu_block`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_access_menu_block`;
CREATE TABLE `yunzhi_access_menu_block` (
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk menu',
  `block_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk block',
  PRIMARY KEY (`menu_id`,`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='菜单-区块 权限表';

-- ----------------------------
--  Records of `yunzhi_access_menu_block`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_access_menu_block` VALUES ('1', '1'), ('1', '2'), ('1', '3'), ('2', '1'), ('2', '7'), ('3', '1'), ('3', '7'), ('4', '1'), ('4', '7'), ('5', '1'), ('5', '7');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_access_menu_plugin`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_access_menu_plugin`;
CREATE TABLE `yunzhi_access_menu_plugin` (
  `menu_id` int(11) unsigned NOT NULL,
  `plugin_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`menu_id`,`plugin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单-插件 权限表';

-- ----------------------------
--  Records of `yunzhi_access_menu_plugin`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_access_menu_plugin` VALUES ('3', '1');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_access_user_group_menu`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_access_user_group_menu`;
CREATE TABLE `yunzhi_access_user_group_menu` (
  `user_group_name` varchar(40) NOT NULL COMMENT 'fk user_group 用户组外键',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'fk menu 菜单外键',
  `action` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_group_name`,`menu_id`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-菜单 权限表。权限设置(LCURD)';

-- ----------------------------
--  Records of `yunzhi_access_user_group_menu`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('admin', '2', 'index'), ('editor', '2', 'index'), ('public', '1', 'index'), ('public', '2', 'edit'), ('public', '2', 'index'), ('public', '2', 'read'), ('public', '3', 'index'), ('public', '4', 'index'), ('public', '5', 'index'), ('public', '6', 'index'), ('public', '6', 'login'), ('register', '2', 'index');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_block`
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
  PRIMARY KEY (`id`),
  KEY `delete_time` (`delete_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='区块表';

-- ----------------------------
--  Records of `yunzhi_block`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_block` VALUES ('1', 'Menu', '0', 'menu', '主菜单', '显示在页面上方', '0', '0', '{\"menu_type_name\":\"main\",\"id\":\"mu-menu\"}', '[]', '65535', '0', '0'), ('2', 'Slider', '0', 'slider', '幻灯片', '', '0', '0', '[]', '[]', '0', '0', '0'), ('3', 'ContentVideo', '0', 'main', '文字视频介绍', '', '0', '0', '[]', '[]', '0', '0', '0'), ('4', 'DataCounter', '0', 'main', '数据统计', '', '0', '0', '[]', '[]', '0', '0', '0'), ('5', 'CaseShow', '0', 'main', '案例展示', '', '0', '0', '[]', '[]', '0', '0', '0'), ('6', 'ShowCaseSlider', '0', 'main', '动态案例展示', '', '0', '0', '[]', '[]', '0', '0', '0'), ('7', 'BreadCrumb', '0', 'breadCrumb', '面包屑', '', '0', '0', '[]', '[]', '65535', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_block_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_block_type`;
CREATE TABLE `yunzhi_block_type` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='区块类型表';

-- ----------------------------
--  Records of `yunzhi_block_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_block_type` VALUES ('Menu', '菜单', '显示菜单'), ('BreadCrumb', '面包屑', ''), ('Slider', '幻灯片', ''), ('ContentVideo', '文字视频介绍', '通常用于首页的关于我们'), ('DataCounter', '数据统计', '数据统计'), ('CaseShow', '案例展示', ''), ('ShowCaseSlider', '动态案例展示', '');
COMMIT;

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
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='组件（类型）表';

-- ----------------------------
--  Records of `yunzhi_component`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_component` VALUES ('Home', '首页', '用于显示首页', 'panjie', '1.0.0'), ('ContentList', '新闻列表', '新闻列表页，显示新闻列表及展示新闻详情', 'panjie', '1.0.0'), ('Content', '新闻', '显示一篇新闻', '', ''), ('Login', '登陆注销', '用于用户的登陆与注销', '', '');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_content`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content`;
CREATE TABLE `yunzhi_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 用户名',
  `content_type_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 类别名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `create_time` int(5) unsigned NOT NULL DEFAULT '0',
  `update_time` int(5) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(5) unsigned NOT NULL DEFAULT '0',
  `is_freezed` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否冻结',
  `weight` smallint(6) NOT NULL,
  `hit` int(11) NOT NULL,
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_name` (`content_type_name`) USING BTREE,
  KEY `is_freezed` (`is_freezed`) USING BTREE,
  KEY `is_deleted` (`is_deleted`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
--  Records of `yunzhi_content`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_content` VALUES ('1', '', 'news', '这是一条新闻', '1232323111', '1472446015', '0', '0', '0', '425', '0'), ('2', '', 'news', '这是另一条新闻', '1232323111', '1472446019', '0', '0', '0', '142', '0'), ('3', '', 'products', ' 这是一个产品的新闻', '0', '1472446012', '0', '0', '0', '43', '0'), ('4', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('5', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('6', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('7', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('8', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('9', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('10', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('11', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('12', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('13', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('14', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('15', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('16', '', '', '', '0', '0', '0', '0', '0', '1', '0'), ('17', '', '', '', '0', '0', '0', '0', '0', '1', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_content_frontpage`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content_frontpage`;
CREATE TABLE `yunzhi_content_frontpage` (
  `content_id` int(11) NOT NULL,
  `weight` smallint(6) unsigned NOT NULL COMMENT '0',
  `create_time` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='首页文章表';

-- ----------------------------
--  Records of `yunzhi_content_frontpage`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_content_frontpage` VALUES ('1', '0', '0'), ('2', '2', '0'), ('3', '1', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_content_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content_type`;
CREATE TABLE `yunzhi_content_type` (
  `name` varchar(40) NOT NULL,
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk 菜单。用于被区块调用后，生成LCURD的信息。',
  `pname` varchar(40) NOT NULL COMMENT '上级name',
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '描述',
  `weight` smallint(6) NOT NULL DEFAULT '0' COMMENT '权重',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `fileds` varchar(255) NOT NULL DEFAULT '[]' COMMENT '字段',
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='类别(文章类型)表';

-- ----------------------------
--  Records of `yunzhi_content_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_content_type` VALUES ('news', '3', '', '新闻通知', '新闻通知', '0', '0', '[]'), ('products', '2', '', '产品列表', '', '0', '0', '[]');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field`;
CREATE TABLE `yunzhi_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '机读字段',
  `field_type_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk filed',
  `relate_type` varchar(40) NOT NULL DEFAULT '' COMMENT '关联的实体类型',
  `relate_value` varchar(40) NOT NULL DEFAULT '' COMMENT '关联实体类型的具体值',
  `title` varchar(40) NOT NULL DEFAULT '' COMMENT '后台 编辑 添加 时显示的信息',
  `weight` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `config` varchar(4096) NOT NULL DEFAULT '[]' COMMENT '字段配置信息 json',
  `filter` varchar(4096) NOT NULL DEFAULT '[]' COMMENT '过滤器，用于前台的输出. 使用字段与实体类型绑定的方法实现过滤器后的输出',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `relate_type` (`relate_type`) USING BTREE,
  KEY `relate_value` (`relate_value`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='字段表 各个实体与字段的对应关系写在这里';

-- ----------------------------
--  Records of `yunzhi_field`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field` VALUES ('1', 'body', 'body', 'Content', 'news', '内容', '0', '[]', '{\"type\":\"System\",\"function\":\"htmlspecialchars_decode\",\"param\":{\"length\":\"6\",\"ext\":\"...\"}}'), ('2', 'image', 'image', 'Content', 'news', '新闻图片', '1', '[]', '[]'), ('3', 'body', 'body', 'Content', 'products', '新闻内容', '0', '[]', '[]'), ('4', 'titles', 'json', 'Block', 'Slider', '标题', '0', '[]', '[]'), ('6', 'urls', 'json', 'Block', 'Slider', '链接地址', '0', '[]', '[]'), ('5', 'images', 'images', 'Block', 'Slider', '图片链接', '0', '[]', '[]'), ('7', 'headers', 'json', 'Block', 'Slider', '副标题', '0', '[]', '[]'), ('8', 'descriptions', 'json', 'Block', 'Slider', '描述信息', '0', '{\"type\":\"textarea\"}', '[]'), ('9', 'icon', 'text', 'Menu', 'main', '小图标', '0', '[]', '[]');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_body`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_body`;
CREATE TABLE `yunzhi_field_data_body` (
  `field_id` int(11) unsigned NOT NULL COMMENT 'fk field',
  `key_id` int(11) unsigned NOT NULL COMMENT '对应的关键字ID',
  `value` longtext NOT NULL,
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`key_id`,`field_id`,`is_deleted`),
  KEY `entity_id` (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Data storage for field 2 (body)';

-- ----------------------------
--  Records of `yunzhi_field_data_body`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_data_body` VALUES ('1', '1', '   &lt;p&gt;    &lt;p&gt;    &lt;p&gt;    &lt;p&gt;    &lt;p&gt;    &lt;p&gt;    &lt;p&gt; 这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题&lt;img src=&quot;/yunzhicms/public/upload/20160907/fecddd331f269a93b55fc16c7c742121.png&quot; alt=&quot;个人真实性核验单 (1)&quot; style=&quot;line-height: 1; max-width: 100%;&quot;&gt;&lt;br style=&quot;line-height: 1;&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;/p&gt;\r\n&lt;/p&gt;\r\n&lt;/p&gt;\r\n&lt;/p&gt;\r\n&lt;/p&gt;\r\n&lt;/p&gt;\r\n', '0'), ('1', '2', '   &lt;p&gt; 新闻通知1新闻通知1新闻通知1新闻通知1新闻通知1&lt;/p&gt;\r\n', '0'), ('2', '3', '新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_comment_body`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_comment_body`;
CREATE TABLE `yunzhi_field_data_comment_body` (
  `entity_type` varchar(128) NOT NULL DEFAULT '' COMMENT 'The entity type this data is attached to',
  `bundle` varchar(128) NOT NULL DEFAULT '' COMMENT 'The field instance bundle to which this row belongs, used when deleting a field instance',
  `deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'A boolean indicating whether this data item has been deleted',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'The entity id this data is attached to',
  `revision_id` int(10) unsigned DEFAULT NULL COMMENT 'The entity revision id this data is attached to, or NULL if the entity type is not versioned',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT 'The language for this data item.',
  `delta` int(10) unsigned NOT NULL COMMENT 'The sequence number for this data item, used for multi-value fields',
  `comment_body_value` longtext,
  `comment_body_format` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`entity_type`,`entity_id`,`deleted`,`delta`,`language`),
  KEY `entity_type` (`entity_type`),
  KEY `bundle` (`bundle`),
  KEY `deleted` (`deleted`),
  KEY `entity_id` (`entity_id`),
  KEY `revision_id` (`revision_id`),
  KEY `language` (`language`),
  KEY `comment_body_format` (`comment_body_format`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Data storage for field 1 (comment_body)';

-- ----------------------------
--  Table structure for `yunzhi_field_data_field_tags`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_field_tags`;
CREATE TABLE `yunzhi_field_data_field_tags` (
  `entity_type` varchar(128) NOT NULL DEFAULT '' COMMENT 'The entity type this data is attached to',
  `bundle` varchar(128) NOT NULL DEFAULT '' COMMENT 'The field instance bundle to which this row belongs, used when deleting a field instance',
  `deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'A boolean indicating whether this data item has been deleted',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'The entity id this data is attached to',
  `revision_id` int(10) unsigned DEFAULT NULL COMMENT 'The entity revision id this data is attached to, or NULL if the entity type is not versioned',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT 'The language for this data item.',
  `delta` int(10) unsigned NOT NULL COMMENT 'The sequence number for this data item, used for multi-value fields',
  `field_tags_tid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`entity_type`,`entity_id`,`deleted`,`delta`,`language`),
  KEY `entity_type` (`entity_type`),
  KEY `bundle` (`bundle`),
  KEY `deleted` (`deleted`),
  KEY `entity_id` (`entity_id`),
  KEY `revision_id` (`revision_id`),
  KEY `language` (`language`),
  KEY `field_tags_tid` (`field_tags_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Data storage for field 3 (field_tags)';

-- ----------------------------
--  Table structure for `yunzhi_field_data_image`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_image`;
CREATE TABLE `yunzhi_field_data_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The entity id this data is attached to',
  `key_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk of user_name',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `save_name` varchar(100) NOT NULL DEFAULT '' COMMENT '保存文件名',
  `ext` varchar(10) NOT NULL DEFAULT '' COMMENT '扩展名',
  `sha1` varchar(40) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小B',
  `mime` varchar(40) NOT NULL DEFAULT '' COMMENT 'MIME',
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`) USING BTREE,
  KEY `key_id` (`key_id`) USING BTREE,
  KEY `sha1` (`sha1`) USING BTREE,
  KEY `md5` (`md5`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='Data storage for field 4 (field_image)';

-- ----------------------------
--  Records of `yunzhi_field_data_image`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_data_image` VALUES ('5', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('6', '0', '0', '', '69947EE9-DD40-427D-8F43-390AED15FE92.png', '20160907/10cc6ec3f5c48ec37c28e9a2787a61de.png', 'png', '7cd5cd6c76fa20156c68dfe296b1443bd066a15e', 'aab1f603556216ac2e5a1b3fc971ca73', '174132', 'image/jpeg'), ('7', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('8', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('9', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('10', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('11', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('12', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('13', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('14', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('15', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('16', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('17', '0', '0', '', 'Girl fashion beauty.jpg', '20160907/819029973ba3b6d987748accff729b76.jpg', 'jpg', '7a3b581096d4a97e9ea73bbf10e37723dead9284', '3b3cac76b6d7901de8688bded8b9b37d', '450782', 'image/jpeg'), ('18', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('19', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('20', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('21', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('22', '0', '0', '', '69947EE9-DD40-427D-8F43-390AED15FE92.png', '20160907/10cc6ec3f5c48ec37c28e9a2787a61de.png', 'png', '7cd5cd6c76fa20156c68dfe296b1443bd066a15e', 'aab1f603556216ac2e5a1b3fc971ca73', '174132', 'image/jpeg'), ('23', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('24', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('25', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('26', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('27', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('28', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('29', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('30', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('31', '0', '0', '', 'Girl fashion beauty.jpg', '20160907/819029973ba3b6d987748accff729b76.jpg', 'jpg', '7a3b581096d4a97e9ea73bbf10e37723dead9284', '3b3cac76b6d7901de8688bded8b9b37d', '450782', 'image/jpeg'), ('32', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('33', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('34', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('35', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('36', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('37', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('38', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('39', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('40', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('41', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('42', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('43', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('44', '0', '0', '', '个人真实性核验单 (1).png', '20160907/fecddd331f269a93b55fc16c7c742121.png', 'png', '00155e2f1871ac015ebcd303d7351670fc133e95', '21b7ef3ae5010689b44c482a8d6ba3d3', '187767', 'image/png'), ('47', '2', '1', '', 'Girl fashion beauty.jpg', '20160907/819029973ba3b6d987748accff729b76.jpg', 'jpg', '7a3b581096d4a97e9ea73bbf10e37723dead9284', '3b3cac76b6d7901de8688bded8b9b37d', '450782', 'image/jpeg'), ('48', '0', '0', '', 'IMG_2897.JPG', '20160907/7b29c9c6b5e03d5f00f95ca2a61e9260.JPG', 'jpg', '6c02ab91d7101a3c60edec84c7a320ba8e56ea60', '23305e519817b6e5f01cfc3e92b8621a', '1908619', 'image/jpeg'), ('49', '0', '0', '', '总学习记录下半部分.png', '20160908/d93d0157350f7c4d7f1a63594f9f849e.png', 'png', '8facb43772c0b2df948e7fe05f71e2c1629701f4', '86adb097a89220dee4dbab8d78da32e9', '36666', 'image/png'), ('50', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('51', '0', '0', '', 'IMG_2895.JPG', '20160909/c5e1d27c1c5248ec13756ce57e2bfcd0.JPG', 'jpg', '997e230ce0e90ef29f0d0052f21a58bda3342ae1', '335ad910864e3ea73d66fdcc60c1dda2', '1320121', 'image/jpeg'), ('52', '0', '0', '', '1m.jpg', '20160909/23ac694c99fe13b03f362e02530d13ae.jpg', 'jpg', '1a3bc3109efc4e177b065d72b14df6d7082d64ef', 'e1ca9dff471ecd40a9e2829643bc2fd4', '42503', 'image/jpeg'), ('53', '0', '0', '', '1width.png', '20160909/9b20c13dcb0810348a1750df841403cc.png', 'png', '8e0ac2f0a8d555ea33803c15d512bbbfd497e841', '70bbcbbea1afa862b0e317e886a215c4', '375', 'image/png'), ('54', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('55', '0', '0', '', '2widtd.png', '20160909/b672ff9123a4e9167347f4ca9fc474b5.png', 'png', '18c08e0f6ae27d10f7d7b713f3dc67f7ebd75e01', '5162364abf3c8a1690706912714137df', '419', 'image/png'), ('56', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('57', '0', '0', '', 'learning.png', '20160909/f7eb789c334bab6a43be3484a4baffd2.png', 'png', 'd2c112c31cded22cbf822c7aac535ea56e5d393e', 'df6ee7fdde85079a49cf8fc24a8e9796', '61370', 'image/png'), ('58', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('59', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('60', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('61', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('62', '0', '0', '', 'tp5.png', '20160909/46ed1f6f05dfbc1210a90c61031daaf9.png', 'png', 'a833c6d35f642086d8b4ea5204440627980e10f9', 'b54e7831eb87550ef817a9fb2eb85a63', '33862', 'image/png'), ('63', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('64', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('65', '0', '0', '', '2widtd.png', '20160909/b672ff9123a4e9167347f4ca9fc474b5.png', 'png', '18c08e0f6ae27d10f7d7b713f3dc67f7ebd75e01', '5162364abf3c8a1690706912714137df', '419', 'image/png'), ('66', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('67', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('68', '0', '0', '', 'learning.png', '20160909/f7eb789c334bab6a43be3484a4baffd2.png', 'png', 'd2c112c31cded22cbf822c7aac535ea56e5d393e', 'df6ee7fdde85079a49cf8fc24a8e9796', '61370', 'image/png'), ('69', '0', '0', '', '1m.jpg', '20160909/23ac694c99fe13b03f362e02530d13ae.jpg', 'jpg', '1a3bc3109efc4e177b065d72b14df6d7082d64ef', 'e1ca9dff471ecd40a9e2829643bc2fd4', '42503', 'image/jpeg'), ('70', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('71', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('72', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('73', '0', '0', '', '公司logo.jpg', '20160909/2306d21d8e8d62744fe35c221c1359b9.jpg', 'jpg', '2bf82667d21fea68d0090fd8ca7804867d1467d0', '7f9f9f6ed57b0e3bea46bd4b066fd01b', '28097', 'image/jpeg'), ('74', '0', '0', '', '970width.png', '20160909/a07ac25db4da1af8fed3d3a3905cea07.png', 'png', '4229b0890d79caae845ec73e96b5a809b333d06f', 'da1babe7ae1b59a147a57b71da486fc3', '57951', 'image/png'), ('75', '0', '0', '', '1m.jpg', '20160909/23ac694c99fe13b03f362e02530d13ae.jpg', 'jpg', '1a3bc3109efc4e177b065d72b14df6d7082d64ef', 'e1ca9dff471ecd40a9e2829643bc2fd4', '42503', 'image/jpeg'), ('76', '0', '0', '', '1m.jpg', '20160909/23ac694c99fe13b03f362e02530d13ae.jpg', 'jpg', '1a3bc3109efc4e177b065d72b14df6d7082d64ef', 'e1ca9dff471ecd40a9e2829643bc2fd4', '42503', 'image/jpeg'), ('77', '0', '0', '', '111.png', '20160908/65923c474c4d104c49e5bed5854eb771.png', 'png', 'e87cad1414a01a15906d91d274d7e24694e26885', '4b980346129bc1c6d4ae9fca1876c04d', '194950', 'image/jpeg'), ('78', '0', '0', '', '1m.jpg', '20160909/23ac694c99fe13b03f362e02530d13ae.jpg', 'jpg', '1a3bc3109efc4e177b065d72b14df6d7082d64ef', 'e1ca9dff471ecd40a9e2829643bc2fd4', '42503', 'image/jpeg'), ('79', '0', '0', '', 'learning.png', '20160909/f7eb789c334bab6a43be3484a4baffd2.png', 'png', 'd2c112c31cded22cbf822c7aac535ea56e5d393e', 'df6ee7fdde85079a49cf8fc24a8e9796', '61370', 'image/png'), ('80', '0', '0', '', '1.jpg', '20160912/4816be8aab31bc3dd96a068babf7b3f1.jpg', 'jpg', 'c4eb60cb8d93c641d7968f06901b3c333f421962', 'de32827c690341063cc912de9045be0e', '30641', 'image/jpeg'), ('81', '0', '0', '', '88-20151030101118.jpg', '20160912/167b5f27e87081f4545c14c29b869964.jpg', 'jpg', 'cca18b443fe9a6be89f9fecbd858e48767863b89', '54fe7a710948136957ae5552fa9d3d45', '75156', 'image/jpeg'), ('82', '0', '0', '', '3.jpg', '20160912/53b68492cfa0c681e9a7d54f74d3fecb.jpg', 'jpg', '37f43a9f43a06c1da330b4f19e67155cdcbb8c5c', '58c61881873640a1f7daca1e6850cc1f', '640535', 'image/jpeg');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_images`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_images`;
CREATE TABLE `yunzhi_field_data_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk field',
  `key_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk ...',
  `user_name` varchar(40) NOT NULL COMMENT 'fk user',
  `value` varchar(4096) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='多图片字段.使用json格式进行存储';

-- ----------------------------
--  Records of `yunzhi_field_data_images`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_data_images` VALUES ('2', '5', '2', '', '[\"\\/yunzhicms\\/public\\/upload\\/20160912\\/53b68492cfa0c681e9a7d54f74d3fecb.jpg\",\"\\/yunzhicms\\/public\\/upload\\/20160912\\/4816be8aab31bc3dd96a068babf7b3f1.jpg\"]');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_json`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_json`;
CREATE TABLE `yunzhi_field_data_json` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk field',
  `key_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk ...',
  `user_name` varchar(40) NOT NULL COMMENT 'fk user',
  `value` varchar(4096) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_field_data_json`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_data_json` VALUES ('1', '4', '2', '', '[\"\\u8fd9\\u662f\\u4e3b\\u6807\\u9898\",\"\\u8fd9\\u662f\\u4e3b\\u6807\\u9898\"]'), ('2', '5', '2', '', '[\"\\u94fe\\u63a51\",\"\\u5730\\u57404\",\"\"]'), ('3', '6', '2', '', '[\"http:\\/\\/www.mengyunzhi.com\",\"http:\\/\\/www.scse.hebut.edu.cn\"]'), ('4', '7', '2', '', '[\"\\u8fd9\\u662f\\u526f\\u6807\\u98981\",\"\\u8fd9\\u662f\\u526f\\u6807\\u98982\"]'), ('5', '8', '2', '', '[\"\\u8fd9\\u91cc\\u662f\\u63cf\\u8ff0\\u4fe1\\u606f\\uff1a\\u56fe\\u7247\\u4e0a\\u4f20\\u7684\\u89c4\\u683c\\u4e3a1920*500, \\u975e\\u8be5\\u89c4\\u683c\\u4f1a\\u8fdb\\u884c\\u81ea\\u52a8\\u7684\\u62c9\\u4f38\\u3002\\u5982\\u679c\\u56fe\\u7247\\u4e0a\\u4f20\\u540e\\u6709\\u4e9b\\u6697\\uff0c\\u662f\\u6b63\\u5e38\\u73b0\\u8c61\\u3002\\u8bf7\\u589e\\u52a0\\u4eae\\u5ea6\\u540e\\u91cd\\u65b0\\u4e0a\\u4f20\\u3002\",\"\\u7531\\u4e8e\\u5b57\\u4f53\\u4e3a\\u767d\\u8272\\uff0c\\u6240\\u4ee5\\u6211\\u4eec\\u5bf9\\u56fe\\u7247\\u8fdb\\u884c\\u4e86\\u8499\\u677f\\u5904\\u7406\\u3002\\u4e0a\\u4f20\\u56fe\\u7247\\u540e\\uff0c\\u5c06\\u4f1a\\u770b\\u5230\\u56fe\\u7247\\u4e0a\\u65b9\\u6709\\u4e00\\u5c42\\u534a\\u900f\\u660e\\u7684\\u8499\\u677f\\uff0c\\u8fd9\\u662f\\u6b63\\u5e38\\u7684\\u73b0\\u8c61\\u3002\\u5f53\\u7136\\u4e86\\uff0c\\u5373\\u4f7f\\u662f\\u8fd9\\u6837\\uff0c\\u6211\\u4eec\\u4e5f\\u5e76\\u4e0d\\u63a8\\u8350\\u4f7f\\u7528\\u767d\\u8272\\u7684\\u80cc\\u666f\\u56fe\\u7247\\u3002\"]');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_text`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_text`;
CREATE TABLE `yunzhi_field_data_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk field',
  `key_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'fk ...',
  `user_name` varchar(40) NOT NULL COMMENT 'fk user',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `yunzhi_field_type`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_type`;
CREATE TABLE `yunzhi_field_type` (
  `name` varchar(40) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0启用，1禁用',
  `title` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段类型表';

-- ----------------------------
--  Records of `yunzhi_field_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_type` VALUES ('body', '0', '富文本', ''), ('image', '0', '图片', ''), ('text', '0', '文本', '');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_filter`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_filter`;
CREATE TABLE `yunzhi_filter` (
  `type` varchar(40) NOT NULL COMMENT '类型（对应过滤器的类名）',
  `function` varchar(40) NOT NULL COMMENT '方法名',
  `param` varchar(4096) NOT NULL COMMENT '参数及参数的说明、默认值（json）',
  `title` varchar(40) NOT NULL COMMENT '标题',
  `description` varchar(100) NOT NULL COMMENT '描述',
  `author` varchar(40) NOT NULL COMMENT '作者',
  `version` varchar(40) NOT NULL COMMENT '版本号',
  `website` varchar(100) NOT NULL COMMENT '网址',
  `demo_url` varchar(100) NOT NULL COMMENT '示例站点URL',
  `email` varchar(100) NOT NULL COMMENT '作者邮箱',
  PRIMARY KEY (`type`,`function`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='过滤器表';

-- ----------------------------
--  Records of `yunzhi_filter`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_filter` VALUES ('System', 'makeFrontpageContentUrl', '[]', '首页新闻链接', '直接生成首页新闻链接（直接链接到 Content组件）', '梦云智', '1.0.0', 'http://www.mengyunzhi.com', 'http://www.mengyunzhi.com', '3792535@qq.com'), ('System', 'makeCurrentMenuReadUrl', '[]', '生成菜单URL', '生成菜单对应的路由URL信息', '', '', '', '', ''), ('String', 'substr', '{\"length\":{\"value\":20,\"title\":\"\\u622a\\u53d6\\u957f\\u5ea6\",\"type\":\"text\",\"description\":\"\\u622a\\u53d6\\u7684UTF8\\u7f16\\u7801\\u7684\\u957f\\u5ea6\"},\"ext\":{\"value\":\"...\",\"title\":\"\\u540e\\u7f00\",\"type\":\"text\",\"description\":\"\\u5c06\\u53d1\\u751f\\u622a\\u53d6\\u64cd\\u4f5c\\u540e\\uff0c\\u586b\\u5145\\u5728\\u6807\\u9898\\u540e\\u9762\\u7684\\u540e\\u7f00\\u4fe1\\u606f\"}}', '标题截取', '对UTF8编码的标题进行截取', '', '', '', '', ''), ('Date', 'format', '{\"dateFormat\":{\"value\":\"Y-m-d\",\"title\":\"\\u65f6\\u95f4\\u6233\\u683c\\u5f0f\\u5316\",\"description\":\"\\u5bf9\\u65f6\\u95f4\\u6233\\u8fdb\\u884c\\u683c\\u5f0f\\u5316\",\"type\":\"text\"}}', '时间戳格式化', '时间戳格式化', '', '', '', '', ''), ('System', 'makeContentReadUrl', '[]', '生成新闻读链接', '根据新闻对应的类别信息，取类别的URL信息，生成LCURD路由', '', '', '', '', '');
COMMIT;

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
  `config` varchar(255) NOT NULL DEFAULT '[]' COMMENT '配置参数（json）',
  `filter` varchar(255) NOT NULL DEFAULT '[]' COMMENT '过滤器参数',
  `is_home` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0启用，1禁用',
  `update_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `create_time` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `path_menu` (`url`(128),`title`),
  KEY `menu_plid_expand_child` (`title`,`pid`),
  KEY `menu_parents` (`title`),
  KEY `router_path` (`component_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='菜单表（每一个菜单对应唯一的一个组件）';

-- ----------------------------
--  Records of `yunzhi_menu`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_menu` VALUES ('1', 'main', 'Home', '首页', '0', '', '0', '0', '首页', '{\"count\":\"3\"}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"6\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeFrontpageContentUrl\",\"param\":[]}}', '1', '0', '65535', '0'), ('2', 'main', 'ContentList', '新闻通知', '0', 'news', '0', '0', '这里是描述信息', '{\"contentTypeName\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"30\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]},\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0'), ('3', 'main', 'ContentList', '院级新闻', '2', 'news/school', '0', '0', '', '{\"contentTypeName\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0'), ('4', 'main', 'Content', '关于我们', '0', 'aboutus', '0', '0', '测试', '{\"id\":\"1\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0'), ('5', 'main', 'ContentList', '热点新闻', '0', 'hotnews', '1', '0', '用于显示首页链接过来的新闻', '{\"contentType\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0'), ('6', 'main', 'Login', '登录注销', '0', 'login/test', '1', '0', '用于用户登陆与注销', '[]', '[]', '0', '0', '0', '0');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单类型表（主要为了可以使用区块进行菜单的调用）';

-- ----------------------------
--  Records of `yunzhi_menu_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_menu_type` VALUES ('main', '主菜单', '主菜单');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_plugin`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_plugin`;
CREATE TABLE `yunzhi_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `plugin_type_name` varchar(40) NOT NULL COMMENT 'fk plugin_type 插件类型',
  `position_name` varchar(40) NOT NULL COMMENT 'fk of plugin_position',
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `config` varchar(4096) NOT NULL DEFAULT '[]',
  `filter` varchar(4096) NOT NULL DEFAULT '[]',
  `weight` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
--  Records of `yunzhi_plugin`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_plugin` VALUES ('1', 'PreNextContent', 'afterContent', '文章后', '', '0', '', '{\"href\":{\"type\":\"System\",\"function\":\"makeContentReadUrl\"}}', '0');
COMMIT;

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

-- ----------------------------
--  Table structure for `yunzhi_position`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_position`;
CREATE TABLE `yunzhi_position` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(40) NOT NULL DEFAULT 'blcok' COMMENT '类型: block 区块，plugin 插件',
  `theme_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk of theme',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='位置表，记录着某个主题(theme)下的插件(plugin)及区块(block)位置信息';

-- ----------------------------
--  Table structure for `yunzhi_theme`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_theme`;
CREATE TABLE `yunzhi_theme` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `is_current` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否激活. 0未激活，1已激活',
  `author` varchar(40) NOT NULL DEFAULT '',
  `version` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主题表';

-- ----------------------------
--  Records of `yunzhi_theme`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_theme` VALUES ('default', '默认主题', '', '1', '梦云智', '');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_user`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_user`;
CREATE TABLE `yunzhi_user` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL DEFAULT '',
  `qq_open_id` varchar(40) NOT NULL DEFAULT '' COMMENT 'qq 认证openid',
  `password` varchar(40) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0正常 1冻结',
  `user_group_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk user_group',
  `create_time` smallint(6) unsigned NOT NULL,
  `update_time` smallint(6) unsigned NOT NULL,
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1已删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
--  Records of `yunzhi_user`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_user` VALUES ('1', 'admin@mengyunzhi.com', '', '', '梦云智', '1', 'admin', '0', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_user_group`;
CREATE TABLE `yunzhi_user_group` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `update_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组（用户类型）表';

-- ----------------------------
--  Records of `yunzhi_user_group`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_user_group` VALUES ('admin', '超级管理员', '拥有开发权限', '0', '0', '0'), ('editor', '站点编辑人员', '对站点进行管理', '0', '0', '0'), ('register', '注册用户', '注册用户，拥有对权限新闻的查看权限', '0', '0', '0'), ('public', '公共用户', '浏览网站的用户', '0', '0', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
