<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

if (! Session("ADMIN")) 
	accertaAdministratorAltrimentiBona();
else 
	scrivib(rosso("Benvenuto, Administrator...<br>"));

if ($DEBUG && RailsEnv() != 'production' ) {
    log2("Loggo a cazzo di cane tanto non siamo in prod.. testing logs :)");
    dblog("logs.php", "Vediamo di chiamare dblog DIRETTAMENTE con l'apostrofo", "info");
    autolog("Vediamo di chiamare con la FACILITY in automatico", "notice");
    dblog("prova sdingola");
}
?>
<h1>Most important logs in <?= RailsEnv() ?></h1>

<? visualizza_tabella_ultimi_logs_by_severities(array("fatal", "error")) ?>


<h1>ALL logs in <?= RailsEnv() ?></h1>

    <? visualizza_tabella_ultimi_logs() ?>




<?php 
    include "footer.php";
?>