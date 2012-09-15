<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

//visuaLIZZAformz();
echo "proviamo dai...";
autoAggiornaTabella("loginz","id_login","pag_utente.php") 	;

?>
	<big><a href="pag_utente.php>Torna alla pagina utente</a></big>
<?php 
include "footer.php";
?>
