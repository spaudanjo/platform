CREATE TABLE `site` (
  `site_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `domain` varchar(100) NOT NULL DEFAULT '',
  `custom_domain` varchar(100) NOT NULL DEFAULT '',
  `active` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `db_hostname` varchar(100) NOT NULL DEFAULT '',
  `db_username` varchar(100) NOT NULL DEFAULT '',
  `db_password` varchar(100) NOT NULL DEFAULT '',
  `db_database` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;