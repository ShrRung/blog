-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 �?11 �?02 �?17:56
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
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL,
  `abstract` varchar(255) NOT NULL COMMENT '摘要',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '由大到小排序',
  `top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `view` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:显示;0:不显示',
  `video_id` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后修改时间',
  PRIMARY KEY (`art_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `cat_article`
--

INSERT INTO `cat_article` (`art_id`, `cate_id`, `title`, `content`, `abstract`, `sort`, `top`, `view`, `video_id`, `create_time`, `modify_time`) VALUES
(2, 5, '郭德纲的12', '### Hello Editor.md !2323', '更多23', 61, 1, 1, 0, '2016-11-02 02:03:42', '2016-11-02 05:32:11');

-- --------------------------------------------------------

--
-- 表的结构 `cat_article_tag`
--

CREATE TABLE IF NOT EXISTS `cat_article_tag` (
  `art_id` int(11) NOT NULL COMMENT '文章id',
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  KEY `art_id` (`art_id`),
  KEY `tag_id` (`tag_id`),
  KEY `tag_id_2` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章标签表';

--
-- 转存表中的数据 `cat_article_tag`
--

INSERT INTO `cat_article_tag` (`art_id`, `tag_id`) VALUES
(2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `cat_categorys`
--

CREATE TABLE IF NOT EXISTS `cat_categorys` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL COMMENT '分类名',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '目录阶级',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '由大到小排序',
  `status` tinyint(1) NOT NULL COMMENT '状态1',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章分类表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `cat_categorys`
--

INSERT INTO `cat_categorys` (`cate_id`, `title`, `pid`, `level`, `sort`, `status`) VALUES
(1, '技术文章', 0, 1, 0, 1),
(3, 'PHP文章', 1, 2, 23, 1),
(5, '情感文章', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cat_config`
--

CREATE TABLE IF NOT EXISTS `cat_config` (
  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `descript` varchar(255) NOT NULL,
  `homepage` varchar(255) DEFAULT NULL COMMENT '主页',
  `logo` varchar(255) NOT NULL COMMENT '图片logo',
  `ico` varchar(255) DEFAULT NULL COMMENT 'ico图片',
  `keywords` varchar(255) NOT NULL COMMENT '网站关键词',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '二维码图片',
  `copyright` varchar(60) NOT NULL,
  `author` varchar(50) NOT NULL COMMENT '作者',
  `author_email` varchar(50) NOT NULL COMMENT '作者邮箱',
  PRIMARY KEY (`conf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站基本信息配置表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `cat_config`
--

INSERT INTO `cat_config` (`conf_id`, `name`, `descript`, `homepage`, `logo`, `ico`, `keywords`, `qrcode`, `copyright`, `author`, `author_email`) VALUES
(1, 'lazycat个人博客', '方师傅师傅', 'http://www.thinkphptest.com', '\\uploads\\logo\\20161031\\47c158ab124305e14b8b6e79545fc763.png', '/uploads', 'lazycat，个人博客，PHP，thinkphp', '/uploads', 'Copyright LazyCat ©2016 All rights reserved   ', 'lazycat', '1026825079@qq.com');

-- --------------------------------------------------------

--
-- 表的结构 `cat_link`
--

CREATE TABLE IF NOT EXISTS `cat_link` (
  `link_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '友链名',
  `url` varchar(255) NOT NULL COMMENT '网站链接',
  `logo` varchar(255) DEFAULT NULL COMMENT '图片logo',
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
  `pid` int(11) NOT NULL COMMENT '父级节点id',
  `level` int(2) NOT NULL DEFAULT '0' COMMENT '节点等级',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `pid_2` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- 转存表中的数据 `cat_node`
--

INSERT INTO `cat_node` (`id`, `node_name`, `module_name`, `control_name`, `action_name`, `is_menu`, `pid`, `level`, `style`) VALUES
(1, '用户管理', '#', '#', '#', 2, 0, 1, 'fa fa-users'),
(2, '用户列表', 'admin', 'user', 'index', 2, 1, 2, ''),
(3, '添加用户', 'admin', 'user', 'useradd', 1, 2, 3, ''),
(4, '编辑用户', 'admin', 'user', 'useredit', 1, 2, 3, ''),
(5, '删除用户', 'admin', 'user', 'userdel', 1, 2, 3, ''),
(6, '角色列表', 'admin', 'role', 'index', 2, 1, 2, ''),
(7, '添加角色', 'admin', 'role', 'roleadd', 1, 6, 3, ''),
(8, '编辑角色', 'admin', 'role', 'roleedit', 1, 6, 3, ''),
(9, '删除角色', 'admin', 'role', 'roledel', 1, 6, 3, ''),
(10, '分配权限', 'admin', 'role', 'giveaccess', 1, 6, 3, ''),
(11, '系统管理', '#', '#', '#', 2, 0, 1, 'fa fa-desktop'),
(12, '数据备份/还原', 'admin', 'data', 'index', 2, 11, 2, ''),
(13, '备份数据', 'admin', 'data', 'importdata', 1, 12, 3, ''),
(14, '还原数据', 'admin', 'data', 'backdata', 1, 12, 3, ''),
(15, '菜单管理', 'admin', 'menu', 'index', 2, 11, 2, ''),
(24, '编辑菜单', 'admin', 'menu', 'menuEdit', 1, 15, 3, ''),
(26, '删除菜单', 'admin', 'menu', 'menudel', 1, 15, 3, ''),
(27, '文章管理', 'admin', '#', '#', 2, 0, 1, 'fa fa-navicon'),
(28, '网站配置', 'admin', 'site', 'index', 2, 11, 2, ''),
(29, '文章列表', 'admin', 'article', 'index', 2, 27, 2, ''),
(30, '添加文章', 'admin', 'article', 'articleadd', 1, 29, 3, ''),
(31, '编辑文章', 'admin', 'article', 'articleedit', 1, 29, 3, ''),
(32, '删除文章', 'admin', 'article', 'articledel', 1, 29, 3, ''),
(33, '文章分类', 'admin', 'categorys', 'index', 2, 27, 2, ''),
(34, '文章标签', 'admin', 'tag', 'index', 2, 27, 2, ''),
(35, '添加分类', 'admin', 'categorys', 'categoryadd', 1, 33, 3, ''),
(36, '修改分类', 'admin', 'categorys', 'categoryedit', 1, 33, 3, ''),
(37, '删除分类', 'admin', 'categorys', 'categorydel', 1, 33, 3, ''),
(40, '添加标签', 'admin', 'tag', 'tagadd', 1, 34, 3, ''),
(41, '编辑标签', 'admin', 'tag', 'tagedit', 1, 34, 3, ''),
(42, '删除标签', 'admin', 'tag', 'tagdel', 1, 34, 3, ''),
(43, '置顶文章', 'admin', 'article', 'changearttop', 1, 29, 3, ''),
(44, '修改文章状态', 'admin', 'article', 'changeartview', 1, 29, 3, ''),
(45, '友链管理', 'admin', 'link', 'index', 2, 11, 2, ''),
(46, '添加链接', 'admin', 'link', 'linkadd', 1, 45, 3, ''),
(47, '编辑友链', 'admin', 'link', 'linkedit', 1, 45, 3, ''),
(48, '删除友链', 'admin', 'link', 'linkdel', 1, 45, 3, ''),
(49, '音频管理', 'admin', '#', '#', 2, 0, 1, 'fa fa-tasks'),
(50, '音频列表', 'admin', 'video', 'index', 2, 49, 2, ''),
(51, '个人管理', 'admin', '#', '#', 2, 0, 1, 'fa fa-pencil'),
(52, '修改个人密码', 'admin', 'personnel', 'changepassword', 2, 51, 2, ''),
(53, '添加音频', 'admin', 'video', 'videoadd', 1, 50, 3, ''),
(54, '修改音频', 'admin', 'video', 'videoedit', 1, 50, 3, ''),
(55, '删除音频', 'admin', 'video', 'videodel', 1, 50, 3, '');

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
(3, '新闻发布员', '1,2,3,4,5,6,7,10,11,12,13,14,27,29,30,31,32,43,44,33,35,36,37,34,40,41,42');

-- --------------------------------------------------------

--
-- 表的结构 `cat_tag`
--

CREATE TABLE IF NOT EXISTS `cat_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL COMMENT '标签内容',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='标签表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `cat_tag`
--

INSERT INTO `cat_tag` (`tag_id`, `title`) VALUES
(2, 'LNMP'),
(3, 'THINKPHP');

-- --------------------------------------------------------

--
-- 表的结构 `cat_user`
--

CREATE TABLE IF NOT EXISTS `cat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '密码',
  `avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `loginnum` int(11) DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '真实姓名',
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '电子邮件',
  `status` int(1) DEFAULT '0' COMMENT '状态',
  `typeid` int(11) DEFAULT '1' COMMENT '用户角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `cat_user`
--

INSERT INTO `cat_user` (`id`, `username`, `password`, `avatar`, `loginnum`, `last_login_ip`, `last_login_time`, `real_name`, `email`, `status`, `typeid`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '\\uploads\\avatar\\20161027\\7f29e5284146fc97ba98558e32662de4.png', 70, '127.0.0.1', 1478075088, 'admin', NULL, 1, 1),
(2, 'xiaobai', '4297f44b13955235245b2497399d7a93', '\\uploads\\avatar\\20161027\\9ca5e756295b3fe7ec09c1da203dec1e.png', 6, '127.0.0.1', 1470368260, '小白122123', NULL, 1, 2),
(4, 'root', '63a9f0ea7bb98050796b649e85481845', '\\uploads\\avatar\\20161027\\e4535accf1d3f56f08801839d5260440.png', 0, '', 0, 'root', NULL, 1, 2),
(5, 'test', '098f6bcd4621d373cade4e832627b4f6', '\\uploads\\avatar\\20161027\\65f0ca2d8e0dad2d14b7e138c018f050.jpg', 2, '127.0.0.1', 1477640067, 'test', NULL, 1, 2),
(6, 'zhangcong', '84fa8a6653af9145522baab2051e2b76', '\\uploads\\avatar\\20161027\\5854d67a16900ae22066d20aa17d5d3c.png', 7, '127.0.0.1', 1478075055, '234234', NULL, 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `cat_video`
--

CREATE TABLE IF NOT EXISTS `cat_video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '媒体地址',
  `img` varchar(255) DEFAULT NULL COMMENT '媒体封面',
  `lrc` varchar(255) DEFAULT NULL COMMENT '字幕，歌词',
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体资源表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
