<?php
header("Content-Type: text/plain");

include "conf/setup.php";
include "funzioni.php";

?>
ClientIp: <? echo $_SERVER['REMOTE_ADDR']; ?> 
UtentiAttivi: <? echo count(explode('$', getApplication("UTENTI_ORA"))) ?>

UtentiVerbose: <? echo getApplication("UTENTI_ORA") ?>

FakeLatency: 42
