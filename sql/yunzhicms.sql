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

 Date: 09/01/2016 15:33:39 PM
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
  `access` tinyint(2) unsigned NOT NULL COMMENT '权限CURD（增改查删）用位来记录',
  PRIMARY KEY (`user_group_name`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-菜单 权限表。权限设置(LCURD)';

-- ----------------------------
--  Records of `yunzhi_access_user_group_menu`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_access_user_group_menu` VALUES ('public', '4', '18'), ('public', '2', '18'), ('register', '2', '10'), ('editor', '2', '15'), ('public', '1', '18'), ('admin', '2', '15'), ('public', '3', '18'), ('public', '5', '18');
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
  `config` varchar(255) NOT NULL DEFAULT '[]',
  `filter` varchar(255) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='区块类型表';

-- ----------------------------
--  Records of `yunzhi_block_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_block_type` VALUES ('Menu', '菜单', '显示菜单', '{\"menu_type_name\":{\"value\":\"main\",\"title\":\"\\u83dc\\u5355\\u7c7b\\u578b\",\"description\":\"\\u83dc\\u5355\\u7c7b\\u578b\",\"type\":\"text\"},\"id\":{\"value\":\"mu-menu\",\"title\":\"\"}}', '[]'), ('BreadCrumb', '面包屑', '', '[]', '[]'), ('Slider', '幻灯片', '', '[]', '[]'), ('ContentVideo', '文字视频介绍', '通常用于首页的关于我们', '[]', '[]'), ('DataCounter', '数据统计', '数据统计', '[]', '[]'), ('CaseShow', '案例展示', '', '[]', '[]'), ('ShowCaseSlider', '动态案例展示', '', '[]', '[]');
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
  `filter` varchar(4096) NOT NULL DEFAULT '[]' COMMENT '字段过滤信息',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='组件（类型）表';

-- ----------------------------
--  Records of `yunzhi_component`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_component` VALUES ('Home', '首页', '用于显示首页', 'panjie', '1.0.0', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":6,\"etc\":\"..\"}},\"href\":{\"type\":\"System\",\"function\":\"makeFrontpageContentUrl\"}}'), ('ContentList', '新闻列表', '新闻列表页，显示新闻列表及展示新闻详情', 'panjie', '1.0.0', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":30,\"etc\":\"..\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\"},\"date\":{\"type\":\"date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}'), ('Content', '新闻', '显示一篇新闻', '', '', '[]');
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
--  Records of `yunzhi_content`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_content` VALUES ('1', '', 'news', '这是一条新闻', '1232323111', '1472446015', '0', '0', '0', '322', '0'), ('2', '', 'news', '这是另一条新闻', '1232323111', '1472446019', '0', '0', '0', '105', '0'), ('3', '', 'products', ' 这是一个产品的新闻', '0', '1472446012', '0', '0', '0', '41', '0');
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
  `name` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'text' COMMENT '类型',
  `config` varchar(255) NOT NULL DEFAULT '[]' COMMENT '配置信息(json)',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0启用，1禁用',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段表';

-- ----------------------------
--  Records of `yunzhi_field`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field` VALUES ('body', 'textarea', '[]', '0'), ('filed_image', 'image', '[]', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_config`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_config`;
CREATE TABLE `yunzhi_field_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk filed',
  `type` varchar(40) NOT NULL DEFAULT '' COMMENT '绑定的实体类型',
  `value` varchar(40) NOT NULL DEFAULT '' COMMENT '绑定实体类型的具体值',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0启用 1禁用',
  `is_one` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否唯一. 1: 1对1 ；2：1对多',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='字段配置表（各个实体的扩展字段配置）';

-- ----------------------------
--  Records of `yunzhi_field_config`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_config` VALUES ('1', 'body', 'Content', 'news', '0', '1'), ('2', 'field_image', 'Content', 'news', '0', '1'), ('3', 'body', 'Content', 'products', '0', '1');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_body`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_body`;
CREATE TABLE `yunzhi_field_data_body` (
  `field_config_id` int(11) unsigned NOT NULL COMMENT 'fk field_config',
  `key` int(11) unsigned NOT NULL COMMENT '对应的 关健字',
  `weight` int(10) unsigned NOT NULL COMMENT '权重',
  `value` longtext,
  `summary` longtext,
  `format` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`,`weight`,`field_config_id`),
  KEY `entity_id` (`key`),
  KEY `body_format` (`format`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Data storage for field 2 (body)';

-- ----------------------------
--  Records of `yunzhi_field_data_body`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_data_body` VALUES ('1', '1', '0', '这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题这里是关于我们的主题', '这里是关于我们的摘要', 'filtered_html', '0'), ('1', '2', '1', '新闻通知1新闻通知1新闻通知1新闻通知1新闻通知1', '', 'filtered_html', '0'), ('2', '3', '0', '新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2', '', 'filtered_html', '0');
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
--  Table structure for `yunzhi_field_data_field_image`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_field_image`;
CREATE TABLE `yunzhi_field_data_field_image` (
  `entity_type` varchar(128) NOT NULL DEFAULT '' COMMENT 'The entity type this data is attached to',
  `bundle` varchar(128) NOT NULL DEFAULT '' COMMENT 'The field instance bundle to which this row belongs, used when deleting a field instance',
  `deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'A boolean indicating whether this data item has been deleted',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'The entity id this data is attached to',
  `revision_id` int(10) unsigned DEFAULT NULL COMMENT 'The entity revision id this data is attached to, or NULL if the entity type is not versioned',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT 'The language for this data item.',
  `delta` int(10) unsigned NOT NULL COMMENT 'The sequence number for this data item, used for multi-value fields',
  `field_image_fid` int(10) unsigned DEFAULT NULL COMMENT 'The test_file_managed.fid being referenced in this field.',
  `field_image_alt` varchar(512) DEFAULT NULL COMMENT 'Alternative image text, for the image’s ’alt’ attribute.',
  `field_image_title` varchar(1024) DEFAULT NULL COMMENT 'Image title text, for the image’s ’title’ attribute.',
  `field_image_width` int(10) unsigned DEFAULT NULL COMMENT 'The width of the image in pixels.',
  `field_image_height` int(10) unsigned DEFAULT NULL COMMENT 'The height of the image in pixels.',
  PRIMARY KEY (`entity_type`,`entity_id`,`deleted`,`delta`,`language`),
  KEY `entity_type` (`entity_type`),
  KEY `bundle` (`bundle`),
  KEY `deleted` (`deleted`),
  KEY `entity_id` (`entity_id`),
  KEY `revision_id` (`revision_id`),
  KEY `language` (`language`),
  KEY `field_image_fid` (`field_image_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Data storage for field 4 (field_image)';

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='菜单表（每一个菜单对应唯一的一个组件）';

-- ----------------------------
--  Records of `yunzhi_menu`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_menu` VALUES ('1', 'main', 'Home', '首页', '0', '/', '0', '0', '首页', '{\"count\":\"3\"}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"6\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeFrontpageContentUrl\",\"param\":[]}}', '1', '0', '65535', '0'), ('2', 'main', 'ContentList', '新闻通知', '0', 'news', '0', '0', '这里是描述信息', '{\"contentTypeName\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"30\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]},\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0'), ('3', 'main', 'ContentList', '院级新闻', '2', 'news/school', '0', '0', '', '{\"contentTypeName\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0'), ('4', 'main', 'Content', '关于我们', '0', 'aboutus', '0', '0', '测试', '{\"id\":\"1\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0'), ('5', 'main', 'ContentList', '热点新闻', '0', 'hotnews', '1', '0', '用于显示首页链接过来的新闻', '{\"contentType\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0');
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
  `config` varchar(4096) NOT NULL DEFAULT '[]',
  `filter` varchar(4096) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='插件类型表';

-- ----------------------------
--  Records of `yunzhi_plugin_type`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_plugin_type` VALUES ('PreNextContent', '上一篇、下一篇文章', '', '[]', '{\"href\":{\"type\":\"System\",\"function\":\"makeContentReadUrl\"}}');
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
  `email` varchar(40) NOT NULL DEFAULT '',
  `qq_open_id` varchar(40) NOT NULL DEFAULT '' COMMENT 'qq 认证openid',
  `password` varchar(40) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0正常 1冻结',
  `user_group_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk user_group',
  `create_time` smallint(6) unsigned NOT NULL,
  `update_time` smallint(6) unsigned NOT NULL,
  `is_deleted` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1已删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
--  Records of `yunzhi_user`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_user` VALUES ('1', 'panjie@yunzhiclub.com', '', '', '潘杰', '1', 'admin', '0', '0', '0');
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

-- ----------------------------
--  View structure for `english_card_student_card_batch_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_card_student_card_batch_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_card_student_card_batch_view` AS select `yunzhicms`.`english_card_batch`.`deadline` AS `deadline`,`yunzhicms`.`english_student`.`id` AS `student__id` from ((`english_card` left join `english_student` on((`yunzhicms`.`english_card`.`student_id` = `yunzhicms`.`english_student`.`id`))) left join `english_card_batch` on((`yunzhicms`.`english_card`.`card_batch_id` = `yunzhicms`.`english_card_batch`.`id`)));

-- ----------------------------
--  View structure for `english_department_post_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_department_post_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_department_post_view` AS select `yunzhicms`.`english_department_post`.`id` AS `id`,`yunzhicms`.`english_department`.`title` AS `department__title`,`yunzhicms`.`english_department`.`is_son` AS `department__is_son`,`yunzhicms`.`english_post`.`name` AS `post__name`,`yunzhicms`.`english_post`.`is_son` AS `post__is_son`,`yunzhicms`.`english_post`.`is_admin` AS `post__is_admin`,`yunzhicms`.`english_department_post`.`department_id` AS `department_id`,`yunzhicms`.`english_department_post`.`post_id` AS `post_id` from ((`english_department_post` join `english_department` on((`yunzhicms`.`english_department_post`.`department_id` = `yunzhicms`.`english_department`.`id`))) join `english_post` on((`yunzhicms`.`english_department_post`.`post_id` = `yunzhicms`.`english_post`.`id`)));

-- ----------------------------
--  View structure for `english_klass_course_student_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_klass_course_student_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_klass_course_student_view` AS select `yunzhicms`.`english_klass_course`.`id` AS `id`,`yunzhicms`.`english_klass_course`.`klass_id` AS `klass_id`,`yunzhicms`.`english_klass_course`.`course_id` AS `course_id`,`yunzhicms`.`english_course`.`title` AS `title`,`yunzhicms`.`english_klass`.`name` AS `name`,`yunzhicms`.`english_student`.`id` AS `student__id` from (((`english_klass_course` left join `english_klass` on((`yunzhicms`.`english_klass_course`.`klass_id` = `yunzhicms`.`english_klass`.`id`))) left join `english_course` on((`yunzhicms`.`english_klass_course`.`course_id` = `yunzhicms`.`english_course`.`id`))) left join `english_student` on((`yunzhicms`.`english_student`.`klass_id` = `yunzhicms`.`english_klass`.`id`)));

-- ----------------------------
--  View structure for `english_klass_course_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_klass_course_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_klass_course_view` AS select `yunzhicms`.`english_course`.`title` AS `title`,`yunzhicms`.`english_klass_course`.`id` AS `id`,`yunzhicms`.`english_klass_course`.`klass_id` AS `klass_id`,`yunzhicms`.`english_klass_course`.`course_id` AS `course_id`,`yunzhicms`.`english_klass`.`name` AS `name` from ((`english_klass_course` join `english_klass` on((`yunzhicms`.`english_klass_course`.`klass_id` = `yunzhicms`.`english_klass`.`id`))) join `english_course` on((`yunzhicms`.`english_klass_course`.`course_id` = `yunzhicms`.`english_course`.`id`)));

-- ----------------------------
--  View structure for `english_klass_user_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_klass_user_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_klass_user_view` AS select `yunzhicms`.`english_klass`.`id` AS `id`,`yunzhicms`.`english_klass`.`name` AS `name`,`yunzhicms`.`english_user`.`name` AS `user__name`,`yunzhicms`.`english_klass`.`create_time` AS `create_time`,`yunzhicms`.`english_klass`.`user_id` AS `user_id`,`yunzhicms`.`english_department_post`.`department_id` AS `department_id`,`yunzhicms`.`english_department_post`.`post_id` AS `post_id`,`yunzhicms`.`english_department`.`title` AS `department__title`,`yunzhicms`.`english_post`.`name` AS `post__name`,`yunzhicms`.`english_department`.`is_son` AS `department__is_son`,`yunzhicms`.`english_post`.`is_son` AS `post__is_son`,`yunzhicms`.`english_post`.`is_admin` AS `post__is_admin` from ((((`english_klass` left join `english_user` on((`yunzhicms`.`english_klass`.`user_id` = `yunzhicms`.`english_user`.`id`))) left join `english_department_post` on((`yunzhicms`.`english_department_post`.`id` = `yunzhicms`.`english_user`.`department_post_id`))) left join `english_department` on((`yunzhicms`.`english_department`.`id` = `yunzhicms`.`english_department_post`.`department_id`))) left join `english_post` on((`yunzhicms`.`english_department_post`.`post_id` = `yunzhicms`.`english_post`.`id`)));

-- ----------------------------
--  View structure for `english_menu_post_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_menu_post_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_menu_post_view` AS select `yunzhicms`.`english_menu_post`.`id` AS `id`,`yunzhicms`.`english_menu_post`.`menu_id` AS `menu_id`,`yunzhicms`.`english_menu_post`.`post_id` AS `post_id`,`yunzhicms`.`english_post`.`name` AS `post__name`,`yunzhicms`.`english_post`.`id` AS `post__id`,`yunzhicms`.`english_menu_post`.`is_permission` AS `is_permission` from (`english_menu_post` left join `english_post` on((`yunzhicms`.`english_menu_post`.`post_id` = `yunzhicms`.`english_post`.`id`)));

-- ----------------------------
--  View structure for `english_new_word_word_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_new_word_word_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_new_word_word_view` AS select `yunzhicms`.`english_word`.`title` AS `word__title`,`yunzhicms`.`english_new_word`.`time` AS `time`,`yunzhicms`.`english_new_word`.`student_id` AS `student_id`,`yunzhicms`.`english_new_word`.`word_id` AS `word_id`,`yunzhicms`.`english_new_word`.`id` AS `id` from (`english_new_word` join `english_word` on((`yunzhicms`.`english_new_word`.`word_id` = `yunzhicms`.`english_word`.`id`)));

-- ----------------------------
--  View structure for `english_repeat_times_word_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_repeat_times_word_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_repeat_times_word_view` AS select `yunzhicms`.`english_repeat_times`.`id` AS `id`,`yunzhicms`.`english_repeat_times`.`times` AS `times`,`yunzhicms`.`english_repeat_times`.`word_id` AS `word_id`,`yunzhicms`.`english_repeat_times`.`student_id` AS `student_id`,`yunzhicms`.`english_word`.`id` AS `word__id`,`yunzhicms`.`english_word`.`course_id` AS `word__course_id` from (`english_repeat_times` join `english_word` on((`yunzhicms`.`english_word`.`id` = `yunzhicms`.`english_repeat_times`.`word_id`)));

-- ----------------------------
--  View structure for `english_test_student_test_percent_course_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_test_student_test_percent_course_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_test_student_test_percent_course_view` AS select `yunzhicms`.`english_course`.`id` AS `course__id`,`yunzhicms`.`english_student`.`id` AS `student__id`,`yunzhicms`.`english_test`.`id` AS `id`,`yunzhicms`.`english_test`.`grade` AS `grade`,`yunzhicms`.`english_test_percent`.`percent` AS `percent`,`yunzhicms`.`english_test_percent`.`type` AS `type`,`yunzhicms`.`english_test`.`time` AS `time`,`yunzhicms`.`english_course`.`title` AS `course__title` from (((`english_test` left join `english_student` on((`yunzhicms`.`english_test`.`student_id` = `yunzhicms`.`english_student`.`id`))) left join `english_test_percent` on((`yunzhicms`.`english_test`.`test_percent_id` = `yunzhicms`.`english_test_percent`.`id`))) left join `english_course` on((`yunzhicms`.`english_test_percent`.`course_id` = `yunzhicms`.`english_course`.`id`)));

-- ----------------------------
--  View structure for `english_test_test_percent_course_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_test_test_percent_course_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_test_test_percent_course_view` AS select `yunzhicms`.`english_test`.`id` AS `id`,`yunzhicms`.`english_test`.`time` AS `time`,`yunzhicms`.`english_test`.`grade` AS `grade`,`yunzhicms`.`english_test`.`student_id` AS `student_id`,`yunzhicms`.`english_test`.`test_percent_id` AS `test_percent_id`,`yunzhicms`.`english_test_percent`.`type` AS `type`,`yunzhicms`.`english_test_percent`.`percent` AS `percent`,`yunzhicms`.`english_test_percent`.`course_id` AS `course_id`,`yunzhicms`.`english_course`.`title` AS `course__title` from ((`english_test` left join `english_test_percent` on((`yunzhicms`.`english_test`.`test_percent_id` = `yunzhicms`.`english_test_percent`.`id`))) left join `english_course` on((`yunzhicms`.`english_test_percent`.`course_id` = `yunzhicms`.`english_course`.`id`)));

-- ----------------------------
--  View structure for `english_user_department_post_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_user_department_post_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_user_department_post_view` AS select `yunzhicms`.`english_department`.`title` AS `department__title`,`yunzhicms`.`english_department`.`is_son` AS `department__is_son`,`yunzhicms`.`english_post`.`name` AS `post__title`,`yunzhicms`.`english_post`.`is_son` AS `post__is_son`,`yunzhicms`.`english_user`.`id` AS `id`,`yunzhicms`.`english_user`.`username` AS `username`,`yunzhicms`.`english_user`.`name` AS `name`,`yunzhicms`.`english_user`.`phonenumber` AS `phonenumber`,`yunzhicms`.`english_user`.`email` AS `email`,`yunzhicms`.`english_department_post`.`department_id` AS `department_id`,`yunzhicms`.`english_department_post`.`post_id` AS `post_id`,`yunzhicms`.`english_post`.`is_admin` AS `post__is_admin` from (((`english_user` left join `english_department_post` on((`yunzhicms`.`english_user`.`department_post_id` = `yunzhicms`.`english_department_post`.`id`))) left join `english_department` on((`yunzhicms`.`english_department_post`.`department_id` = `yunzhicms`.`english_department`.`id`))) left join `english_post` on((`yunzhicms`.`english_department_post`.`post_id` = `yunzhicms`.`english_post`.`id`)));

-- ----------------------------
--  View structure for `english_user_klass_student_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_user_klass_student_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_user_klass_student_view` AS select `yunzhicms`.`english_student`.`id` AS `id`,`yunzhicms`.`english_student`.`name` AS `name`,`yunzhicms`.`english_klass`.`id` AS `klass__id`,`yunzhicms`.`english_klass`.`name` AS `klass__name`,`yunzhicms`.`english_user`.`id` AS `user__id`,`yunzhicms`.`english_user`.`name` AS `user__name`,`yunzhicms`.`english_department`.`id` AS `department__id`,`yunzhicms`.`english_department`.`is_son` AS `department__is_son`,`yunzhicms`.`english_post`.`id` AS `post__id`,`yunzhicms`.`english_post`.`is_admin` AS `post__is_admin`,`yunzhicms`.`english_student`.`status` AS `status`,`yunzhicms`.`english_student`.`username` AS `username`,`yunzhicms`.`english_student`.`creation_date` AS `creation_date`,`yunzhicms`.`english_student`.`user_id` AS `user_id` from (((((`english_student` left join `english_klass` on((`yunzhicms`.`english_klass`.`id` = `yunzhicms`.`english_student`.`klass_id`))) left join `english_user` on((`yunzhicms`.`english_user`.`id` = `yunzhicms`.`english_klass`.`user_id`))) left join `english_department_post` on((`yunzhicms`.`english_department_post`.`id` = `yunzhicms`.`english_user`.`department_post_id`))) left join `english_department` on((`yunzhicms`.`english_department`.`id` = `yunzhicms`.`english_department_post`.`department_id`))) left join `english_post` on((`yunzhicms`.`english_post`.`id` = `yunzhicms`.`english_department_post`.`post_id`)));

-- ----------------------------
--  View structure for `english_user_menu_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_user_menu_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_user_menu_view` AS select `yunzhicms`.`english_user`.`id` AS `id`,`yunzhicms`.`english_user`.`name` AS `name`,`yunzhicms`.`english_department_post`.`post_id` AS `post_id`,`yunzhicms`.`english_menu_post`.`menu_id` AS `menu_id` from ((`english_user` left join `english_department_post` on((`yunzhicms`.`english_user`.`department_post_id` = `yunzhicms`.`english_department_post`.`id`))) left join `english_menu_post` on((`yunzhicms`.`english_department_post`.`post_id` = `yunzhicms`.`english_menu_post`.`post_id`)));

-- ----------------------------
--  View structure for `english_word_progress_login_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_word_progress_login_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_word_progress_login_view` AS select `yunzhicms`.`english_word_progress`.`id` AS `id`,`yunzhicms`.`english_word_progress`.`time` AS `time`,`yunzhicms`.`english_word_progress`.`is_new` AS `is_new`,`yunzhicms`.`english_word_progress`.`word_id` AS `word_id`,`yunzhicms`.`english_word_progress`.`login_id` AS `login_id`,`yunzhicms`.`english_login`.`time` AS `login__time`,`yunzhicms`.`english_login`.`student_id` AS `student_id`,`yunzhicms`.`english_student`.`name` AS `student__name` from ((`english_word_progress` left join `english_login` on((`yunzhicms`.`english_word_progress`.`login_id` = `yunzhicms`.`english_login`.`id`))) left join `english_student` on((`yunzhicms`.`english_student`.`id` = `yunzhicms`.`english_login`.`student_id`)));

-- ----------------------------
--  View structure for `english_word_progress_login_word_course_view`
-- ----------------------------
DROP VIEW IF EXISTS `english_word_progress_login_word_course_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`english_study`@`%` SQL SECURITY DEFINER VIEW `english_word_progress_login_word_course_view` AS select `yunzhicms`.`english_word_progress`.`id` AS `id`,`yunzhicms`.`english_word_progress`.`word_id` AS `word_id`,`yunzhicms`.`english_word`.`title` AS `word__title`,`yunzhicms`.`english_word_progress`.`login_id` AS `login_id`,`yunzhicms`.`english_word`.`course_id` AS `word__course_id`,`yunzhicms`.`english_login`.`time` AS `login__time`,`yunzhicms`.`english_login`.`student_id` AS `login__student_id`,`yunzhicms`.`english_course`.`title` AS `course__title`,`yunzhicms`.`english_word_progress`.`is_new` AS `is_new`,`yunzhicms`.`english_word_progress`.`time` AS `time` from (((`english_word_progress` left join `english_word` on((`yunzhicms`.`english_word_progress`.`word_id` = `yunzhicms`.`english_word`.`id`))) left join `english_login` on((`yunzhicms`.`english_word_progress`.`login_id` = `yunzhicms`.`english_login`.`id`))) left join `english_course` on((`yunzhicms`.`english_word`.`course_id` = `yunzhicms`.`english_course`.`id`)));

SET FOREIGN_KEY_CHECKS = 1;
