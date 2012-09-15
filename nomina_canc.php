<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

visualizzaformz();

if (strtolower(Form("hidden_operazione")) == "cancella_una_nomina42")
{
 scrivib(rosso("sto x eliminare la nomina che mi hai chiesto...<br>"));
 autoCancellaTabella("nomine","id_nomina");
 scrivi(rosso("Osserva i cambiamenti nel <a href='pag_goliarda.php?idgol="
	.Form("hidden_idgol")."'>goliarda</a>.<br><br>"));
 scrivi(rosso("Osserva i cambiamenti nell'<a href='pag_goliarda.php?idord="
	.Form("hidden_idord")."'>Ordine</a>."));
}


include "footer.php";

?>
