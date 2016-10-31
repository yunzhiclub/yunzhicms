/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : yunzhicms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-30 11:13:32
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
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `list` (`weight`,`is_delete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COMMENT='菜单表（每一个菜单对应唯一的一个组件）';

-- ----------------------------
-- Records of yunzhi_menu
-- ----------------------------
INSERT INTO `yunzhi_menu` VALUES ('1', 'main', 'Home', '学院概况', '0', '', '0', '400', '', '', '', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('2', 'main', 'ContentList', '机构设置', '0', 'institutional', '0', '20', '这里是描述信息', '[]', '{\"title\":{\"type\":\"String\",\"function\":\"substr\",\"param\":{\"length\":\"30\",\"ext\":\"...\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]},\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('4', 'main', 'ContentList', '教育教学', '0', 'eduction', '0', '22', '测试', '{\"id\":\"1\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"Y-m-d\"}}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('5', 'main', 'ContentList', '科学研究', '0', 'since', '0', '22', '用于显示首页链接过来的新闻', '{\"contentType\":\"news\",\"count\":\"1\",\"order\":\"weight desc, id desc\"}', '{\"date\":{\"type\":\"Date\",\"function\":\"format\",\"param\":{\"dateFormat\":\"m-d\"}},\"href\":{\"type\":\"System\",\"function\":\"makeCurrentMenuReadUrl\",\"param\":[]}}', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('6', 'main', 'ContentList', '党群工作', '0', 'party_work', '0', '78', '用于用户登陆与注销', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('7', 'main', 'ContentList', '团学工作', '0', 'league_work', '0', '12', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('8', 'main', 'ContentList', '校友工作', '0', 'alumni_work', '0', '85', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('9', 'main', 'ContentList', '招生招聘', '0', 'admissions', '0', '7', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('10', 'main', 'ContentList', '院务公开', '0', 'open_hospital_affairs', '0', '8', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('11', 'main', 'ContentList', '国际交流', '0', 'international', '0', '8', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('12', 'main', 'ContentList', '学院文化', '1', 'news/culture', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('13', 'main', 'ContentList', '历史沿革', '1', 'news', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('14', 'main', 'ContentList', '学院领导', '1', 'news', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('15', 'main', 'ContentList', '学院简介', '1', 'news', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('16', 'main', 'ContentList', '历任领导', '14', 'news', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('17', 'main', 'ContentList', '现任领导', '14', 'news', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('18', 'main', 'ContentList', '委员会', '2', 'institutional/committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('19', 'main', 'ContentList', '管理机构', '2', 'institutional/management', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('20', 'main', 'ContentList', '系部中心', '2', 'institutional/department_centers', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('21', 'main', 'ContentList', '计算机实验中心', '20', 'institutional/department_centers/computer_laboratory_center', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('22', 'main', 'ContentList', '基础教学部', '20', 'institutional/department_centers/basic_education', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('23', 'main', 'ContentList', '物联网工程系', '20', 'institutional/department_centers/things_engineer', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('24', 'main', 'ContentList', '软件工程系', '20', 'institutional/department_centers/software_engineer', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('25', 'main', 'ContentList', '网络工程系', '20', 'institutional/department_centers/network_engineer', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('26', 'main', 'ContentList', '计算机科学与技术系', '20', 'institutional/department_centers/computer_science_technology', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('27', 'main', 'ContentList', '学生发展规划办公室', '19', 'institutional/management/stu_develop_office', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('28', 'main', 'ContentList', '学科建设办公室', '19', 'institutional/management/discipline_office', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('29', 'main', 'ContentList', '教学运行办公室', '19', 'institutional/management/teach_operat_office', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('30', 'main', 'ContentList', '协同创新办公室', '19', 'institutional/management/collaborat_office', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('31', 'main', 'ContentList', '院团委', '19', 'institutional/management/house_committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('32', 'main', 'ContentList', '学院办公室', '19', 'institutional/management/college_office', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('34', 'main', 'ContentList', '深化改革咨询委员会', '18', 'institutional/committee /deep _reform_advisory_committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('35', 'main', 'ContentList', '政治思想文化咨询委员会', '18', 'institutional/committee/political_thought_culture_committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('36', 'main', 'ContentList', '学科建设咨询委员会', '18', 'institutional/committee/discipline_construction_committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('37', 'main', 'ContentList', '学位委员会', '18', 'institutional/committee/degree_committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('38', 'main', 'ContentList', '学术委员会', '18', 'institutional/committee/academic_committee', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('39', 'main', 'ContentList', '研究生', '4', 'eduction/postgraduate', '0', '156416546', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('40', 'main', 'ContentList', '本科生', '4', 'eduction/undergraduate', '0', '254532453', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('41', 'main', 'ContentList', '常用下载', '40', 'eduction/undergraduate/common_download', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('42', 'main', 'ContentList', '培养方向', '40', 'eduction/undergraduate/train_direction', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('43', 'main', 'ContentList', '专业介绍', '40', 'eduction/undergraduate/profes_present', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('44', 'main', 'ContentList', '就业工作', '39', 'eduction/postgraduate/employment', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('45', 'main', 'ContentList', '培养工作', '39', 'eduction/postgraduate/job_train', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('46', 'main', 'ContentList', '招生目录', '39', 'eduction/postgraduate/directory_admission', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('47', 'main', 'ContentList', '学科方向', '39', 'eduction/postgraduate/subject_orient', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('48', 'main', 'ContentList', '学术交流', '5', 'since/academic_exchange', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('49', 'main', 'ContentList', '科研成果', '5', 'since/science_research', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('50', 'main', 'ContentList', '科研机构', '5', 'since/research_institutions', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('51', 'main', 'ContentList', '研究所', '50', 'since/research_institutions/graduate_school', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('52', 'main', 'ContentList', '重点实验室', '50', 'since/research_institutions/main_lab', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('53', 'main', 'ContentList', '标志性成果', '49', 'since/science_research/landmark_achievement', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('54', 'main', 'ContentList', '科研合作', '48', 'since/academic_exchange/research_cooperation', '0', '45252', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('55', 'main', 'ContentList', '学术报告', '48', 'since/academic_exchange/academic_report', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('56', 'main', 'ContentList', '党员活动', '60', 'party_work/Party_Build/party_activities', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('57', 'main', 'ContentList', '优秀党员', '60', 'party_work/Party_Build/outstand_member', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('58', 'main', 'ContentList', '党员发展', '60', 'party_work/Party_Build/party_develop', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('59', 'main', 'ContentList', '组织概况', '60', 'party_work/Party_Build/organization_overview', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('60', 'main', 'ContentList', '党建工作', '6', 'party_work/Party_Build', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('61', 'main', 'ContentList', '工会工作', '6', 'party_work/trade_union_work', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('62', 'main', 'ContentList', '工会动态', '61', 'party_work/trade_union_work/dynamic_union', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('63', 'main', 'ContentList', '工会概况', '61', 'party_work/trade_union_work/trade_union', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('65', 'main', 'ContentList', '服务指南', '7', 'league_work/service_guide', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('66', 'main', 'ContentList', '优秀学生作品展', '7', 'league_work/excellent_stu_exhibition', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('67', 'main', 'ContentList', '班导师', '7', 'league_work/tutor', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('68', 'main', 'ContentList', '学生事务', '7', 'league_work/stu_affairs', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('69', 'main', 'ContentList', '就业创业', '7', 'league_work/employment_entrepreneurship', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('70', 'main', 'ContentList', '专业兴趣小组', '7', 'league_work/profes_interest_group', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('71', 'main', 'ContentList', ' 新生夏令营', '7', 'league_work/freshmen_camp', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('72', 'main', 'ContentList', '志愿服务', '7', 'league_work/volunteer_service', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('73', 'main', 'ContentList', '社会实践', '7', 'league_work/social_practice', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('74', 'main', 'ContentList', '科技创新', '7', 'league_work/technological_innovation', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('75', 'main', 'ContentList', '组织机构', '7', 'league_work/organization', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('76', 'main', 'ContentList', '社团', '75', 'league_work/organization/associations', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('77', 'main', 'ContentList', '大学生创新创业实践中心', '75', 'league_work/organization/innovation_stu_center', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('78', 'main', 'ContentList', '学生会', '75', 'league_work/organization/stu', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('79', 'main', 'ContentList', '团委', '75', 'league_work/organization/youth_league', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('80', 'main', 'ContentList', '学工组', '75', 'league_work/organization/science_engineer_group', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('81', 'main', 'ContentList', '获奖名单', '74', 'league_work/technological_innovation/winners', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('82', 'main', 'ContentList', '竞赛目录', '74', 'league_work/technological_innovation/competition_directory', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('83', 'main', 'ContentList', '竞赛通知', '74', 'league_work/technological_innovation/competition_notice', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('84', 'main', 'ContentList', '调研报告', '73', 'league_work/social_practice/research_report', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('85', 'main', 'ContentList', '实践成果', '73', 'league_work/social_practice/practical_results', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('86', 'main', 'ContentList', '项目介绍', '73', 'league_work/social_practice/rroject_introduction', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('87', 'mian', 'ContentList', '活动纪实', '72', 'league_work/volunteer_service/event_blog', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('88', 'main', 'ContentList', '基地建设', '72', 'league_work/volunteer_service/base_construction', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('89', 'main', 'ContentList', '活动简介', '72', 'league_work/volunteer_service/activity_profile', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('90', 'main', 'ContentList', '优秀营员', '71', 'league_work/freshmen_camp/excellent_campers', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('91', 'main', 'ContentList', '历届成员', '71', 'league_work/freshmen_camp/previous_members', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('92', 'main', 'ContentList', '营区活动', '71', 'league_work/freshmen_camp/camp_activities', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('93', 'main', 'ContentList', '我要加入', '70', 'league_work/profes_interest_group/want_join', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('94', 'main', 'ContentList', '小组简介', '70', 'league_work/profes_interest_group/team_profile', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('95', 'main', 'ContentList', '实施办法', '70', 'league_work/profes_interest_group/implement_measure', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('96', 'main', 'ContentList', '活动展示', '70', 'league_work/profes_interest_group/event_gallery', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('97', 'main', 'ContentList', '教师介绍', '70', 'league_work/profes_interest_group/teacher_profile', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('98', 'main', 'ContentList', '创业之星', '69', 'league_work/employment_entrepreneurship/venture_star', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('99', 'main', 'ContentList', '生涯教育', '69', 'league_work/employment_entrepreneurship/career_edu', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('100', 'main', 'ContentList', '就业政策', '69', 'league_work/employment_entrepreneurship/employment_policy', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('101', 'main', 'ContentList', '就业信息', '69', 'league_work/employment_entrepreneurship/employment_information', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('102', 'main', 'ContentList', '创业政策', '69', 'league_work/employment_entrepreneurship/entrepreneurship_policy', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('103', 'mian', 'ContentList', '勤工助学', '68', 'league_work/stu_affairs/work_study', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('104', 'main', 'ContentList', '助学贷款', '68', 'league_work/stu_affairs/student_loans', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('105', 'main', 'ContentList', '助学金', '68', 'league_work/stu_affairs/stipend', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('106', 'main', 'ContentList', '奖学金', '68', 'league_work/stu_affairs/scholarship', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('107', 'main', 'ContentList', '奖优评定', '68', 'league_work/stu_affairs/award_assessment', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('108', 'main', 'ContentList', '活动展示', '67', 'league_work/tutor/events_gallery', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('109', 'main', 'ContentList', '导师介绍', '67', 'league_work/tutor/instructors', '0', '13213213', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('110', 'main', 'ContentList', '实施办法', '67', 'league_work/tutor/implementation_measure', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('112', 'main', 'ContentList', '先进个人', '66', 'league_work/excellent_stu_exhibition/outstanding_person', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('113', 'main', 'ContentList', '竞赛达人', '66', 'league_work/excellent_stu_exhibition/competition_daren', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('114', 'main', 'ContentList', '行政服务', '65', 'league_work/service_guide/administrative_services', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('115', 'main', 'ContentList', '学习服务', '65', 'league_work/service_guide/learning_services', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('116', 'main', 'ContentList', '生活服务', '65', 'league_work/service_guide/domestic_services', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('117', 'main', 'ContentList', '人才招聘', '9', 'admissions/recruitment/recruitment', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('118', 'main', 'ContentList', '招生信息', '9', 'admissions/admis_information', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('119', 'main', 'ContentList', '奖助学金', '118', 'admissions/admis_information/scholarship', '0', '2147483647', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('120', 'main', 'ContentList', '历年招生分数线', '118', 'admissions/admis_information/calendar_admission_score', '0', '45641313', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('121', 'main', 'ContentList', '招生简章', '118', 'admissions/admis_information/brochures', '0', '546514651', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('122', 'main', 'ContentList', '招生计划', '118', 'admissions/admis_information/enrollment_plan', '0', '2147483647', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('123', 'main', 'ContentList', '未来发展', '118', 'admissions/admis_information/future_develop', '0', '963852741', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('124', 'main', 'ContentList', '联系方式', '117', 'admissions/recruitment/recruitment/contact_information', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('125', 'main', 'ContentList', '应聘方式及流程', '117', 'admissions/recruitment/recruitment/app_method_processe', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('126', 'main', 'ContentList', '应聘条件', '117', 'admissions/recruitment/recruitment/qualification', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('127', 'main', 'ContentList', '学院简介', '117', 'admissions/recruitment/recruitment/college_introduction', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('129', 'main', 'ContentList', '校友服务', '8', 'alumni_work/alumni_services', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('130', 'main', 'ContentList', '校友动态', '8', 'alumni_work/alumni_dynamic', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('131', 'main', 'ContentList', '校友公告', '8', 'alumni_work/alumni_bulletin', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('132', 'main', 'ContentList', '校友寄语', '8', 'alumni_work/alumni_message', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('133', 'main', 'ContentList', '毕业映像', '8', 'alumni_work/graduation_image', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('134', 'main', 'ContentList', '交流动态', '11', 'international/dynamic_exchange', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('135', 'main', 'ContentList', '合作项目', '11', 'international/cooperation_pro', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('136', 'mian', 'ContentList', '中法班,中新班', '135', 'international/cooperation_pro/sino_french_new', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('137', 'main', 'ContentList', '院内推评', '10', 'open_hospital_affairs/push_comment', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('138', 'main', 'ContentList', '会议签到', '10', 'open_hospital_affairs/conference_registration', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('139', 'main', 'ContentList', '会议纪要', '10', 'open_hospital_affairs/meet_minute', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('140', 'main', 'ContentList', ' 学院文件', '10', 'open_hospital_affairs/college_file', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('141', 'main', 'ContentList', '学校文件', '10', 'open_hospital_affairs/school_document', '0', '0', '', '[]', '[]', '0', '0', '65535', '0', '0');
INSERT INTO `yunzhi_menu` VALUES ('143', 'main', 'Home', '首页', '0', '', '0', '11', '', '[]', '[]', '0', '0', '65535', '32767', '0');
INSERT INTO `yunzhi_menu` VALUES ('144', 'main', 'Login', '个人中心', '0', 'personalcenter', '1', '98', '', '[]', '[]', '0', '0', '65535', '32767', '0');
