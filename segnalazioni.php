<?php 


include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

?>
	<h1>Hai qualche segnalazione da fare?!?</h1>

<h2>
	<a href=' https://distillery.fogbugz.com/default.asp?pg=pgPublicEdit'>
	Segnala qualunque problema qui
</h2>

<img src='immagini/segnalazioni-fogbugz.png' >
	</a>

E' un sistema anonimo per segnalare bachi che verr&agrave; gestita con calma dalla squadra di  amministratori e sviluppatori (???) del sito.


<?php 
function form_inutile_segnala_bachi() {
	formbegin();
	formtext('Nome Utente','');
	echo '<BR/>';
	formtext('Tua email (obbligatoria)','');
	echo '<BR/>';
	$arrProblemi = array('Baco sito', "Problema con l'email", "Altro");
	popolaComboArrayConDefault('idcommento_todo',$arrProblemi,$arrProblemi, 2);
	echo '<BR/>';
	formtextarea('Commento','');
	echo '<BR/>';
	formtext('Quanto fa 23 * 3? (Gabula anti-bot)','');
	echo '<BR/>';
	formbottoneinvia('manda dati');
	formend();


}

include "footer.php";
?>
