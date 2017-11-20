/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : 127.0.0.1:3306
Source Database       : laravelcms

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-05-20 18:20:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_admin
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员主键',
  `rid` int(11) unsigned NOT NULL COMMENT '角色id',
  `username` varchar(12) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `truename` varchar(10) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱',
  `telphone` char(11) DEFAULT NULL COMMENT '手机号码',
  `lastloginip` int(11) unsigned DEFAULT NULL COMMENT '最后登录ip',
  `lastlogintime` int(11) unsigned DEFAULT NULL COMMENT '最后登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0：不可用，1：可用）',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `photo` varchar(100) DEFAULT NULL COMMENT '管理员头像',
  `islogin` tinyint(1) DEFAULT '0' COMMENT '是否登录（0：没有登录，1：登录）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_admin
-- ----------------------------
INSERT INTO `cms_admin` VALUES ('6', '1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '小鲍1', '406391609@qq.com', '18855474036', '2130706433', '1495268271', '1', '1493210898', 'upload/data/image/20170506/PgD8CdOYpu.jpeg', '1');
INSERT INTO `cms_admin` VALUES ('16', '1', 'test2', 'e10adc3949ba59abbe56e057f20f883e', 'test2', 'test2@qq.com', '18855474036', null, null, '1', '1495179062', null, '0');
INSERT INTO `cms_admin` VALUES ('17', '1', 'test3', 'e10adc3949ba59abbe56e057f20f883e', 'test3', 'test3@qq.com', '18855474036', null, null, '1', '1495179081', null, '0');
INSERT INTO `cms_admin` VALUES ('18', '1', 'test5', 'e10adc3949ba59abbe56e057f20f883e', 'test5', 'test5@qq.com', '18855474036', null, null, '1', '1495179100', null, '0');
INSERT INTO `cms_admin` VALUES ('19', '1', 'test6', 'e10adc3949ba59abbe56e057f20f883e', 'test6', 'test6@qq.com', '18855474036', null, null, '1', '1495179123', null, '0');
INSERT INTO `cms_admin` VALUES ('20', '1', 'test7', 'e10adc3949ba59abbe56e057f20f883e', 'test7', 'test7@qq.com', '18855474036', null, null, '1', '1495179146', null, '0');
INSERT INTO `cms_admin` VALUES ('21', '1', 'test8', 'e10adc3949ba59abbe56e057f20f883e', 'test8', 'test8@qq.com', '18855474036', null, null, '1', '1495179164', null, '0');
INSERT INTO `cms_admin` VALUES ('22', '1', 'test9', 'e10adc3949ba59abbe56e057f20f883e', 'test9', 'test9@qq.com', '18855474036', null, null, '1', '1495179180', null, '0');
INSERT INTO `cms_admin` VALUES ('23', '1', 'test10', 'e10adc3949ba59abbe56e057f20f883e', 'test10', 'test10@qq.com', '18855474036', null, null, '1', '1495179207', null, '0');

-- ----------------------------
-- Table structure for cms_admin_msg
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_msg`;
CREATE TABLE `cms_admin_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `fromid` int(11) unsigned NOT NULL COMMENT '发布管理员',
  `toid` int(11) unsigned NOT NULL COMMENT '接收者id',
  `msg` varchar(255) NOT NULL COMMENT '消息',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `status` tinyint(255) NOT NULL DEFAULT '0' COMMENT '是否已读（0：未读，1：已读）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_admin_msg
-- ----------------------------
INSERT INTO `cms_admin_msg` VALUES ('1', '6', '8', '哈哈', '1494060981', '0');
INSERT INTO `cms_admin_msg` VALUES ('2', '8', '6', '你好呀', '1494060983', '1');
INSERT INTO `cms_admin_msg` VALUES ('4', '6', '8', '123123123123', '1494146935', '0');
INSERT INTO `cms_admin_msg` VALUES ('5', '6', '8', '你在哪里呀？', '1494147424', '0');
INSERT INTO `cms_admin_msg` VALUES ('6', '6', '8', '网站奔溃了', '1494147470', '0');
INSERT INTO `cms_admin_msg` VALUES ('7', '6', '8', '你快看看', '1494147484', '0');

-- ----------------------------
-- Table structure for cms_article
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `aid` int(11) unsigned DEFAULT NULL COMMENT '发布者',
  `title` varchar(100) NOT NULL COMMENT '文章标题',
  `titlecolor` char(7) NOT NULL DEFAULT '#222222' COMMENT '标题颜色',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态（0：撤销发布，1：已发布，2：回收站，3：已删除）',
  `createtime` int(11) unsigned NOT NULL,
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `author` char(20) DEFAULT NULL COMMENT '作者',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `source` varchar(20) DEFAULT NULL COMMENT '来源',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `keywords` varchar(50) DEFAULT NULL COMMENT '关键字',
  `url` varchar(255) DEFAULT NULL COMMENT '外部链接',
  `contenttplid` int(1) unsigned NOT NULL COMMENT '内容模板',
  `click` int(11) DEFAULT '0' COMMENT '点击量',
  `thumb` varchar(255) DEFAULT NULL,
  `classname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES ('25', '6', '1', '#222222', '1', '1495250040', '1495250103', '1', '1', '1', '0', '1', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('26', '6', '2', '#222222', '0', '1495250100', '1495250639', '2', '2', '2', '0', '22', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('27', '6', '3', '#222222', '1', '1495250100', '1495250648', '3', '3', '3', '0', '3', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('28', '6', '4', '#222222', '1', '1495250100', '1495250655', '4', '4', '4', '0', '4', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('29', '6', '5', '#222222', '1', '1495250160', '1495250170', '5', '5', '5', '0', '5', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('30', '6', '6', '#222222', '1', '1495250160', '1495250612', '6', '6', '6', '0', '6', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('31', '6', '7', '#222222', '1', '1495250160', '1495250202', '7', '7', '7', '0', '7', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('32', '6', '8', '#222222', '1', '1495250160', '1495250212', '8', '8', '8', '0', '8', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('33', '6', '9', '#222222', '1', '1495250160', '1495250225', '9', '9', '9', '0', '9', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('34', '6', '10', '#222222', '1', '1495250220', '1495250240', '10', '10', '10', '0', '10', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('35', '6', '11', '#222222', '1', '1495250220', '1495250252', '11', '11', '11', '0', '11', null, '1', '0', null, '1,哈哈');
INSERT INTO `cms_article` VALUES ('36', '6', '12', '#222222', '1', '1495250640', '1495250680', '12', '12', '12', '0', '12', null, '1', '0', null, '1');
INSERT INTO `cms_article` VALUES ('37', '6', '13', '#222222', '1', '1495250640', '1495250696', '13', '13', '13', '0', '13', null, '1', '0', null, '哈哈');

-- ----------------------------
-- Table structure for cms_article_detail
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_detail`;
CREATE TABLE `cms_article_detail` (
  `aid` int(11) NOT NULL,
  `content` text,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article_detail
-- ----------------------------
INSERT INTO `cms_article_detail` VALUES ('5', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; text-indent: 0em; white-space: normal; line-height: 24px; background-color: rgb(255, 255, 255); text-align: center;\"><img src=\"/upload/ueditor/image/20170502/1493720765834696.jpg\" title=\"1493704188238137.jpg\" alt=\"1493704188238137.jpg\" width=\"800\" height=\"500\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; text-indent: 0em; white-space: normal; line-height: 24px; background-color: rgb(255, 255, 255);\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; white-space: normal; background-color: rgb(255, 255, 255); text-indent: 28px; line-height: 24px;\"><span style=\"margin: 0px; padding: 0px; font-family: arial, helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">4<span style=\"margin: 0px; padding: 0px;\">月</span>26<span style=\"margin: 0px; padding: 0px;\">号下午</span>2:40<span style=\"margin: 0px; padding: 0px;\">，计算机学院在泉教</span>A501<span style=\"margin: 0px; padding: 0px;\">教室召开</span>2018<span style=\"margin: 0px; padding: 0px;\">届全体毕业生</span></span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">创新创业暨就业动员大会</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">。学院党总支书记许江荣、副书记吴兆文、副院长陈磊、辅导员班主任以及</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">2018<span style=\"margin: 0px; padding: 0px;\">届毕业班全体同学参加了动员活动</span></span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">，</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">会议由</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">吴兆文</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑; line-height: 24px;\">主持。</span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; white-space: normal; text-indent: 28px; line-height: 24px; background: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; font-family: arial, helvetica, sans-serif; font-size: 14px; line-height: 21px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">首先，院就业办公室主任李晓燕通报了</span>2017<span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">届毕业生的试就业情况。李老师介绍了应届毕业生的考研、考编、试就业情况。从目前就业态势来说，</span>2017届毕业生又是高质量就业季。希望2018届同学们要提前谋划，认真准备，打好基础，勇于竞争。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; white-space: normal; text-indent: 28px; line-height: 24px; background: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; font-family: arial, helvetica, sans-serif; font-size: 14px; line-height: 21px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">接着，许江荣对</span>2017<span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">届毕业生的就业形势进行了分析。他指出，目前的就业形势相当严峻，今年共有毕业生</span>795万人，再加上历届未就业人员、农民工等，数量庞大，竞争激烈。同学们要根据自身条件，尽早确定就业方向，积极参加企业招聘、考研考编、自主创业，也可选择入伍或支教支农等。学院将对广大毕业生在就业创业方面的合理要求给予大力支持，希望同学们及早行动，越早越快成功就业的几率就越大；在就业过程中要注意安全，防止人身损害和财产损失，防止<span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">求职陷阱和传销陷阱；并祝愿所有同学顺利就业，找到自己满意的工作，尽早为国家、为社会、为家庭做出积极贡献。</span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; white-space: normal; background-color: rgb(255, 255, 255); text-indent: 28px; line-height: 24px;\"><span style=\"margin: 0px; padding: 0px; font-family: arial, helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体; line-height: 24px;\">随后，</span><span style=\"margin: 0px; padding: 0px; font-family: 宋体; line-height: 24px;\">陈磊就本年度专业实习的相关工作进行了布置，</span><span style=\"margin: 0px; padding: 0px; font-family: 宋体; line-height: 24px;\">对实习的类型、方式、组织管理、考核管理等制度进行了详细的解读和说明，重点强调实习的纪律和安全问题，要求同学们严格遵守相关规定，圆满完成人才培养方案中所确定的实习任务。</span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; white-space: normal; text-indent: 28px; line-height: 24px; background: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; font-family: arial, helvetica, sans-serif; line-height: 24px;\">最后，上海蓝鸥科技作为我院实习基地，介绍了基地及实习、实训的安排情况。2017届考研与国考的7名同学代表分别与同学们分享了自己的考试经历和成功经验。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: 微软雅黑; white-space: normal; text-indent: 28px; line-height: 24px; background: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; font-family: arial, helvetica, sans-serif; font-size: 14px; line-height: 21px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">本次创新创业暨就业动员大会的召开，吹响了</span>2018<span style=\"margin: 0px; padding: 0px; font-family: 宋体; font-size: 16px; line-height: 24px;\">届毕业生专业实习培训以及积极参加创新就业活动的号角，为即将在暑期开始的专业实习做好了必要的思想和认识准备，也有利于同学们集中精力关注就业、选择职业，在为祖国服务的道路上顺利前行!</span></span><span style=\"font-family: sans-serif;\">&nbsp;&nbsp;</span></p>');
INSERT INTO `cms_article_detail` VALUES ('6', '<p>123</p>');
INSERT INTO `cms_article_detail` VALUES ('7', '<p>1111111111111111111111111111111</p>');
INSERT INTO `cms_article_detail` VALUES ('8', '<p>123</p>');
INSERT INTO `cms_article_detail` VALUES ('9', '<p>1</p>');
INSERT INTO `cms_article_detail` VALUES ('10', '<p>1</p>');
INSERT INTO `cms_article_detail` VALUES ('11', '<p>2</p>');
INSERT INTO `cms_article_detail` VALUES ('12', '<p>3</p>');
INSERT INTO `cms_article_detail` VALUES ('13', null);
INSERT INTO `cms_article_detail` VALUES ('14', null);
INSERT INTO `cms_article_detail` VALUES ('15', null);
INSERT INTO `cms_article_detail` VALUES ('16', null);
INSERT INTO `cms_article_detail` VALUES ('17', null);
INSERT INTO `cms_article_detail` VALUES ('18', null);
INSERT INTO `cms_article_detail` VALUES ('19', null);
INSERT INTO `cms_article_detail` VALUES ('20', null);
INSERT INTO `cms_article_detail` VALUES ('21', null);
INSERT INTO `cms_article_detail` VALUES ('22', null);
INSERT INTO `cms_article_detail` VALUES ('23', null);
INSERT INTO `cms_article_detail` VALUES ('24', null);
INSERT INTO `cms_article_detail` VALUES ('25', null);
INSERT INTO `cms_article_detail` VALUES ('26', null);
INSERT INTO `cms_article_detail` VALUES ('27', null);
INSERT INTO `cms_article_detail` VALUES ('28', null);
INSERT INTO `cms_article_detail` VALUES ('29', null);
INSERT INTO `cms_article_detail` VALUES ('30', null);
INSERT INTO `cms_article_detail` VALUES ('31', null);
INSERT INTO `cms_article_detail` VALUES ('32', null);
INSERT INTO `cms_article_detail` VALUES ('33', null);
INSERT INTO `cms_article_detail` VALUES ('34', null);
INSERT INTO `cms_article_detail` VALUES ('35', null);
INSERT INTO `cms_article_detail` VALUES ('36', null);
INSERT INTO `cms_article_detail` VALUES ('37', null);

-- ----------------------------
-- Table structure for cms_article_visit
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_visit`;
CREATE TABLE `cms_article_visit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章访问id',
  `aid` int(11) NOT NULL COMMENT '文章id',
  `year` smallint(1) unsigned NOT NULL COMMENT '年份',
  `month` tinyint(1) unsigned NOT NULL COMMENT '月份',
  `day` tinyint(1) NOT NULL COMMENT '日',
  `click` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article_visit
-- ----------------------------

-- ----------------------------
-- Table structure for cms_class
-- ----------------------------
DROP TABLE IF EXISTS `cms_class`;
CREATE TABLE `cms_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目id',
  `parentid` int(11) unsigned NOT NULL COMMENT '栏目父级id',
  `covertplid` int(11) unsigned NOT NULL COMMENT '栏目封面模板',
  `name` varchar(20) NOT NULL COMMENT '栏目名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（0：不可用，1：可用，2：已删除）',
  `isnav` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示在首页导航（0：不显示，1：显示）',
  `url` varchar(255) DEFAULT NULL COMMENT '外部链接',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `thumb` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `description` varchar(255) DEFAULT NULL COMMENT '栏目描述',
  `sort` tinyint(255) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_class
-- ----------------------------
INSERT INTO `cms_class` VALUES ('1', '3', '1', '哈哈', '1', '0', null, '1', 'upload/data/image/20170506/8TXzdwOI67.jpeg', '1', '0');
INSERT INTO `cms_class` VALUES ('3', '0', '1', '1', '1', '1', null, '1494038813', 'upload/data/image/20170506/tSacxMnQLR.jpeg', '111', '0');

-- ----------------------------
-- Table structure for cms_class_article
-- ----------------------------
DROP TABLE IF EXISTS `cms_class_article`;
CREATE TABLE `cms_class_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目文章id',
  `cid` int(11) unsigned NOT NULL COMMENT '栏目id',
  `aid` int(11) unsigned NOT NULL COMMENT '文章id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_class_article
-- ----------------------------
INSERT INTO `cms_class_article` VALUES ('24', '1', '6');
INSERT INTO `cms_class_article` VALUES ('25', '1', '7');
INSERT INTO `cms_class_article` VALUES ('26', '1', '8');
INSERT INTO `cms_class_article` VALUES ('27', '3', '8');
INSERT INTO `cms_class_article` VALUES ('28', '1', '9');
INSERT INTO `cms_class_article` VALUES ('29', '1', '10');
INSERT INTO `cms_class_article` VALUES ('30', '1', '11');
INSERT INTO `cms_class_article` VALUES ('31', '1', '12');
INSERT INTO `cms_class_article` VALUES ('32', '1', '13');
INSERT INTO `cms_class_article` VALUES ('33', '1', '14');
INSERT INTO `cms_class_article` VALUES ('34', '1', '15');
INSERT INTO `cms_class_article` VALUES ('35', '1', '16');
INSERT INTO `cms_class_article` VALUES ('36', '1', '17');
INSERT INTO `cms_class_article` VALUES ('37', '1', '18');
INSERT INTO `cms_class_article` VALUES ('38', '1', '19');
INSERT INTO `cms_class_article` VALUES ('40', '3', '21');
INSERT INTO `cms_class_article` VALUES ('41', '3', '20');
INSERT INTO `cms_class_article` VALUES ('42', '1', '20');
INSERT INTO `cms_class_article` VALUES ('43', '3', '22');
INSERT INTO `cms_class_article` VALUES ('44', '1', '22');
INSERT INTO `cms_class_article` VALUES ('45', '3', '23');
INSERT INTO `cms_class_article` VALUES ('46', '1', '23');
INSERT INTO `cms_class_article` VALUES ('47', '3', '24');
INSERT INTO `cms_class_article` VALUES ('48', '1', '24');
INSERT INTO `cms_class_article` VALUES ('49', '3', '25');
INSERT INTO `cms_class_article` VALUES ('50', '1', '25');
INSERT INTO `cms_class_article` VALUES ('54', '3', '29');
INSERT INTO `cms_class_article` VALUES ('55', '1', '29');
INSERT INTO `cms_class_article` VALUES ('57', '3', '31');
INSERT INTO `cms_class_article` VALUES ('58', '1', '31');
INSERT INTO `cms_class_article` VALUES ('59', '3', '32');
INSERT INTO `cms_class_article` VALUES ('60', '1', '32');
INSERT INTO `cms_class_article` VALUES ('61', '3', '33');
INSERT INTO `cms_class_article` VALUES ('62', '1', '33');
INSERT INTO `cms_class_article` VALUES ('63', '3', '34');
INSERT INTO `cms_class_article` VALUES ('64', '1', '34');
INSERT INTO `cms_class_article` VALUES ('65', '3', '35');
INSERT INTO `cms_class_article` VALUES ('66', '1', '35');
INSERT INTO `cms_class_article` VALUES ('69', '3', '30');
INSERT INTO `cms_class_article` VALUES ('70', '1', '30');
INSERT INTO `cms_class_article` VALUES ('71', '3', '26');
INSERT INTO `cms_class_article` VALUES ('72', '1', '26');
INSERT INTO `cms_class_article` VALUES ('73', '3', '27');
INSERT INTO `cms_class_article` VALUES ('74', '1', '27');
INSERT INTO `cms_class_article` VALUES ('75', '3', '28');
INSERT INTO `cms_class_article` VALUES ('76', '1', '28');
INSERT INTO `cms_class_article` VALUES ('77', '3', '36');
INSERT INTO `cms_class_article` VALUES ('78', '1', '37');

-- ----------------------------
-- Table structure for cms_class_detail
-- ----------------------------
DROP TABLE IF EXISTS `cms_class_detail`;
CREATE TABLE `cms_class_detail` (
  `cid` int(11) NOT NULL COMMENT '栏目id',
  `content` text,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_class_detail
-- ----------------------------
INSERT INTO `cms_class_detail` VALUES ('1', '<p>12313123123</p>');
INSERT INTO `cms_class_detail` VALUES ('3', '<p>22222</p>');

-- ----------------------------
-- Table structure for cms_config
-- ----------------------------
DROP TABLE IF EXISTS `cms_config`;
CREATE TABLE `cms_config` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(20) NOT NULL DEFAULT '',
  `info` varchar(100) NOT NULL DEFAULT '',
  `classify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分类（0：系统，1：扩展）',
  `value` varchar(100) NOT NULL,
  `type` char(16) NOT NULL DEFAULT 'string' COMMENT '''string'',''int'',''boolean'',''img''',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='网站配置表';

-- ----------------------------
-- Records of cms_config
-- ----------------------------
INSERT INTO `cms_config` VALUES ('1', 'sitename', '网站名称', '0', '淮南师范学院计算机学院', '');
INSERT INTO `cms_config` VALUES ('2', 'siteurl', '网站网址', '0', 'http://www.e8net.cn/jxx', '');
INSERT INTO `cms_config` VALUES ('3', 'sitefileurl', '附件地址', '0', '123', '');
INSERT INTO `cms_config` VALUES ('4', 'siteemail', '站点邮箱', '0', '915021118@qq.com', '');
INSERT INTO `cms_config` VALUES ('6', 'siteinfo', '网站介绍', '0', '淮南师范学院计算机与信息工程系', '');
INSERT INTO `cms_config` VALUES ('7', 'sitekeywords', '网站关键字', '0', '淮南师范学院计算机与信息工程系', '');
INSERT INTO `cms_config` VALUES ('8', 'uploadmaxsize', '允许上传附件大小', '0', '20240', '');
INSERT INTO `cms_config` VALUES ('9', 'uploadallowext', '允许上传附件类型', '0', 'jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf', '');
INSERT INTO `cms_config` VALUES ('10', 'qtuploadmaxsize', '前台允许上传附件大小', '0', '200', '');
INSERT INTO `cms_config` VALUES ('11', 'qtuploadallowext', '前台允许上传附件类型', '0', 'jpg|jpeg|gif', '');
INSERT INTO `cms_config` VALUES ('12', 'watermarkenable', '是否开启图片水印', '0', 'true', '');
INSERT INTO `cms_config` VALUES ('13', 'watermarkminwidth', '水印-宽', '0', '300', '');
INSERT INTO `cms_config` VALUES ('14', 'watermarkminheight', '水印-高', '0', '100', '');
INSERT INTO `cms_config` VALUES ('15', 'watermarkimg', '水印图片', '0', '/statics/images/mark_bai.png', '');
INSERT INTO `cms_config` VALUES ('16', 'watermarkpct', '水印透明度', '0', '80', '');
INSERT INTO `cms_config` VALUES ('17', 'watermarkquality', 'JPEG 水印质量', '0', '85', '');
INSERT INTO `cms_config` VALUES ('18', 'watermarkpos', '水印位置', '0', '7', '');
INSERT INTO `cms_config` VALUES ('19', 'theme', '主题风格', '0', 'Default', '');
INSERT INTO `cms_config` VALUES ('20', 'ftpstatus', 'FTP上传', '0', '0', '');
INSERT INTO `cms_config` VALUES ('21', 'ftpuser', 'FTP用户名', '0', 'root', '');
INSERT INTO `cms_config` VALUES ('22', 'ftppassword', 'FTP密码', '0', 'hello', '');
INSERT INTO `cms_config` VALUES ('23', 'ftphost', 'FTP服务器地址', '0', '1', '');
INSERT INTO `cms_config` VALUES ('24', 'ftpport', 'FTP服务器端口', '0', '21', '');
INSERT INTO `cms_config` VALUES ('25', 'ftppasv', 'FTP是否开启被动模式', '0', 'true', '');
INSERT INTO `cms_config` VALUES ('26', 'ftpssl', 'FTP是否使用SSL连接', '0', 'false', '');
INSERT INTO `cms_config` VALUES ('27', 'ftptimeout', 'FTP超时时间', '0', '10', '');
INSERT INTO `cms_config` VALUES ('28', 'ftpuppat', 'FTP上传目录', '0', '/', '');
INSERT INTO `cms_config` VALUES ('29', 'mail_type', '邮件发送模式', '0', '1', '');
INSERT INTO `cms_config` VALUES ('30', 'mail_server', '邮件服务器', '0', 'smtp.126.com', '');
INSERT INTO `cms_config` VALUES ('31', 'mail_port', '邮件发送端口', '0', '25', '');
INSERT INTO `cms_config` VALUES ('32', 'mail_from', '发件人地址', '0', 'web_bc@126.com', '');
INSERT INTO `cms_config` VALUES ('33', 'mail_auth', '密码验证', '0', '', '');
INSERT INTO `cms_config` VALUES ('34', 'mail_user', '邮箱用户名', '0', 'E8网络工作室', '');
INSERT INTO `cms_config` VALUES ('35', 'mail_password', '邮箱密码', '0', 'baochao000', '');
INSERT INTO `cms_config` VALUES ('36', 'mail_fname', '发件人名称', '0', 'web_bc@126.com', '');
INSERT INTO `cms_config` VALUES ('37', 'domainaccess', '指定域名访问', '0', '0', '');
INSERT INTO `cms_config` VALUES ('38', 'generate', '是否生成首页', '0', '0', '');
INSERT INTO `cms_config` VALUES ('39', 'index_urlruleid', '首页URL规则', '0', '静态1:index_2.html', '');
INSERT INTO `cms_config` VALUES ('40', 'indextp', '首页模板', '0', 'index.php', '');
INSERT INTO `cms_config` VALUES ('41', 'tagurl', 'TagURL规则', '0', '8', '');
INSERT INTO `cms_config` VALUES ('43', '11', '123', '1', '1', 'string');
INSERT INTO `cms_config` VALUES ('44', '22', '22', '1', '22', 'string');
INSERT INTO `cms_config` VALUES ('45', '3', '3', '1', '3', 'string');
INSERT INTO `cms_config` VALUES ('46', '4', '4', '1', '4', 'string');
INSERT INTO `cms_config` VALUES ('47', '5', '5', '1', '5', 'string');
INSERT INTO `cms_config` VALUES ('48', '6', '6', '1', '6', 'string');
INSERT INTO `cms_config` VALUES ('49', '7', '7', '1', '7', 'string');
INSERT INTO `cms_config` VALUES ('50', '8', '8', '1', '8', 'string');
INSERT INTO `cms_config` VALUES ('51', '9', '9', '1', '9', 'string');
INSERT INTO `cms_config` VALUES ('52', '10', '10', '1', '10', 'string');
INSERT INTO `cms_config` VALUES ('53', '11', '11', '1', '11', 'string');
INSERT INTO `cms_config` VALUES ('54', '12', '12312', '1', '12', 'string');

-- ----------------------------
-- Table structure for cms_content_tpl
-- ----------------------------
DROP TABLE IF EXISTS `cms_content_tpl`;
CREATE TABLE `cms_content_tpl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL COMMENT '名称',
  `url` char(20) DEFAULT NULL COMMENT '链接',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_content_tpl
-- ----------------------------
INSERT INTO `cms_content_tpl` VALUES ('1', '通用文章内容模板', '', '');

-- ----------------------------
-- Table structure for cms_cover_tpl
-- ----------------------------
DROP TABLE IF EXISTS `cms_cover_tpl`;
CREATE TABLE `cms_cover_tpl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL COMMENT '名称',
  `url` char(20) DEFAULT NULL COMMENT '链接',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_cover_tpl
-- ----------------------------
INSERT INTO `cms_cover_tpl` VALUES ('1', '通用文章简介模板', null, null);
INSERT INTO `cms_cover_tpl` VALUES ('2', '通用文章列表模板', null, null);
INSERT INTO `cms_cover_tpl` VALUES ('3', '通用图片列表模板', null, null);

-- ----------------------------
-- Table structure for cms_log_login
-- ----------------------------
DROP TABLE IF EXISTS `cms_log_login`;
CREATE TABLE `cms_log_login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `adminid` tinyint(11) unsigned NOT NULL COMMENT '管理员Id',
  `logintime` int(11) unsigned NOT NULL COMMENT '登录时间',
  `loginip` int(11) unsigned NOT NULL COMMENT '登录时间',
  `area` varchar(30) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态（0：不成功，1：成功）',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '登录类型（0：邮箱，1：用户名）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_log_login
-- ----------------------------
INSERT INTO `cms_log_login` VALUES ('22', '6', '1494068452', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('23', '6', '1494068983', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('24', '6', '1494138483', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('25', '6', '1494138671', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('26', '6', '1494147863', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('27', '6', '1494147909', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('28', '6', '1494158120', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('29', '8', '1494160996', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('30', '6', '1494161009', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('31', '6', '1494162044', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('33', '6', '1494245272', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('34', '6', '1494303023', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('35', '6', '1494313549', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('36', '6', '1495003909', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('37', '6', '1495027366', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('38', '6', '1495096444', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('39', '6', '1495107675', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('40', '6', '1495178020', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('42', '6', '1495262658', '2130706433', 'ip地址有误', '1', '1');
INSERT INTO `cms_log_login` VALUES ('43', '6', '1495268271', '2130706433', 'ip地址有误', '1', '1');

-- ----------------------------
-- Table structure for cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `parentid` int(11) unsigned NOT NULL COMMENT '父级菜单Id',
  `name` char(20) NOT NULL,
  `router` varchar(50) DEFAULT NULL COMMENT '路由',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（0:不可用，1：可用）',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
INSERT INTO `cms_menu` VALUES ('1', '0', '管理员管理', '/admin/admin/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('2', '1', '管理员管理', '/admin/admin/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('3', '1', '角色管理', '/admin/role/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('4', '0', '内容管理', '/admin/article/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('5', '4', '文章管理', '/admin/article/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('6', '4', '栏目管理', '/admin/class/index', '1', '1');
INSERT INTO `cms_menu` VALUES ('7', '0', '配置管理', '/admin/config/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('8', '0', '日志管理', '/admin/log/index', '1', '0');
INSERT INTO `cms_menu` VALUES ('9', '4', '文档回收站', '/admin/article/rubbish', '1', '0');
INSERT INTO `cms_menu` VALUES ('10', '7', '系统配置管理', '/admin/config/system', '1', '0');
INSERT INTO `cms_menu` VALUES ('11', '7', '扩展配置管理', '/admin/config/extend', '1', '0');
INSERT INTO `cms_menu` VALUES ('12', '8', '登录日志管理', '/admin/log/loginlog', '1', '0');
INSERT INTO `cms_menu` VALUES ('13', '8', '操作日志管理', '/admin/log/operatelog', '1', '0');

-- ----------------------------
-- Table structure for cms_operate_log
-- ----------------------------
DROP TABLE IF EXISTS `cms_operate_log`;
CREATE TABLE `cms_operate_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '操作日志id',
  `adminid` int(10) unsigned NOT NULL COMMENT '管理员id',
  `url` text NOT NULL COMMENT '操作url',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（0：不成功，1：成功）',
  `time` int(11) unsigned NOT NULL,
  `method` char(4) NOT NULL COMMENT '''POST'',''GET'',''Ajax''',
  `description` varchar(100) NOT NULL COMMENT '日志描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_operate_log
-- ----------------------------
INSERT INTO `cms_operate_log` VALUES ('1', '6', '/admin/admin/add', '1', '1494035617', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('2', '6', '/admin/admin/del/10', '1', '1494035962', 'GET', '删除管理员成功');
INSERT INTO `cms_operate_log` VALUES ('3', '6', '/admin/admin/edit/6', '1', '1494036393', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('4', '6', '/admin/admin/add', '1', '1494036738', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('5', '6', '/admin/admin/add', '1', '1494036856', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('6', '6', '/admin/admin/add', '1', '1494036947', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('7', '6', '/admin/admin/add', '1', '1494037066', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('8', '6', '/admin/admin/edit/14', '1', '1494037230', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('9', '6', '/admin/admin/edit/14', '1', '1494037311', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('10', '6', '/admin/admin/edit/14', '1', '1494037358', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('11', '6', '/admin/admin/edit/14', '1', '1494037433', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('12', '6', '/admin/admin/edit/6', '1', '1494037451', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('13', '6', '/admin/admin/edit/6', '1', '1494037462', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('14', '6', '/admin/admin/edit/8', '1', '1494037477', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('15', '6', '/admin/admin/edit/6', '1', '1494038022', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('16', '6', '/admin/admin/edit/6', '1', '1494038060', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('17', '6', '/admin/admin/edit/6', '1', '1494038073', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('18', '6', '/admin/class/edit/1', '1', '1494038695', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('19', '6', '/admin/class/edit/2', '1', '1494038741', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('20', '6', '/admin/class/add', '1', '1494038813', 'POST', '添加栏目成功');
INSERT INTO `cms_operate_log` VALUES ('21', '6', '/admin/class/edit/3', '1', '1494038830', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('22', '6', '/admin/admin/edit/8', '1', '1494039173', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('23', '6', '/admin/admin/edit/14', '1', '1494039185', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('24', '6', '/admin/role/accessAdd', '1', '1494039244', 'GET', '角色授权成功');
INSERT INTO `cms_operate_log` VALUES ('25', '6', '/admin/admin/edit/8', '1', '1494039278', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('26', '6', '/admin/role/del/17', '1', '1494054993', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('27', '6', '/admin/role/del/18', '1', '1494054999', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('28', '6', '/admin/role/del/16', '1', '1494055005', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('29', '6', '/admin/role/del/15', '1', '1494055649', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('30', '6', '/admin/admin/edit/8', '1', '1494055729', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('31', '6', '/admin/role/del/14', '1', '1494055746', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('32', '6', '/admin/role/add', '1', '1494055762', 'POST', '添加角色成功');
INSERT INTO `cms_operate_log` VALUES ('33', '6', '/admin/role/accessAdd', '1', '1494056157', 'GET', '角色授权成功');
INSERT INTO `cms_operate_log` VALUES ('34', '6', '/admin/admin/edit/8', '1', '1494056174', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('35', '6', '/admin/role/add', '1', '1494056264', 'POST', '添加角色成功');
INSERT INTO `cms_operate_log` VALUES ('36', '6', '/admin/role/accessAdd', '1', '1494056292', 'GET', '角色授权成功');
INSERT INTO `cms_operate_log` VALUES ('37', '6', '/admin/admin/edit/14', '1', '1494056304', 'POST', '修改管理员成功');
INSERT INTO `cms_operate_log` VALUES ('38', '14', '/admin/article/add', '1', '1494056449', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('39', '6', '/admin/class/edit/3', '1', '1494056658', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('40', '6', '/admin/role/add', '1', '1494057470', 'POST', '添加角色成功');
INSERT INTO `cms_operate_log` VALUES ('41', '6', '/admin/role/add', '1', '1494058407', 'POST', '添加角色成功');
INSERT INTO `cms_operate_log` VALUES ('42', '6', '/admin/class/add', '1', '1494058537', 'POST', '添加栏目成功');
INSERT INTO `cms_operate_log` VALUES ('43', '6', '/admin/class/edit/3', '1', '1494058569', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('44', '6', '/admin/class/edit/3', '1', '1494058588', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('45', '6', '/admin/class/add', '1', '1494058600', 'POST', '添加栏目成功');
INSERT INTO `cms_operate_log` VALUES ('46', '6', '/admin/class/del/5', '1', '1494058613', 'GET', '删除栏目成功');
INSERT INTO `cms_operate_log` VALUES ('47', '6', '/admin/class/add', '1', '1494058627', 'POST', '添加栏目成功');
INSERT INTO `cms_operate_log` VALUES ('48', '6', '/admin/class/add', '1', '1494058673', 'POST', '添加栏目成功');
INSERT INTO `cms_operate_log` VALUES ('49', '6', '/admin/class/del/7', '1', '1494059890', 'GET', '删除栏目成功');
INSERT INTO `cms_operate_log` VALUES ('50', '6', '/admin/class/del/6', '1', '1494059897', 'GET', '删除栏目成功');
INSERT INTO `cms_operate_log` VALUES ('51', '6', '/admin/class/del/4', '1', '1494059914', 'GET', '删除栏目成功');
INSERT INTO `cms_operate_log` VALUES ('52', '6', '/admin/role/del/21', '1', '1494139015', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('53', '6', '/admin/role/del/22', '1', '1494250316', 'GET', '删除角色成功');
INSERT INTO `cms_operate_log` VALUES ('54', '6', '/admin/admin/add', '1', '1494304184', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('55', '6', '/admin/config/systemedit', '1', '1495096501', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('56', '6', '/admin/config/systemedit', '1', '1495096505', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('57', '6', '/admin/config/systemedit', '1', '1495096508', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('58', '6', '/admin/config/systemedit', '1', '1495096592', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('59', '6', '/admin/config/systemedit', '1', '1495096613', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('60', '6', '/admin/config/systemedit', '1', '1495096616', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('61', '6', '/admin/config/systemedit', '1', '1495096619', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('62', '6', '/admin/admin/add', '1', '1495179062', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('63', '6', '/admin/admin/add', '1', '1495179081', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('64', '6', '/admin/admin/add', '1', '1495179100', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('65', '6', '/admin/admin/add', '1', '1495179123', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('66', '6', '/admin/admin/add', '1', '1495179146', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('67', '6', '/admin/admin/add', '1', '1495179164', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('68', '6', '/admin/admin/add', '1', '1495179180', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('69', '6', '/admin/admin/add', '1', '1495179207', 'POST', '添加管理员成功');
INSERT INTO `cms_operate_log` VALUES ('70', '6', '/admin/admin/del/8', '1', '1495183464', 'GET', '删除管理员成功');
INSERT INTO `cms_operate_log` VALUES ('71', '6', '/admin/article/cancel/8', '1', '1495199375', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('72', '6', '/admin/article/publish/8', '1', '1495199384', 'GET', '发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('73', '6', '/admin/article/cancel/8', '1', '1495199509', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('74', '6', '/admin/article/add', '1', '1495199534', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('75', '6', '/admin/article/add', '1', '1495199548', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('76', '6', '/admin/article/add', '1', '1495199560', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('77', '6', '/admin/article/add', '1', '1495199571', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('78', '6', '/admin/article/add', '1', '1495199580', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('79', '6', '/admin/article/add', '1', '1495199590', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('80', '6', '/admin/article/add', '1', '1495199598', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('81', '6', '/admin/article/add', '1', '1495199607', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('82', '6', '/admin/article/add', '1', '1495199618', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('83', '6', '/admin/article/add', '1', '1495199628', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('84', '6', '/admin/article/add', '1', '1495199639', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('85', '6', '/admin/article/add', '1', '1495199648', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('86', '6', '/admin/article/add', '1', '1495199726', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('87', '6', '/admin/article/cancel/13', '1', '1495200392', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('88', '6', '/admin/article/cancel/20,21,14,15,16,17,18,19,9,10', '1', '1495200427', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('89', '6', '/admin/article/cancel/20,21,14,15,16,17,18,19,9,10', '1', '1495200445', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('90', '6', '/admin/article/recycle/20', '1', '1495200593', 'GET', '删除文章成功');
INSERT INTO `cms_operate_log` VALUES ('91', '6', '/admin/article/recycle/21,14', '1', '1495200600', 'GET', '删除文章成功');
INSERT INTO `cms_operate_log` VALUES ('92', '6', '/admin/article/cancel/15,16,17,18,19,9,10,11,12,13', '1', '1495200726', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('93', '6', '/admin/article/publish/15,16,17,18,19,9,10,11,12,13', '1', '1495200732', 'GET', '发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('94', '6', '/admin/article/cancel/15,16,17,18,19,9,10,11,12,13,8,7,6,5', '1', '1495200740', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('95', '6', '/admin/article/recycle/15,16,17,18,19,9,10,11,12,13', '1', '1495201131', 'GET', '删除文章成功');
INSERT INTO `cms_operate_log` VALUES ('96', '6', '/admin/article/recycle/8,7,6,5', '1', '1495201137', 'GET', '删除文章成功');
INSERT INTO `cms_operate_log` VALUES ('97', '6', '/admin/article/back/20', '1', '1495201661', 'GET', '还原文章成功');
INSERT INTO `cms_operate_log` VALUES ('98', '6', '/admin/article/back/21,14,15,16,17,18,19,9,10,11', '1', '1495201706', 'GET', '还原文章成功');
INSERT INTO `cms_operate_log` VALUES ('99', '6', '/admin/class/edit/3', '1', '1495202110', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('100', '6', '/admin/class/edit/1', '1', '1495202119', 'POST', '修改栏目成功');
INSERT INTO `cms_operate_log` VALUES ('101', '6', '/admin/config/systemedit', '1', '1495242190', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('102', '6', '/admin/config/systemedit', '1', '1495242199', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('103', '6', '/admin/config/systemedit', '1', '1495242203', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('104', '6', '/admin/config/systemedit', '1', '1495242206', 'POST', '修改系统配置成功');
INSERT INTO `cms_operate_log` VALUES ('105', '6', '/admin/config/edit/42', '1', '1495243190', 'POST', '修改扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('106', '6', '/admin/config/edit/42', '1', '1495243199', 'POST', '修改扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('107', '6', '/admin/config/del/42', '1', '1495243207', 'GET', '删除扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('108', '6', '/admin/config/add', '1', '1495243217', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('109', '6', '/admin/config/add', '1', '1495243248', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('110', '6', '/admin/config/add', '1', '1495243255', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('111', '6', '/admin/config/add', '1', '1495243262', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('112', '6', '/admin/config/add', '1', '1495243268', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('113', '6', '/admin/config/add', '1', '1495243276', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('114', '6', '/admin/config/add', '1', '1495243283', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('115', '6', '/admin/config/add', '1', '1495243289', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('116', '6', '/admin/config/add', '1', '1495243296', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('117', '6', '/admin/config/add', '1', '1495243304', 'POST', '添加扩展配置成功');
INSERT INTO `cms_operate_log` VALUES ('120', '6', '/admin/article/recycle/21', '1', '1495245854', 'GET', '删除文章成功');
INSERT INTO `cms_operate_log` VALUES ('121', '6', '/admin/article/back/21,12,13,8,7,6,5', '1', '1495246381', 'GET', '还原文章成功');
INSERT INTO `cms_operate_log` VALUES ('122', '6', '/admin/article/edit/20', '1', '1495246510', 'POST', '修改文章成功');
INSERT INTO `cms_operate_log` VALUES ('123', '6', '/admin/article/add', '1', '1495248102', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('124', '6', '/admin/article/add', '1', '1495248188', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('125', '6', '/admin/article/add', '1', '1495248221', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('126', '6', '/admin/article/add', '1', '1495250103', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('127', '6', '/admin/article/add', '1', '1495250118', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('128', '6', '/admin/article/add', '1', '1495250129', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('129', '6', '/admin/article/add', '1', '1495250139', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('130', '6', '/admin/article/add', '1', '1495250170', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('131', '6', '/admin/article/add', '1', '1495250181', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('132', '6', '/admin/article/add', '1', '1495250202', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('133', '6', '/admin/article/add', '1', '1495250212', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('134', '6', '/admin/article/add', '1', '1495250225', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('135', '6', '/admin/article/add', '1', '1495250240', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('136', '6', '/admin/article/add', '1', '1495250252', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('137', '6', '/admin/article/recycle/34,35,29,30,31,32,33,26,27,28', '1', '1495250283', 'GET', '删除文章成功');
INSERT INTO `cms_operate_log` VALUES ('138', '6', '/admin/article/back/30', '1', '1495250512', 'GET', '还原文章成功');
INSERT INTO `cms_operate_log` VALUES ('139', '6', '/admin/article/edit/30', '1', '1495250526', 'POST', '修改文章成功');
INSERT INTO `cms_operate_log` VALUES ('140', '6', '/admin/article/edit/30', '1', '1495250612', 'POST', '修改文章成功');
INSERT INTO `cms_operate_log` VALUES ('141', '6', '/admin/article/back/34,35,29,31,32,33,26,27,28', '1', '1495250623', 'GET', '还原文章成功');
INSERT INTO `cms_operate_log` VALUES ('142', '6', '/admin/article/cancel/26', '1', '1495250632', 'GET', '撤销发布文章成功');
INSERT INTO `cms_operate_log` VALUES ('143', '6', '/admin/article/edit/26', '1', '1495250639', 'POST', '修改文章成功');
INSERT INTO `cms_operate_log` VALUES ('144', '6', '/admin/article/edit/27', '1', '1495250648', 'POST', '修改文章成功');
INSERT INTO `cms_operate_log` VALUES ('145', '6', '/admin/article/edit/28', '1', '1495250655', 'POST', '修改文章成功');
INSERT INTO `cms_operate_log` VALUES ('146', '6', '/admin/article/add', '1', '1495250680', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('147', '6', '/admin/article/add', '1', '1495250696', 'POST', '添加文章成功');
INSERT INTO `cms_operate_log` VALUES ('148', '6', '/admin/admin/del/14', '1', '1495262673', 'GET', '删除管理员成功');
INSERT INTO `cms_operate_log` VALUES ('149', '6', '/admin/admin/del/15', '1', '1495262679', 'GET', '删除管理员成功');

-- ----------------------------
-- Table structure for cms_perm
-- ----------------------------
DROP TABLE IF EXISTS `cms_perm`;
CREATE TABLE `cms_perm` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `parentid` int(11) unsigned NOT NULL COMMENT '权限id',
  `name` char(10) NOT NULL COMMENT '权限名称',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否可用（0：不可用，1：可用）',
  `router` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_perm
-- ----------------------------
INSERT INTO `cms_perm` VALUES ('1', '0', '角色管理', '0', '1', '/admin/role/index');
INSERT INTO `cms_perm` VALUES ('2', '1', '角色列表', '0', '1', '/admin/role/index');
INSERT INTO `cms_perm` VALUES ('3', '1', '角色授权', '0', '1', '/admin/role/access');
INSERT INTO `cms_perm` VALUES ('4', '1', '角色添加', '0', '1', '/admin/role/add');
INSERT INTO `cms_perm` VALUES ('5', '1', '角色修改', '0', '1', '/admin/role/edit');
INSERT INTO `cms_perm` VALUES ('6', '1', '角色删除', '0', '1', '/admin/role/del');
INSERT INTO `cms_perm` VALUES ('12', '0', '管理员管理', '0', '1', '/admin/admin/index');
INSERT INTO `cms_perm` VALUES ('13', '12', '管理员列表', '0', '1', '/admin/admin/index');
INSERT INTO `cms_perm` VALUES ('14', '12', '管理员添加', '0', '1', '/admin/admin/add');
INSERT INTO `cms_perm` VALUES ('15', '12', '管理员修改', '0', '1', '/admin/admin/edit');
INSERT INTO `cms_perm` VALUES ('16', '12', '管理员删除', '0', '1', '/admin/admin/del');
INSERT INTO `cms_perm` VALUES ('17', '0', '控制中心', '0', '1', '/admin/dashboard/index');
INSERT INTO `cms_perm` VALUES ('18', '17', '控制中心', '0', '1', '/admin/dashboard/index');
INSERT INTO `cms_perm` VALUES ('19', '0', '栏目管理', '0', '1', '/admin/class/index');
INSERT INTO `cms_perm` VALUES ('20', '19', '栏目列表', '0', '1', '/admin/class/index');
INSERT INTO `cms_perm` VALUES ('21', '19', '栏目添加', '0', '1', '/admin/class/add');
INSERT INTO `cms_perm` VALUES ('22', '19', '栏目修改', '0', '1', '/admin/class/edit');
INSERT INTO `cms_perm` VALUES ('23', '19', '栏目删除', '0', '1', '/admin/class/del');
INSERT INTO `cms_perm` VALUES ('24', '0', '文章管理', '0', '1', '/admin/article/index');
INSERT INTO `cms_perm` VALUES ('25', '24', '文章列表', '0', '1', '/admin/article/index');
INSERT INTO `cms_perm` VALUES ('26', '24', '文章添加', '0', '1', '/admin/article/add');
INSERT INTO `cms_perm` VALUES ('27', '24', '文章修改', '0', '1', '/admin/article/edit');
INSERT INTO `cms_perm` VALUES ('28', '24', '文章删除', '0', '1', '/admin/article/del');
INSERT INTO `cms_perm` VALUES ('29', '24', '添加至回收站', '0', '1', '/admin/article/recycle');
INSERT INTO `cms_perm` VALUES ('30', '24', '撤销发布', '0', '1', '/admin/article/cancel');
INSERT INTO `cms_perm` VALUES ('31', '24', '发布文章', '0', '1', '/admin/article/publish');
INSERT INTO `cms_perm` VALUES ('32', '0', '文档回收站', '0', '1', '/admin/article/rubbish');
INSERT INTO `cms_perm` VALUES ('33', '32', '回收站列表', '0', '1', '/admin/article/rubbish');
INSERT INTO `cms_perm` VALUES ('34', '32', '还原文章', '0', '1', '/admin/article/back');
INSERT INTO `cms_perm` VALUES ('35', '0', '系统配置管理', '0', '1', '/admin/config/system');
INSERT INTO `cms_perm` VALUES ('36', '35', '配置列表', '0', '1', '/admin/config/system');
INSERT INTO `cms_perm` VALUES ('40', '0', '扩展配置管理', '0', '1', '/admin/config/extend');
INSERT INTO `cms_perm` VALUES ('41', '40', '扩展配置列表', '0', '1', '/admin/config/extend');
INSERT INTO `cms_perm` VALUES ('42', '0', '登录日志管理', '0', '1', '/admin/log/loginlog');
INSERT INTO `cms_perm` VALUES ('43', '42', '日志列表', '0', '1', '/admin/log/loginlog');
INSERT INTO `cms_perm` VALUES ('44', '42', '删除日志', '0', '1', '/admin/log/del');
INSERT INTO `cms_perm` VALUES ('45', '40', '添加配置', '0', '1', '/admin/config/add');
INSERT INTO `cms_perm` VALUES ('46', '40', '修改配置', '0', '1', '/admin/config/edit');
INSERT INTO `cms_perm` VALUES ('47', '40', '删除配置', '0', '1', '/admin/config/del');
INSERT INTO `cms_perm` VALUES ('48', '0', '操作日志管理', '0', '1', '/admin/log/operatelog');
INSERT INTO `cms_perm` VALUES ('49', '48', '日志列表', '0', '1', '/admin/log/operatelog');
INSERT INTO `cms_perm` VALUES ('51', '48', '删除日志', '0', '1', '/admin/log/deloperate');
INSERT INTO `cms_perm` VALUES ('52', '12', '查看登录日志', '0', '1', '/admin/admin/loginlog');
INSERT INTO `cms_perm` VALUES ('53', '12', '查看操作日志', '0', '1', '/admin/admin/operatelog');
INSERT INTO `cms_perm` VALUES ('54', '12', '发送消息', '0', '1', '/admin/admin/sendmsg');
INSERT INTO `cms_perm` VALUES ('55', '12', '查看所有消息', '0', '1', '/admin/admin/allmsg');

-- ----------------------------
-- Table structure for cms_role
-- ----------------------------
DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色主键',
  `parentid` int(11) unsigned NOT NULL COMMENT '父角色id',
  `name` varchar(30) NOT NULL COMMENT '角色名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `description` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `sort` tinyint(255) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_role
-- ----------------------------
INSERT INTO `cms_role` VALUES ('1', '0', '超级管理员', '1', '拥有所有权限', '1492863505', '0');
INSERT INTO `cms_role` VALUES ('19', '1', '文章管理员', '1', '文章管理员', '1494055761', '0');
INSERT INTO `cms_role` VALUES ('20', '19', '文章发布员', '1', '文章发布员', '1494056264', '0');

-- ----------------------------
-- Table structure for cms_role_perm
-- ----------------------------
DROP TABLE IF EXISTS `cms_role_perm`;
CREATE TABLE `cms_role_perm` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色权限id',
  `rid` int(11) unsigned NOT NULL COMMENT '角色id',
  `pid` int(11) unsigned NOT NULL COMMENT '权限id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_role_perm
-- ----------------------------
INSERT INTO `cms_role_perm` VALUES ('75', '19', '17');
INSERT INTO `cms_role_perm` VALUES ('76', '19', '18');
INSERT INTO `cms_role_perm` VALUES ('77', '19', '24');
INSERT INTO `cms_role_perm` VALUES ('78', '19', '25');
INSERT INTO `cms_role_perm` VALUES ('79', '19', '26');
INSERT INTO `cms_role_perm` VALUES ('80', '19', '27');
INSERT INTO `cms_role_perm` VALUES ('81', '19', '28');
INSERT INTO `cms_role_perm` VALUES ('82', '19', '29');
INSERT INTO `cms_role_perm` VALUES ('83', '19', '30');
INSERT INTO `cms_role_perm` VALUES ('84', '19', '31');
INSERT INTO `cms_role_perm` VALUES ('85', '19', '32');
INSERT INTO `cms_role_perm` VALUES ('86', '19', '33');
INSERT INTO `cms_role_perm` VALUES ('87', '19', '34');
INSERT INTO `cms_role_perm` VALUES ('101', '20', '17');
INSERT INTO `cms_role_perm` VALUES ('102', '20', '18');
INSERT INTO `cms_role_perm` VALUES ('103', '20', '24');
INSERT INTO `cms_role_perm` VALUES ('104', '20', '25');
INSERT INTO `cms_role_perm` VALUES ('105', '20', '26');
INSERT INTO `cms_role_perm` VALUES ('106', '21', '17');
INSERT INTO `cms_role_perm` VALUES ('107', '21', '18');
INSERT INTO `cms_role_perm` VALUES ('108', '21', '24');
INSERT INTO `cms_role_perm` VALUES ('109', '21', '25');
INSERT INTO `cms_role_perm` VALUES ('110', '21', '26');
INSERT INTO `cms_role_perm` VALUES ('111', '21', '27');
INSERT INTO `cms_role_perm` VALUES ('112', '21', '28');
INSERT INTO `cms_role_perm` VALUES ('113', '21', '29');
INSERT INTO `cms_role_perm` VALUES ('114', '21', '30');
INSERT INTO `cms_role_perm` VALUES ('115', '21', '31');
INSERT INTO `cms_role_perm` VALUES ('116', '21', '32');
INSERT INTO `cms_role_perm` VALUES ('117', '21', '33');
INSERT INTO `cms_role_perm` VALUES ('118', '21', '34');
INSERT INTO `cms_role_perm` VALUES ('119', '22', '17');
INSERT INTO `cms_role_perm` VALUES ('120', '22', '18');
INSERT INTO `cms_role_perm` VALUES ('121', '22', '24');
INSERT INTO `cms_role_perm` VALUES ('122', '22', '25');
INSERT INTO `cms_role_perm` VALUES ('123', '22', '26');
