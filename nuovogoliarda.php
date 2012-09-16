<?php 


include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


 $sql2 = "";
 $mioIdOrdine="";
$MIVOGLIOREGISTRARE =  Form("hidden_mivoglioregistrare")=="davvero"; // se vero
$IDLOGIN=45;

/////////////////////////////////////////////////////////////////////////////////////////////////////////
// qua gestisco la gente che ha premuto registra. chiamo una f di debug che stampa TUTTE le form che mi sono arrivate!

if ($MIVOGLIOREGISTRARE)
	{scrivi("ah, vorresti registrare i dati? vediamo...<br>");
	if ($ISPAL) visualizzaformz();
	if (Form("Nomegoliardico") && Form("Nome") && Form("Cognome"))
	{
		autoInserisciTabella("goliardi","Ciuccio benei con la querei..");
		tornaindietro("Ciuccio ok, torna mo' indietro a vedere la tua nuova creazione in un suo giusto contesto socio-culturale..","pag_utente.php");	
	}
	else tornaindietro("Mi spiace, vedo dati vuoti....");
	bona();
	}


$nickname = $GETUTENTE;

	 if ($ISANONIMO)
		{
		scrivi(rossone("Mi spiace, sei <i>anonimo</i> e x entrare in sta pagina devi essere loggato...<br>\nCambia utente!<br>"));
		bona();
		}



	$sqll="select id_login from loginz where m_sNome='".$nickname."'";

	$reslogin=mysql_query($sqll) // cerco il mio ID_LOGIN
		or sqlerror($sql1);

	$rslogin= "";

	if (mysql_num_rows($reslogin)==0)
		scrivi(rosso("COSO VUOTO"));
	
	$rslogin=mysql_fetch_array($reslogin);

	$IDLOGIN=$rslogin["id_login"];

	scrivi("<center><h1>Pagina di inserimento di <u>".$nickname."</u>") ;
	scrivi("</h1></center>\n");


		//////////////////////////////////////////
		// qua devo verificare che il nome passatomi via POST non sia già presente... è solo un consiglio...
		// cerco la form "di nome goliardico"

	$NOME_SUGGERITO = Form("dinomegoliardico");


	//visualizzaformz();
	if ($ISPAL) echo rosso("aggiungi la possibilità di aggiungere u goliarda pure qui...");

//	scrivi(rossone("di nome goliardico vale... ".$NOME_SUGGERITO));

	if ($NOME_SUGGERITO == "NOME (obbligatorio)" || $NOME_SUGGERITO == "NOME BIS")
		{tornaindietro("Ma no, mona, devi mettere al posto del nome il nome del goliarda! Non lasciare il campo così com'è (cioè '<i>$NOME_SUGGERITO</i>')!!!","pag_utente.php"); bona();}

	if (strlen($NOME_SUGGERITO)<3 && ($NOME_SUGGERITO != "") )
		{tornaindietro("nome troppo corto (cioè '<i>$NOME_SUGGERITO</i>')!!!","pag_utente.php"); bona();}


	if (!empty($NOME_SUGGERITO))
		{			// faccio queery e verifico
		$SQL = "SELECT foto as _fotogoliarda,nomegoliardico,nomenobiliare,nome,cognome from goli".
				"ardi where nomegoliardico LIKE '%".$NOME_SUGGERITO."%'";
		$res=mysql_query($SQL)
			or sqlerror($SQL);
		$nonvuoto = (mysql_num_rows($res) >0) ;//($rs=mysql_fetch_row($res));
		if (! $nonvuoto)
			{scrivi(corsivoBluHtml("Ok, nessuno col nome '".$NOME_SUGGERITO."'"));}
		else
			{scrivi(rossone("Attento, ci sono persone che assomigliano a quel nome! Guarda!"));
			 scriviRecordSetcontimeout($res,7);
 			 scrivi(rossone("Ti consiglio di ri-immettere il nome qua x sicurezza..."));		
	scrivi("Vediamo se ho problemi a registrare un nuovo goliarda ");
	formbegin();
	formtext("dinomegoliardico","NOME BIS");
	formbottoneinvia("riprova!");
	formend(); 
			 scrivib("In pratica fa come vuoi però è stupido mettere 2 istanze di un"
				. "o stesso goliarda! Piuttosto modificalo! Se"
			 	. " il caro vecchio Palladius trova dei doppioni li cancella e "
				. "aumenta di uno l'e-scazzo all'ultimo che ne ha creato uno...  :-)<br>");
			}
		}
	
	scrivi("<table  border=3><center>\n<tr>\n  <td>");

// hline(100);


	////////////////////////////////
	// formona


formbegin();
scrivib("\n<center>\n<h2>Estremi anagrafici</h2>");
formhidden("my_hidden_id","nome");
formhidden("hidden_mivoglioregistrare","davvero");
formhidden("hidden_mia_query_string","klòklò"); //QueryString());
formhidden("id_login",$IDLOGIN); // non metto hidden anche se è nascosta così la ciuccio in automatico di sopra!!!

formtext("Nome","");
//spazio(2);
formtext("Cognome",(""));
hline(70);
scrivi("<table border=1>");

formtextConCheckbox("Indirizzo",(""),"privacy_address",("false"),"privato");
formtextConCheckbox("NumCellulare",(""),"privacy_cell",("false"),"privato");
formtextConCheckbox("Email",(""),"privacy_mail",("false"),"privato");

scrivi("</table>");

echo ("(se selezioni <i>sì</i> non saranno resi pubblici questi dati)<br>");
invio();
hline(70);
scrivib("<h2>Estremi goliardici</h2>");

echo "<center>";
tabled();
echo "<tr><td align=right>";

	if ($NOME_SUGGERITO != "undefined")
		formtext("Nomegoliardico",$NOME_SUGGERITO);
	else 
		formtext("Nomegoliardico","");
tdtd();
	formtext("Nomenobiliare","");
trtdend();

echo "<tr><td align=right>";

	$dataProcesso=("2003-12-31");
	formtext("Dataprocesso",($dataProcesso));
tdtd();
	scrivi ("Ordine: ");
	popolaComboBySqlDoppia_Key_Valore("ID_ORDINE","select id_ord,nome_veloce,città from "
		."ordini order by nome_veloce","61");
trtdend();

echo "<tr><td align=right>";
formtext("foto","$GETUTENTE.jpg"); 

tdtd();

scrivi (rosso("Fuck")."oltà: ");
popolaComboBySqlDoppia_Key_Valore("ID_FACOLTA","select * from facolta","giurisprudenza");


trtdend();
tableend();

scrivi("<i>P.S. Se non c'è il tuo ordine è un problema MIO; dato che non puoi creare un goliarda senza un ordine di nascita, intanto metti un ordine fittizio.<br>");
scrivi("Poi mi mandi una ".miamail("mail")." con la mia lacuna e più avanti ");
scrivi("cambierai solo questo!.. ok?</i>");
hline(70);


scrivi("<center>");
 formbottoneinvia("registra i cambiamenti");
scrivi("</center>");
formend();


// if (DEBUG_ON) 	{hline(100);scrivib("sql2: ".$sql2."<br>ORDINE MIO: '".$mioIdOrdine."'<br>"); }

?>
</center>


<?php 
include "footer.php";

?>
