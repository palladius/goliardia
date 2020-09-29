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
client-ip: <? echo $_SERVER['REMOTE_ADDR'], "\n"; ?>
utenti-attivi: <? echo count(explode('$', getApplication("UTENTI_ORA"))) , "\n" ?>
utenti-verbose: <? echo getApplication("UTENTI_ORA") , "\n"?>
hostname: <? echo gethostname() , "\n" ?>
code-version: <? echo file_get_contents("VERSION"); ?>
project-id: <? echo exec('curl http://169.254.169.254/0.1/meta-data/project-id'), "\n" ; ?>
mandafoto-pending-jpg-images: <? echo exec('ls -al /var/www/www.goliardia.it/uploads/thumb/ |egrep -i jpg | wc -l '), "\n" ; ?>
people-in-chat: <? echo exec('cd /var/www/www.goliardia.it/bin ; ./people-in-chat.sh | wc -l '), "\n" ; ?>
request-time: <? echo $_SERVER['REQUEST_TIME'] , "\n"; ?>
HTTP_HOST: <? echo $_SERVER['HTTP_HOST'] , "\n"; ?>
<? # Env vars ?>
GOLIARDIA_SITEPATH: <? echo $_SERVER['GOLIARDIA_SITEPATH'] , "\n"; ?>
GOLIARDIA_DOVESONO: <? echo $_SERVER['GOLIARDIA_DOVESONO'] , "\n"; ?>
GOLIARDIA_SITENAME: <? echo $_SERVER['GOLIARDIA_SITENAME'] , "\n"; ?>
GOLIARDIA_DOCKER_VER: <? echo $_SERVER['GOLIARDIA_DOCKER_VER'] , "\n"; ?>
GOLIARDIA_GMAIL_USER: <? echo $_SERVER['GOLIARDIA_GMAIL_USER'] , "\n"; ?>
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
