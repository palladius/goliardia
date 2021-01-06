<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "classes/dblog.php";
include "header.php";

if (! Session("ADMIN")) 
	accertaAdministratorAltrimentiBona();
else 
	scrivib(rosso("Benvenuto, Administrator...<br>"));

#if ($DEBUG ) log2("[DEBUG] Qualcuno si e intrufolato nei tuoi logs.. testing logs :)");

?>
<h1>Latest logs</h1>
    <pre>ciao
        <?= select_all_dblogs_sql(); ?>
    </pre>

    <? visualizza_tabella_ultimi_logs() ?>
