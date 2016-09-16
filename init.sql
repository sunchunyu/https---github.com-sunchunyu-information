#
# Data for table "urp_page"
#

INSERT INTO `urp_page` (`Id`,`name`,`url`,`pid`,`status`,`icon`,`sort`) VALUES (1,'信息采集','/admin/#',0,0,'fa-book',1),(2,'微网站','/admin/#',0,0,'fa-desktop',2),(3,'用户权限','/admin/#',0,0,'fa-group',3),(4,'基础数据','/admin/#',0,0,'fa-gears',4),(5,'信息采集管理','/admin/stud/manage_list',1,0,'',5),(6,'新生信息查询','/admin/stud/freshman_query',1,0,'',6),(7,'学籍信息查询','/admin/stud/status_query',1,0,'',7),(8,'毕业信息查询','/admin/stud/graduation_query',1,0,'',8),(9,'新生信息统计','/admin/stud/freshman_summary',1,0,'',9),(10,'学籍信息统计','/admin/stud/status_summary',1,0,'',10),(11,'毕业信息统计','/admin/stud/graduation_summary',1,0,'',11),(12,'资讯信息管理','/admin/wx/news_list',2,0,'',12),(13,'招聘信息管理','/admin/wx/offer_list',2,0,'',13),(14,'咨询类别管理','/admin/wx/category_list',2,0,'',14),(15,'招聘单位管理','/admin/wx/employer_list',2,0,'',15),(16,'用户信息管理','/admin/urp/user_list',3,0,'',16),(17,'角色信息管理','/admin/urp/role_list',3,0,'',17),(18,'用户角色管理','/admin/urp/user_role_list',3,0,'',18),(19,'角色权限管理','/admin/urp/role_page_list',3,0,'',19),(20,'省市区管理','/admin/dict/county_list',4,0,'',20),(21,'院系管理','/admin/dict/college_list',4,0,'',21),(22,'专业管理','/admin/dict/specialty_list',4,0,'',22),(23,'班级管理','/admin/dict/class_list',4,0,'',23),(24,'民族管理','/admin/dict/nation_list',4,0,'',24),(25,'生源管理','/admin/dict/source_list',4,0,'',25);

#
# Data for table "urp_user"
#

INSERT INTO `urp_user` (`Id`,`name`,`code`,`pwd`,`phone`,`email`,`avatar`,`status`) VALUES (0,'管理员','admin','1ee37656c6aadab18cfb0e2b68184379','','','',0);

