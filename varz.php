<?php
header("Content-Type: text/plain");

include "conf/setup.php";
include "funzioni.php";

?>
ClientIp: <? echo $_SERVER['REMOTE_ADDR']; ?> 
UtentiAttivi: <? echo count(explode('$', getApplication("UTENTI_ORA"))) , "\n" ?>
UtentiVerbose: <? echo getApplication("UTENTI_ORA") , "\n"?>
FakeLatency: 42
TimestampLatestMessage: TODO(Ricc)
VERSION: <? echo file_get_contents("VERSION"); ?>

