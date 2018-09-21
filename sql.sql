
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for classification
-- ----------------------------
DROP TABLE IF EXISTS `classification`;
CREATE TABLE `classification` (
  `id` int(11) NOT NULL COMMENT '分类id',
  `name` varchar(32) DEFAULT NULL COMMENT '分类名称',
  `order` int(11) DEFAULT NULL COMMENT '分类排序,数值越小越靠前',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='软件分类表';

-- ----------------------------
-- Table structure for operation_hst
-- ----------------------------
DROP TABLE IF EXISTS `operation_hst`;
CREATE TABLE `operation_hst` (
  `id` int(11) NOT NULL COMMENT '操作id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `operation` enum('退出登录','登录','浏览软件','下载','修改资料') DEFAULT '登录' COMMENT '操作,0退出登录1登录2浏览软件3下载4修改资料',
  `time` datetime DEFAULT NULL COMMENT '操作时间',
  `ip` varchar(32) DEFAULT NULL COMMENT '操作IP',
  `address` varchar(32) DEFAULT NULL COMMENT '操作地址',
  `sw_name` varchar(128) DEFAULT NULL COMMENT '软件名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户操作历史表';

-- ----------------------------
-- Table structure for software
-- ----------------------------
DROP TABLE IF EXISTS `software`;
CREATE TABLE `software` (
  `id` int(11) NOT NULL COMMENT '软件ID',
  `name` varchar(32) DEFAULT NULL COMMENT '软件名称',
  `cover` varchar(1024) DEFAULT NULL COMMENT '软件封面',
  `language` varchar(32) DEFAULT NULL COMMENT '软件语言',
  `platform` varchar(32) DEFAULT NULL COMMENT '应用平台',
  `description` varchar(1024) DEFAULT NULL COMMENT '软件简介',
  `manufactor` varchar(32) DEFAULT NULL COMMENT '软件厂家',
  `classification` varchar(32) DEFAULT NULL COMMENT '软件分类',
  `download` varchar(3120) DEFAULT NULL COMMENT '下载地址',
  `dl_times` varchar(32) DEFAULT NULL COMMENT '下载次数',
  `fun_intro` varchar(32) DEFAULT NULL COMMENT '功能介绍',
  `feature` varchar(32) DEFAULT NULL COMMENT '软件特色',
  `installation_steps` varchar(32) DEFAULT NULL COMMENT '安装步骤',
  `update_log` varchar(32) DEFAULT NULL COMMENT '更新日志',
  `q_a` varchar(32) DEFAULT NULL COMMENT '常见问答',
  `editor_comments` varchar(32) DEFAULT NULL COMMENT '编辑点评',
  `created_att` datetime DEFAULT NULL COMMENT '上架时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `size` varchar(32) DEFAULT NULL COMMENT '软件大小(KB)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='软件表';

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT '用户ID',
  `name` varchar(128) DEFAULT NULL COMMENT '用户名',
  `email` varchar(128) DEFAULT NULL COMMENT '用户邮箱',
  `avatar` varchar(1024) DEFAULT NULL COMMENT '用户头像',
  `dl_times` int(11) DEFAULT NULL COMMENT '下载次数',
  `password` varchar(128) DEFAULT NULL COMMENT '用户密码',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';
