
#此版本为励青春（liqingchun）--V1.1

#创建数据库
create database liqingchun charset utf8;

#选择数据库
use liqingchun;


/*----------------------------用户模块---------------------------*/

#创建用户表
CREATE TABLE li_user (
  user_id INT unsigned not null PRIMARY KEY AUTO_INCREMENT,
  username varchar(30) not null UNIQUE comment '用户登陆账号 ' ,
  password char(32) not null comment '用户登陆密码' 
) engine=MyISAM charset=utf8 comment = 'user table';

/*---------------------------用户模块END-------------------------*/



/*----------------------------文章模块---------------------------*/

#创建文章表
CREATE TABLE li_article (
  article_id int unsigned not null PRIMARY KEY AUTO_INCREMENT,
  title varchar(50) not null comment '文章标题' ,
  brief varchar(255) not null comment '文章简介',
  picture varchar(100) not null comment '文章图片链接',
  content text not null  comment '文章内容' ,
  user_id int not null comment '文章作者' ,
  mdate timestamp not null comment '文章最后修改日期'
) engine=MyISAM charset=utf8;

/*---------------------------文章模块END-------------------------*/



/*----------------------------分类模块---------------------------*/

#创建分类表
CREATE TABLE li_category (
  category_id INT unsigned not null PRIMARY KEY AUTO_INCREMENT,
  name varchar(30) not null UNIQUE comment '分类名 ' 
) engine=MyISAM charset=utf8 comment = 'category table';

/*---------------------------分类模块END-------------------------*/



/*---------------------------版权信息----------------------------*/

--©励青春（liqingchun）最终解释权归 西邮web开发交流群（271266597） 所有。支持正版，盗版必究

/*---------------------------版权信息END-------------------------*/