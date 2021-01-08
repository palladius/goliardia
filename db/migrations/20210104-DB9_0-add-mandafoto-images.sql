-- v2 con onbehalfof
-- v3 con unicity di Md5+userid

-- DROP TABLE `mandafoto_images`;

CREATE TABLE `mandafoto_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image` longtext NOT NULL,
  `image_md5` varchar(40) CHARACTER SET utf8 DEFAULT NULL COMMENT 'da implementare ancora e usare per unicita',
  `status` varchar(20) DEFAULT '00-NEW',
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8,
  `admin_user_id` int(11) DEFAULT NULL COMMENT 'id login dell utente amministratore che ha modificato questo per ultimo',
  `admin_description` text CHARACTER SET utf8,
  `docker_context` varchar(500) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Contesto di esecuzione tipo hostname e qualche va ENV che mi aiuti a capire dove sono i files',
  `on_behalf_of_user_id` int(11) DEFAULT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

ALTER TABLE `mandafoto_images` ADD UNIQUE( `image_md5`);
-- per doppio: https://www.mysqltutorial.org/mysql-unique-constraint/#:~:text=A%20UNIQUE%20constraint%20is%20an,constraint%20or%20a%20table%20constraint.&text=In%20this%20syntax%2C%20you%20include,to%20enforce%20the%20uniqueness%20rule.
-- ma attento questo mi dava syntax error:
--  UNIQUE KEY `un_solo_md5_per_utente` (`user_id`,`image_md5`)

UPDATE xxx_memoz SET valore = "9.0" WHERE chiave = "DB_VER";
