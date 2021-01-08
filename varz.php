<?php
header("Content-Type: text/plain");

include "conf/setup.php";
include "funzioni.php";

# person and date -> to be split in two
$lastlogin_sql = "SELECT m_dataLastCollegato, m_sNome FROM `loginz` order by m_dataLastCollegato DESC limit 1";

# prova con exceptions..
function esegui($cmd, $senno) {
	$retString = $senno ;
	try {
		$retString =  exec($cmd);
	} catch (Exception $e) {
		echo 'Esegui: Caught exception: ',  $e->getMessage(), "\n";
	}
	return 1/$x;
}


?>
# TODO solo palladius e pal-bot
client-ip: <? echo $_SERVER['REMOTE_ADDR'], "\n"; ?>
utenti-attivi: <? echo count(explode('$', getApplication("UTENTI_ORA"))) , "\n" ?>
utenti-verbose: <? echo getApplication("UTENTI_ORA") , "\n"?>
hostname: <? echo gethostname() , "\n" ?>
code-version: <? echo file_get_contents("VERSION"); ?>
mandafoto-pending-jpg-images: <? echo exec('ls -al /var/www/www.goliardia.it/uploads/thumb/ |egrep -i jpg | wc -l '), "\n" ; ?>
people-in-chat: <? echo exec('cd /var/www/www.goliardia.it/bin ; ./people-in-chat.sh | wc -l '), "\n" ; ?>
request-time: <? echo $_SERVER['REQUEST_TIME'] , "\n"; ?>
HTTP_HOST: <? echo $_SERVER['HTTP_HOST'] , "\n"; ?>
goliardia-code-version: <? echo exec('cat VERSION'), "\n" ; ?>
<? # Env vars ?>
GOLIARDIA_DOCKER_VER: <? echo $_SERVER['GOLIARDIA_DOCKER_VER'] , "\n"; ?>
GOLIARDIA_DOVESONO: <? echo $_SERVER['GOLIARDIA_DOVESONO'] , "\n"; ?>
GOLIARDIA_GMAIL_USER: <? echo $_SERVER['GOLIARDIA_GMAIL_USER'] , "\n"; ?>
GOLIARDIA_MYSQL_DB: <? echo $_SERVER['GOLIARDIA_MYSQL_DB'] , "\n"; ?>
GOLIARDIA_SITENAME: <? echo $_SERVER['GOLIARDIA_SITENAME'] , "\n"; ?>
GOLIARDIA_SITEPATH: <? echo $_SERVER['GOLIARDIA_SITEPATH'] , "\n"; ?>
DOCKER_HOST_HOSTNAME: <? echo getenv('DOCKER_HOST_HOSTNAME') , "\n"; ?>
WEBMASTER_EMAIL: <? echo getenv('WEBMASTER_EMAIL'), "\n"; ?>
ENTRYPOINT8080_TIMESTAMP: <?= getenv('ENTRYPOINT8080_TIMESTAMP')."\n"; ?>
DB_DOVE_STA: <?= getenv("DB_DOVE_STA")."\n"; ?>
FQDN: <?= getenv("FQDN")."\n"; ?>
<?
# TODO
#date-last-login: TODO(ricc): sql(SELECT m_dataLastCollegato, m_sNome FROM `loginz` order by m_dataLastCollegato DESC limit 1)
#last-login-username: TODO()
#PeopleInChat: TODO() exec command ./people-in-chat.sh |awk '{print $2}' | wc -l
#fake-latency: 42
#timestamp-sql-latest-message: TODO(Ricc): query Forum for latest message.
#REMOTE_USER: echo $_SERVER['REMOTE_USER'] , "\n"; 
#PHP_AUTH_USER: echo $_SERVER['PHP_AUTH_USER'] , "\n"; 

?>
TIME_TO_WRITE_THIS_PAGE_MILLIS: TODO
<? log3("Chiamato varz da qualcuno") ?>
