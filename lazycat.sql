-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 �?10 �?26 �?18:07
-- 服务器版本: 5.5.40
-- PHP 版本: 5.5.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lazycat`
--

-- --------------------------------------------------------

--
-- 表的结构 `cat_article`
--

CREATE TABLE IF NOT EXISTS `cat_article` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '标签名，以“;”隔开',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `abstract` varchar(255) NOT NULL COMMENT '摘要',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '由大到小排序',
  `view` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:显示;0:不显示',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `modify_time` int(10) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`art_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cat_category`
--

CREATE TABLE IF NOT EXISTS `cat_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL COMMENT '分类名',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '由大到小排序',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cat_link`
--

CREATE TABLE IF NOT EXISTS `cat_link` (
  `link_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '友链名',
  `url` varchar(255) NOT NULL COMMENT '网站链接',
  `logo` varchar(255) NOT NULL COMMENT '图片logo',
  `view` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:显示;0:不显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '降序排序',
  `create_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友链表';

-- --------------------------------------------------------

--
-- 表的结构 `cat_node`
--

CREATE TABLE IF NOT EXISTS `cat_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `module_name` varchar(155) NOT NULL DEFAULT '' COMMENT '模块名',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `typeid` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `cat_node`
--

INSERT INTO `cat_node` (`id`, `node_name`, `module_name`, `control_name`, `action_name`, `is_menu`, `typeid`, `style`) VALUES
(1, '用户管理', '#', '#', '#', 2, 0, 'fa fa-users'),
(2, '用户列表', 'admin', 'user', 'index', 2, 1, ''),
(3, '添加用户', 'admin', 'user', 'useradd', 1, 2, ''),
(4, '编辑用户', 'admin', 'user', 'useredit', 1, 2, ''),
(5, '删除用户', 'admin', 'user', 'userdel', 1, 2, ''),
(6, '角色列表', 'admin', 'role', 'index', 2, 1, ''),
(7, '添加角色', 'admin', 'role', 'roleadd', 1, 6, ''),
(8, '编辑角色', 'admin', 'role', 'roleedit', 1, 6, ''),
(9, '删除角色', 'admin', 'role', 'roledel', 1, 6, ''),
(10, '分配权限', 'admin', 'role', 'giveaccess', 1, 6, ''),
(11, '系统管理', '#', '#', '#', 2, 0, 'fa fa-desktop'),
(12, '数据备份/还原', 'admin', 'data', 'index', 2, 11, ''),
(13, '备份数据', 'admin', 'data', 'importdata', 1, 12, ''),
(14, '还原数据', 'admin', 'data', 'backdata', 1, 12, '');

-- --------------------------------------------------------

--
-- 表的结构 `cat_role`
--

CREATE TABLE IF NOT EXISTS `cat_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rolename` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `cat_role`
--

INSERT INTO `cat_role` (`id`, `rolename`, `rule`) VALUES
(1, '超级管理员', ''),
(2, '系统维护员', '1,2,3,4,5,6,7,8,9,10'),
(3, '新闻发布员', '1,2,3,4,5,6,7,10');

-- --------------------------------------------------------

--
-- 表的结构 `cat_tag`
--

CREATE TABLE IF NOT EXISTS `cat_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL COMMENT '标签内容',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cat_user`
--

CREATE TABLE IF NOT EXISTS `cat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '密码',
  `loginnum` int(11) DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '真实姓名',
  `status` int(1) DEFAULT '0' COMMENT '状态',
  `typeid` int(11) DEFAULT '1' COMMENT '用户角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `cat_user`
--

INSERT INTO `cat_user` (`id`, `username`, `password`, `loginnum`, `last_login_ip`, `last_login_time`, `real_name`, `status`, `typeid`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 34, '127.0.0.1', 1477470195, 'admin', 1, 1),
(2, 'xiaobai', '4297f44b13955235245b2497399d7a93', 6, '127.0.0.1', 1470368260, '小白122123', 1, 2),
(4, 'root', '63a9f0ea7bb98050796b649e85481845', 0, '', 0, 'root', 1, 2),
(5, 'test', '098f6bcd4621d373cade4e832627b4f6', 0, '', 0, 'test', 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
