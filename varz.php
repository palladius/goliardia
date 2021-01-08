<?php
header("Content-Type: text/plain");

include "conf/setup.php";
include "funzioni.php";
include "classes/varz.php";

# person and date -> to be split in two
$lastlogin_sql = "SELECT m_dataLastCollegato, m_sNome FROM `loginz` order by m_dataLastCollegato DESC limit 1";

# prova con exceptions..
// function esegui($cmd, $senno) {
// 	$retString = $senno ;
// 	try {
// 		$retString =  exec($cmd);
// 	} catch (Exception $e) {
// 		echo 'Esegui: Caught exception: ',  $e->getMessage(), "\n";
// 	}
// 	return 1/$x;
// }


?>
# TODO solo palladius e pal-bot
utenti-verbose: <? echo getApplication("UTENTI_ORA") , "\n"?>
hostname: <? echo gethostname() , "\n" ?>
code-version: <? echo file_get_contents("VERSION"); ?>
mandafoto-pending-jpg-images: <? echo exec('ls -al /var/www/www.goliardia.it/uploads/thumb/ |egrep -i jpg | wc -l '), "\n" ; ?>
people-in-chat: <? echo exec('cd /var/www/www.goliardia.it/bin ; ./people-in-chat.sh | wc -l '), "\n" ; ?>
request-time: <? echo $_SERVER['REQUEST_TIME'] , "\n"; ?>
HTTP_HOST: <? echo $_SERVER['HTTP_HOST'] , "\n"; ?>
goliardia-code-version: <? echo exec('cat VERSION'), "\n" ; ?>
<?
# TODO
#date-last-login: TODO(ricc): sql(SELECT m_dataLastCollegato, m_sNome FROM `loginz` order by m_dataLastCollegato DESC limit 1)
#last-login-username: TODO()
#PeopleInChat: TODO() exec command ./people-in-chat.sh |awk '{print $2}' | wc -l
#fake-latency: 42
#timestamp-sql-latest-message: TODO(Ricc): query Forum for latest message.
#REMOTE_USER: echo $_SERVER['REMOTE_USER'] , "\n"; 
#PHP_AUTH_USER: echo $_SERVER['PHP_AUTH_USER'] , "\n"; 

	echo get_varz_partial();
	log3("Chiamato varz da qualcuno"); 
	// questo devo per forza farlo nell pagina
?>
TIME_TO_WRITE_THIS_PAGE_MILLIS: TODO