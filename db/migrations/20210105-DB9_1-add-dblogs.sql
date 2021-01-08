-- ok sto copiando lidea da rails lo ammetto

CREATE TABLE `dblogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `severity` varchar(20) NOT NULL,
  `facility` varchar(20) NOT NULL,
  `log` longtext CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `docker_context` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

ALTER TABLE `dblogs` ADD `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date creation' AFTER `docker_context`;
ALTER TABLE `dblogs` ADD `ip_address` VARCHAR(16) NULL DEFAULT NULL COMMENT 'IP address dell utente' AFTER `user_name`;

UPDATE xxx_memoz SET valore = "9.1" WHERE chiave = "DB_VER";
