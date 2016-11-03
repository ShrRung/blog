SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `cat_article`;
CREATE TABLE `cat_article` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文章表';

insert into `cat_article`(`art_id`,`cate_id`,`title`,`content`,`abstract`,`sort`,`top`,`view`,`video_id`,`create_time`,`modify_time`) values('2','5','郭德纲的12','### Hello Editor.md !2323','更多23','61','1','1','0','2016-11-02 02:03:42','2016-11-02 05:32:11');
