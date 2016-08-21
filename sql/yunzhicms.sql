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

 Date: 08/21/2016 10:46:08 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `yunzhi_block`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_block`;
CREATE TABLE `yunzhi_block` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk moudle',
  `position_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'fk position',
  `title` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0启用 1禁用',
  `weight` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `config` varchar(255) NOT NULL DEFAULT '[]' COMMENT '配置信息json',
  `filter` varchar(255) NOT NULL DEFAULT '[]' COMMENT '过滤器信息json',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_block`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_block` VALUES ('1', 'menu', 'menu', '主菜单', '显示在页面上方', '0', '0', '[]', '[]');
COMMIT;

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
--  Records of `yunzhi_category`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_category` VALUES ('news', '[]', '', '新闻通知', '新闻通知', '0', '0', '[]'), ('products', '[]', '', '产品列表', '', '0', '0', '[]');
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
  `config` varchar(255) NOT NULL DEFAULT '[]' COMMENT '配置信息',
  `filter` varchar(255) NOT NULL DEFAULT '[]' COMMENT '字段过滤信息',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_component`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_component` VALUES ('Home', '首页', '用于显示首页', 'panjie', '1.0.0', '{\"count\":{\"description\":\"\\u663e\\u793a\\u65b0\\u95fb\\u7684\\u6761\\u6570\",\"type\":\"text\",\"value\":3}}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":6,\"etc\":\"..\"}}}'), ('ContentList', '新闻列表', '新闻列表页，显示新闻列表及展示新闻详情', 'panjie', '1.0.0', '', '[]');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_content`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_content`;
CREATE TABLE `yunzhi_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 用户名',
  `category_name` varchar(40) NOT NULL DEFAULT '' COMMENT 'FK 类别名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `create_time` int(5) unsigned NOT NULL DEFAULT '0',
  `update_time` int(5) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(5) unsigned NOT NULL DEFAULT '0',
  `is_freezed` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否冻结',
  `weight` smallint(6) NOT NULL,
  `hit` int(11) NOT NULL,
  `access_group` varchar(255) NOT NULL DEFAULT '[]' COMMENT '权限列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_content`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_content` VALUES ('1', '', 'news', '这是一条新闻', '0', '0', '0', '0', '0', '0', '[]'), ('2', '', 'news', '这是另一条新闻', '0', '0', '0', '0', '0', '0', '[]'), ('3', '', 'products', ' 这是一个产品的新闻', '0', '0', '0', '0', '0', '0', '[]');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_content_frontpage`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_content_frontpage` VALUES ('1', '0', '0'), ('2', '2', '0'), ('3', '1', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_config`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_config`;
CREATE TABLE `yunzhi_field_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a field',
  `field_name` varchar(32) NOT NULL COMMENT 'The name of this field. Non-deleted field names are unique, but multiple deleted fields can have the same name.',
  `type` varchar(128) NOT NULL COMMENT 'The type of this field.',
  `module` varchar(128) NOT NULL DEFAULT '' COMMENT 'The module that implements the field type.',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Boolean indicating whether the module that implements the field type is enabled.',
  `storage_type` varchar(128) NOT NULL COMMENT 'The storage backend for the field.',
  `storage_module` varchar(128) NOT NULL DEFAULT '' COMMENT 'The module that implements the storage backend.',
  `storage_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Boolean indicating whether the module that implements the storage backend is enabled.',
  `locked` tinyint(4) NOT NULL DEFAULT '0' COMMENT '@TODO',
  `data` longblob NOT NULL COMMENT 'Serialized data containing the field properties that do not warrant a dedicated column.',
  `cardinality` tinyint(4) NOT NULL DEFAULT '0',
  `translatable` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `field_name` (`field_name`),
  KEY `active` (`active`),
  KEY `storage_active` (`storage_active`),
  KEY `deleted` (`deleted`),
  KEY `module` (`module`),
  KEY `storage_module` (`storage_module`),
  KEY `type` (`type`),
  KEY `storage_type` (`storage_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_field_config`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_config` VALUES ('1', 'comment_body', 'text_long', 'text', '1', 'field_sql_storage', 'field_sql_storage', '1', '0', 0x613a363a7b733a31323a22656e746974795f7479706573223b613a313a7b693a303b733a373a22636f6d6d656e74223b7d733a31323a227472616e736c617461626c65223b623a303b733a383a2273657474696e6773223b613a303a7b7d733a373a2273746f72616765223b613a343a7b733a343a2274797065223b733a31373a226669656c645f73716c5f73746f72616765223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a31373a226669656c645f73716c5f73746f72616765223b733a363a22616374697665223b693a313b7d733a31323a22666f726569676e206b657973223b613a313a7b733a363a22666f726d6174223b613a323a7b733a353a227461626c65223b733a31333a2266696c7465725f666f726d6174223b733a373a22636f6c756d6e73223b613a313a7b733a363a22666f726d6174223b733a363a22666f726d6174223b7d7d7d733a373a22696e6465786573223b613a313a7b733a363a22666f726d6174223b613a313a7b693a303b733a363a22666f726d6174223b7d7d7d, '1', '0', '0'), ('2', 'body', 'text_with_summary', 'text', '1', 'field_sql_storage', 'field_sql_storage', '1', '0', 0x613a363a7b733a31323a22656e746974795f7479706573223b613a313a7b693a303b733a343a226e6f6465223b7d733a31323a227472616e736c617461626c65223b623a303b733a383a2273657474696e6773223b613a303a7b7d733a373a2273746f72616765223b613a343a7b733a343a2274797065223b733a31373a226669656c645f73716c5f73746f72616765223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a31373a226669656c645f73716c5f73746f72616765223b733a363a22616374697665223b693a313b7d733a31323a22666f726569676e206b657973223b613a313a7b733a363a22666f726d6174223b613a323a7b733a353a227461626c65223b733a31333a2266696c7465725f666f726d6174223b733a373a22636f6c756d6e73223b613a313a7b733a363a22666f726d6174223b733a363a22666f726d6174223b7d7d7d733a373a22696e6465786573223b613a313a7b733a363a22666f726d6174223b613a313a7b693a303b733a363a22666f726d6174223b7d7d7d, '1', '0', '0'), ('3', 'field_tags', 'taxonomy_term_reference', 'taxonomy', '1', 'field_sql_storage', 'field_sql_storage', '1', '0', 0x613a363a7b733a383a2273657474696e6773223b613a313a7b733a31343a22616c6c6f7765645f76616c756573223b613a313a7b693a303b613a323a7b733a31303a22766f636162756c617279223b733a343a2274616773223b733a363a22706172656e74223b693a303b7d7d7d733a31323a22656e746974795f7479706573223b613a303a7b7d733a31323a227472616e736c617461626c65223b623a303b733a373a2273746f72616765223b613a343a7b733a343a2274797065223b733a31373a226669656c645f73716c5f73746f72616765223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a31373a226669656c645f73716c5f73746f72616765223b733a363a22616374697665223b693a313b7d733a31323a22666f726569676e206b657973223b613a313a7b733a333a22746964223b613a323a7b733a353a227461626c65223b733a31383a227461786f6e6f6d795f7465726d5f64617461223b733a373a22636f6c756d6e73223b613a313a7b733a333a22746964223b733a333a22746964223b7d7d7d733a373a22696e6465786573223b613a313a7b733a333a22746964223b613a313a7b693a303b733a333a22746964223b7d7d7d, '-1', '0', '0'), ('4', 'field_image', 'image', 'image', '1', 'field_sql_storage', 'field_sql_storage', '1', '0', 0x613a363a7b733a373a22696e6465786573223b613a313a7b733a333a22666964223b613a313a7b693a303b733a333a22666964223b7d7d733a383a2273657474696e6773223b613a323a7b733a31303a227572695f736368656d65223b733a363a227075626c6963223b733a31333a2264656661756c745f696d616765223b623a303b7d733a373a2273746f72616765223b613a343a7b733a343a2274797065223b733a31373a226669656c645f73716c5f73746f72616765223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a31373a226669656c645f73716c5f73746f72616765223b733a363a22616374697665223b693a313b7d733a31323a22656e746974795f7479706573223b613a303a7b7d733a31323a227472616e736c617461626c65223b623a303b733a31323a22666f726569676e206b657973223b613a313a7b733a333a22666964223b613a323a7b733a353a227461626c65223b733a31323a2266696c655f6d616e61676564223b733a373a22636f6c756d6e73223b613a313a7b733a333a22666964223b733a333a22666964223b7d7d7d7d, '1', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_config_instance`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_config_instance`;
CREATE TABLE `yunzhi_field_config_instance` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a field instance',
  `field_id` int(11) NOT NULL COMMENT 'The identifier of the field attached by this instance',
  `field_name` varchar(32) NOT NULL DEFAULT '',
  `entity_type` varchar(32) NOT NULL DEFAULT '',
  `bundle` varchar(128) NOT NULL DEFAULT '',
  `data` longblob NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `field_name_bundle` (`field_name`,`entity_type`,`bundle`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_field_config_instance`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_config_instance` VALUES ('1', '1', 'comment_body', 'comment', 'comment_node_page', 0x613a363a7b733a353a226c6162656c223b733a373a22436f6d6d656e74223b733a383a2273657474696e6773223b613a323a7b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a383a227265717569726564223b623a313b733a373a22646973706c6179223b613a313a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a363a22776569676874223b693a303b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b7d7d733a363a22776964676574223b613a343a7b733a343a2274797065223b733a31333a22746578745f7465787461726561223b733a383a2273657474696e6773223b613a313a7b733a343a22726f7773223b693a353b7d733a363a22776569676874223b693a303b733a363a226d6f64756c65223b733a343a2274657874223b7d733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('2', '2', 'body', 'node', 'page', 0x613a363a7b733a353a226c6162656c223b733a343a22426f6479223b733a363a22776964676574223b613a343a7b733a343a2274797065223b733a32363a22746578745f74657874617265615f776974685f73756d6d617279223b733a383a2273657474696e6773223b613a323a7b733a343a22726f7773223b693a32303b733a31323a2273756d6d6172795f726f7773223b693a353b7d733a363a22776569676874223b693a2d343b733a363a226d6f64756c65223b733a343a2274657874223b7d733a383a2273657474696e6773223b613a333a7b733a31353a22646973706c61795f73756d6d617279223b623a313b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a373a22646973706c6179223b613a323a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d733a363a22746561736572223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a32333a22746578745f73756d6d6172795f6f725f7472696d6d6564223b733a383a2273657474696e6773223b613a313a7b733a31313a227472696d5f6c656e677468223b693a3630303b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d7d733a383a227265717569726564223b623a303b733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('3', '1', 'comment_body', 'comment', 'comment_node_article', 0x613a363a7b733a353a226c6162656c223b733a373a22436f6d6d656e74223b733a383a2273657474696e6773223b613a323a7b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a383a227265717569726564223b623a313b733a373a22646973706c6179223b613a313a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a363a22776569676874223b693a303b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b7d7d733a363a22776964676574223b613a343a7b733a343a2274797065223b733a31333a22746578745f7465787461726561223b733a383a2273657474696e6773223b613a313a7b733a343a22726f7773223b693a353b7d733a363a22776569676874223b693a303b733a363a226d6f64756c65223b733a343a2274657874223b7d733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('4', '2', 'body', 'node', 'article', 0x613a363a7b733a353a226c6162656c223b733a343a22426f6479223b733a363a22776964676574223b613a343a7b733a343a2274797065223b733a32363a22746578745f74657874617265615f776974685f73756d6d617279223b733a383a2273657474696e6773223b613a323a7b733a343a22726f7773223b693a32303b733a31323a2273756d6d6172795f726f7773223b693a353b7d733a363a22776569676874223b693a2d343b733a363a226d6f64756c65223b733a343a2274657874223b7d733a383a2273657474696e6773223b613a333a7b733a31353a22646973706c61795f73756d6d617279223b623a313b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a373a22646973706c6179223b613a323a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d733a363a22746561736572223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a32333a22746578745f73756d6d6172795f6f725f7472696d6d6564223b733a383a2273657474696e6773223b613a313a7b733a31313a227472696d5f6c656e677468223b693a3630303b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d7d733a383a227265717569726564223b623a303b733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('5', '3', 'field_tags', 'node', 'article', 0x613a363a7b733a353a226c6162656c223b733a343a2254616773223b733a31313a226465736372697074696f6e223b733a35373a22e8be93e585a5e4b880e58897e58d95e8af8de4bba5e68f8fe8bfb0e682a8e79a84e58685e5aeb9e5b9b6e794a8e98097e58fb7e99a94e5bc80223b733a363a22776964676574223b613a343a7b733a343a2274797065223b733a32313a227461786f6e6f6d795f6175746f636f6d706c657465223b733a363a22776569676874223b693a2d343b733a383a2273657474696e6773223b613a323a7b733a343a2273697a65223b693a36303b733a31373a226175746f636f6d706c6574655f70617468223b733a32313a227461786f6e6f6d792f6175746f636f6d706c657465223b7d733a363a226d6f64756c65223b733a383a227461786f6e6f6d79223b7d733a373a22646973706c6179223b613a323a7b733a373a2264656661756c74223b613a353a7b733a343a2274797065223b733a32383a227461786f6e6f6d795f7465726d5f7265666572656e63655f6c696e6b223b733a363a22776569676874223b693a31303b733a353a226c6162656c223b733a353a2261626f7665223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a383a227461786f6e6f6d79223b7d733a363a22746561736572223b613a353a7b733a343a2274797065223b733a32383a227461786f6e6f6d795f7465726d5f7265666572656e63655f6c696e6b223b733a363a22776569676874223b693a31303b733a353a226c6162656c223b733a353a2261626f7665223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a383a227461786f6e6f6d79223b7d7d733a383a2273657474696e6773223b613a313a7b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a383a227265717569726564223b623a303b7d, '0'), ('6', '4', 'field_image', 'node', 'article', 0x613a363a7b733a353a226c6162656c223b733a353a22496d616765223b733a31313a226465736372697074696f6e223b733a33363a22e4b8bae8bf99e7af87e69687e7aba0e4b88ae4bca0e4b880e4b8aae59bbee78987e38082223b733a383a227265717569726564223b623a303b733a383a2273657474696e6773223b613a393a7b733a31343a2266696c655f6469726563746f7279223b733a31313a226669656c642f696d616765223b733a31353a2266696c655f657874656e73696f6e73223b733a31363a22706e6720676966206a7067206a706567223b733a31323a226d61785f66696c6573697a65223b733a303a22223b733a31343a226d61785f7265736f6c7574696f6e223b733a303a22223b733a31343a226d696e5f7265736f6c7574696f6e223b733a303a22223b733a393a22616c745f6669656c64223b623a313b733a31313a227469746c655f6669656c64223b733a303a22223b733a31333a2264656661756c745f696d616765223b693a303b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a363a22776964676574223b613a343a7b733a343a2274797065223b733a31313a22696d6167655f696d616765223b733a383a2273657474696e6773223b613a323a7b733a31383a2270726f67726573735f696e64696361746f72223b733a383a227468726f62626572223b733a31393a22707265766965775f696d6167655f7374796c65223b733a393a227468756d626e61696c223b7d733a363a22776569676874223b693a2d313b733a363a226d6f64756c65223b733a353a22696d616765223b7d733a373a22646973706c6179223b613a323a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a353a22696d616765223b733a383a2273657474696e6773223b613a323a7b733a31313a22696d6167655f7374796c65223b733a353a226c61726765223b733a31303a22696d6167655f6c696e6b223b733a303a22223b7d733a363a22776569676874223b693a2d313b733a363a226d6f64756c65223b733a353a22696d616765223b7d733a363a22746561736572223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a353a22696d616765223b733a383a2273657474696e6773223b613a323a7b733a31313a22696d6167655f7374796c65223b733a363a226d656469756d223b733a31303a22696d6167655f6c696e6b223b733a373a22636f6e74656e74223b7d733a363a22776569676874223b693a2d313b733a363a226d6f64756c65223b733a353a22696d616765223b7d7d7d, '0'), ('7', '1', 'comment_body', 'comment', 'comment_node_aboutus', 0x613a363a7b733a353a226c6162656c223b733a373a22436f6d6d656e74223b733a383a2273657474696e6773223b613a323a7b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a383a227265717569726564223b623a313b733a373a22646973706c6179223b613a313a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a363a22776569676874223b693a303b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b7d7d733a363a22776964676574223b613a343a7b733a343a2274797065223b733a31333a22746578745f7465787461726561223b733a383a2273657474696e6773223b613a313a7b733a343a22726f7773223b693a353b7d733a363a22776569676874223b693a303b733a363a226d6f64756c65223b733a343a2274657874223b7d733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('8', '2', 'body', 'node', 'aboutus', 0x613a363a7b733a353a226c6162656c223b733a343a22426f6479223b733a363a22776964676574223b613a343a7b733a343a2274797065223b733a32363a22746578745f74657874617265615f776974685f73756d6d617279223b733a383a2273657474696e6773223b613a323a7b733a343a22726f7773223b693a32303b733a31323a2273756d6d6172795f726f7773223b693a353b7d733a363a22776569676874223b693a2d343b733a363a226d6f64756c65223b733a343a2274657874223b7d733a383a2273657474696e6773223b613a333a7b733a31353a22646973706c61795f73756d6d617279223b623a313b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a373a22646973706c6179223b613a323a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d733a363a22746561736572223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a32333a22746578745f73756d6d6172795f6f725f7472696d6d6564223b733a383a2273657474696e6773223b613a313a7b733a31313a227472696d5f6c656e677468223b693a3630303b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d7d733a383a227265717569726564223b623a303b733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('9', '1', 'comment_body', 'comment', 'comment_node_news', 0x613a363a7b733a353a226c6162656c223b733a373a22436f6d6d656e74223b733a383a2273657474696e6773223b613a323a7b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a383a227265717569726564223b623a313b733a373a22646973706c6179223b613a313a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a363a22776569676874223b693a303b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b7d7d733a363a22776964676574223b613a343a7b733a343a2274797065223b733a31333a22746578745f7465787461726561223b733a383a2273657474696e6773223b613a313a7b733a343a22726f7773223b693a353b7d733a363a22776569676874223b693a303b733a363a226d6f64756c65223b733a343a2274657874223b7d733a31313a226465736372697074696f6e223b733a303a22223b7d, '0'), ('10', '2', 'body', 'node', 'news', 0x613a363a7b733a353a226c6162656c223b733a343a22426f6479223b733a363a22776964676574223b613a343a7b733a343a2274797065223b733a32363a22746578745f74657874617265615f776974685f73756d6d617279223b733a383a2273657474696e6773223b613a323a7b733a343a22726f7773223b693a32303b733a31323a2273756d6d6172795f726f7773223b693a353b7d733a363a22776569676874223b693a2d343b733a363a226d6f64756c65223b733a343a2274657874223b7d733a383a2273657474696e6773223b613a333a7b733a31353a22646973706c61795f73756d6d617279223b623a313b733a31353a22746578745f70726f63657373696e67223b693a313b733a31383a22757365725f72656769737465725f666f726d223b623a303b7d733a373a22646973706c6179223b613a323a7b733a373a2264656661756c74223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a31323a22746578745f64656661756c74223b733a383a2273657474696e6773223b613a303a7b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d733a363a22746561736572223b613a353a7b733a353a226c6162656c223b733a363a2268696464656e223b733a343a2274797065223b733a32333a22746578745f73756d6d6172795f6f725f7472696d6d6564223b733a383a2273657474696e6773223b613a313a7b733a31313a227472696d5f6c656e677468223b693a3630303b7d733a363a226d6f64756c65223b733a343a2274657874223b733a363a22776569676874223b693a303b7d7d733a383a227265717569726564223b623a303b733a31313a226465736372697074696f6e223b733a303a22223b7d, '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_field_data_body`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_field_data_body`;
CREATE TABLE `yunzhi_field_data_body` (
  `entity_type` varchar(128) NOT NULL DEFAULT '' COMMENT 'The entity type this data is attached to',
  `bundle` varchar(128) NOT NULL DEFAULT '' COMMENT 'The field instance bundle to which this row belongs, used when deleting a field instance',
  `deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'A boolean indicating whether this data item has been deleted',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'The entity id this data is attached to',
  `revision_id` int(10) unsigned DEFAULT NULL COMMENT 'The entity revision id this data is attached to, or NULL if the entity type is not versioned',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT 'The language for this data item.',
  `delta` int(10) unsigned NOT NULL COMMENT 'The sequence number for this data item, used for multi-value fields',
  `body_value` longtext,
  `body_summary` longtext,
  `body_format` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`entity_type`,`entity_id`,`deleted`,`delta`,`language`),
  KEY `entity_type` (`entity_type`),
  KEY `bundle` (`bundle`),
  KEY `deleted` (`deleted`),
  KEY `entity_id` (`entity_id`),
  KEY `revision_id` (`revision_id`),
  KEY `language` (`language`),
  KEY `body_format` (`body_format`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Data storage for field 2 (body)';

-- ----------------------------
--  Records of `yunzhi_field_data_body`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_field_data_body` VALUES ('node', 'page', '0', '1', '1', 'und', '0', '这里是关于我们的主题', '这里是关于我们的摘要', 'filtered_html'), ('node', 'news', '0', '2', '2', 'und', '0', '新闻通知1新闻通知1新闻通知1新闻通知1新闻通知1', '', 'filtered_html'), ('node', 'news', '0', '3', '3', 'und', '0', '新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2新闻通知2', '', 'filtered_html');
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
INSERT INTO `yunzhi_menu` VALUES ('1', 'main', 'Home', '首页', '0', '/', '0', '0', '首页', '{\"count\":3}', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":6,\"etc\":\"..\"}}}', '1'), ('2', 'main', 'ContentList', '新闻通知', '0', 'news', '0', '0', '', '[]', '[]', '0'), ('3', 'main', 'ContentList', '院级新闻', '2', 'school', '0', '0', '', '[]', '[]', '0');
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

-- ----------------------------
--  Table structure for `yunzhi_module`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_module`;
CREATE TABLE `yunzhi_module` (
  `name` varchar(40) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `config` varchar(255) NOT NULL DEFAULT '[]',
  `filter` varchar(255) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_module`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_module` VALUES ('menu', '菜单', '显示菜单', '[]', '[]');
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
