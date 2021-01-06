<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

//$NEW = ! Session("antiprof");
//setSession("antiprof", $NEW); 

	 

function aggiornaSessioneByFormz()
	{global $ISPAL;
	 while (list($nome,$v) = each($_POST))
		{if (empty($v)) $v=0;
		 if ($ISPAL) 
			echo "chiamo la setSession(<b>$nome</b>,<b>$v</b>)...<br/>";
		 setSession($nome,$v); 
		}
	}


function aggiornaSessioneByForm($nome)
	{global $ISPAL;
	 if ($ISPAL) echo "setto la variabile $nome a '".Form($nome)."'...<br/>";
	 setSession($nome, Form($nome)); 
	}

if (Form("hidden_operazione")=="CAMBIA_CONFIG")
	{
	 aggiornaSessioneByFormz();
 	 scrivib(rosso("i tuoi dati son stati cambiati. Enjoy!!! PS se hai cambiato SKIN, aspetta di caricare un'altra pagina, qua non te ne accorgi..."));
	}





echo "<h1>Prova Configurazione</h1>";


opentable2();
	formBegin();
	formhidden("hidden_operazione","CAMBIA_CONFIG");
	formhidden("my_hidden_id","cazzo guardi stronzo di un hacker?!?");
	formSceltaTrueFalse("antiprof","Attivare l'antiprof?",Session("antiprof"));
	invio();
	formSceltaTrueFalse("conf_fancy","grafica 'FANCY'?",Session("conf_fancy"));
	invio();
	formSceltaTrueFalse("conf_immagini","immagini attive?",Session("conf_immagini"));
	invio();
	formSceltaTrueFalse("conf_balbuziente","balbetti?",Session("conf_balbuziente"));
	invio();
	if (isAdmin())
		{
		formSceltaTrueFalse("powermode","powermode attivo?",Session("powermode"));
		invio();
		}
	if (isdevelop())
		{
		formSceltaTrueFalse("conf_debug","DEBUG attivo?",Session("conf_debug"));
		invio();
		}
	if ($ISPAL)
		echo h1("manca la scelta skin xche' non va GBLOB() in remoto la bazza skin");
//	popolaComboFilePattern("skin","skin/","*",Session("skin"));
//	$arrSkin= getArrayDiFileFromDir("skin/");
	popolaComboFilePattern("skin","skin/","*",Session("skin"));
	//visualizzaarray($arrSkin);
	if (isdevelop())
			echo rosso("figata! poi replichi tutto con un altro paz che un giorno sar� la directory di upload!!!");
	invio();
	formbottoneinvia("vai!");
closetable2();



/*
scrivi("<bR>l'ANTIPROF ora vale: <b>$NEW (che vuol dire: ".rosso($NEW ? "attivo":"disattivo").")</b><bR><bR>");
scrivib("Questa pagina � per chi, come me, si collega dal alvoro e n"
	."on si pu� permettere che chi gira veda tette a dx e a manca. Og"
	."ni volta che caricate questa pagina alterate l'interruttore tra im"
	."magini ON e immagini OFF. Ok?!? Un bacione a tutti. Per gl'ingegner"
	."i: lo switch viene cambiato in mezzo a queste parole quindi questa �"
	." l'unica pagina in cui siete un po' antiprof e un po' no ;)");
*/
include "footer.php";

?>
