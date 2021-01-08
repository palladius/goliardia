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

function select_all_dblogs_sql($where_clause, $limit) {
    return "SELECT 
        created,
        user_name,
        `severity`,`facility`,`log`,`user_id`,`ip_address`,`docker_context` 
        FROM `dblogs` 
        $where_clause
        ORDER BY created DESC 
        limit $limit ;
    "; # todo $limit

}

function visualizza_tabella_ultimi_logs() {
	$rs2=mysql_query(select_all_dblogs_sql("", 50));
	scriviRecordSetConTimeout($rs2,1000,
	"Ultimi logs solo PAL",
	"Ultimi DBLogs");
}

function visualizza_tabella_ultimi_logs_by_severities($arr_severities) {
#    $where_clause = " WHERE severity IN ('error',  'fatal')";
    $quoted_list = "'" .  implode("', '",$arr_severities) . "'";
    $where_clause = " WHERE severity IN ($quoted_list)";
	$rs2=mysql_query(select_all_dblogs_sql($where_clause ,5));
	scriviRecordSetConTimeout($rs2,1000,
	"Ultimi logs solo PAL",
	"Ultimi DBLogs su qyueste severities: $quoted_list");
}

    // statico non di classe
function logga($str) {
    dblog("logga", $str);
}

 #Usa: $_SERVER['REQUEST_URI'] is also contaning all query strings, why should I use $_SERVER['QUERY_STRING']
function autolog($str, $severity="notice") {
    // auto facility from file chiamante :)
    $request_url_pieces = explode("/", $_SERVER['REQUEST_URI'] );
    $facility = $request_url_pieces[2];
    dblog($facility,$str, $severity);
}
# ("logs.php", "Vediamo di chiamare dblog DIRETTAMENTE", "info");
// calls INSERT into logs.
function dblog($facility, $frase_da_loggare=NULL, $severity="notice") {
    if ($frase_da_loggare == NULL) {
        autolog($facility); // stretch semantrico - se chiami log da solo forse quella NON era la facility dopotutto :P
        return;
    }
    $frase_da_loggare_mysql_safe = mysql_real_escape_string($frase_da_loggare);
    $ip_address = $_SERVER["REMOTE_ADDR"] ;
    $current_user_id = fetch($_SESSION["_SESS_id_login"] , "NULL");
    $current_user = fetch($_SESSION["_SESS_nickname"], "_CREDO_ANONIMO_") ;
	#$docker_context_concise_escaped = mysql_real_escape_string(  $_SERVER["GOLIARDIA_DOVESONO"] . " @ " . getHostnameAndDockerHostname());
	$docker_context_concise_escaped = mysql_real_escape_string( "[".getHostnameAndDockerHostname()."] " . $_SERVER["GOLIARDIA_DOVESONO"] );

    try {
		$SQL = "INSERT INTO `dblogs` 
		(`id`, `severity`, `facility`, `log`, `user_id`, `user_name`, `docker_context`, `ip_address`) 
		VALUES 
		(NULL, '$severity', '$facility', '$frase_da_loggare_mysql_safe', $current_user_id, '$current_user', '$docker_context_concise_escaped', '$ip_address');
		";
		$rs = mysql_query($SQL);
		if (! $rs) {
			#fputs($fp,"TODO1 ricc add via SQL error: " . mysql_error() );
			die('Invalid query TODO toglimi quando va: ' . mysql_error() . "<br/> La query era $SQL");
		} else {
			fputs($fp,"TODO2 ricc add via SQL error: " . mysql_error() );

		}
	} catch (Exception $e) {
		echo '[log2] Caught exception nel mio delirio di loggare su DB: ',  $e->getMessage(), "\n";
	}
}


?>
