<?php
header("Content-Type: text/plain");

include "conf/setup.php";
include "funzioni.php";

?>
ClientIp: <? echo $_SERVER['REMOTE_ADDR']; ?>
UtentiAttivi: <? echo count(explode('$', getApplication("UTENTI_ORA"))) , "\n" ?>
UtentiVerbose: <? echo getApplication("UTENTI_ORA") , "\n"?>
hostname: <? echo gethostname() , "\n" ?>
VERSION: <? echo file_get_contents("VERSION"); ?>
# TODO
FakeLatency: 42
TimestampLatestMessage: TODO(Ricc)
PeopleInChat: TODO() exec command ./people-in-chat.sh |awk '{print $2}' | wc -l
 
