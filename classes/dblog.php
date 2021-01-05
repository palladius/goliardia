<?php 

/*

CREATE TABLE `dblogs` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `severity` varchar(20) NOT NULL,
  `facility` varchar(20) NOT NULL,
  `log` longtext NOT NULL,
  `user_id` INT ,
  `user_name` varchar(255) ,
  `docker_context` varchar(500)	
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

Collation: https://mediatemple.net/community/products/dv/204403914/default-mysql-character-set-and-collation#:~:text=The%20default%20character%20set%20for,set%20for%20non%2DLatin%20characters.

*/

class DBLog {
    // TODO

} 




    // statico non di classe
    // TODO astrailo da log2()
function logga($str) {
        $SQL = "INSERT INTO `dblogs`
        ('facility', 'log')
        VALUES (
        );";
        mysql_query($SQL);
    }

?>
