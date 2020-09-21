<?php
header("Content-Type: text/plain");

include "conf/setup.php";
include "funzioni.php";

?>
client-ip: <? echo $_SERVER['REMOTE_ADDR'], "\n"; ?>
utenti-attivi: <? echo count(explode('$', getApplication("UTENTI_ORA"))) , "\n" ?>
utenti-verbose: <? echo getApplication("UTENTI_ORA") , "\n"?>
hostname: <? echo gethostname() , "\n" ?>
code-version: <? echo file_get_contents("VERSION"); ?>
project-id: <? echo exec('curl http://169.254.169.254/0.1/meta-data/project-id'), "\n" ; ?>
# TODO
fake-latency: 42
timestamp-sql-latest-message: TODO(Ricc): query Forum for latest message.
