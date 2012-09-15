<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

$MSGVUOTO 		  	= TRUE;
$COLORE_INSERISCI_MSG 	= "bgcolor='#FFFFDD'";
$COLORE_RISPONDI_MSG 	= "bgcolor='#FFDDDD'";



if ((Form("OPERAZIONE")) == "CANCELLA")
	{
		// devo solo cancellare un msg...
	$res=mysql_query("select count(*) from messaggi where id_figliodi_msg=".Form("ID_MSG"));
	$rs=mysql_fetch_row($res);
	if ($rs[0]==0)
	{	scrivi("Ok, il messaggio è SCAPOLO, lo canziello.");
		autoCancellaTabella("messaggi","ID_MSG","pag_tutti_messaggi.php");
	scrivi("Messaggio cancellato, mio caro amministratore...");
	ridirigi("pag_tutti_messaggi.php");
	} else
	{	scrivi("mi spiace, ma il msg ha ".$rs[0]." figli, non lo ucciderò!!! A meno che tu non voglia uccidere i suooi figli...");

	formBegin("pag_messaggi.php");
	formhidden("my_hidden_id",Form("ID_MSG"));
	formhidden("id_figliodi_msg",Form("ID_MSG"));
	formhidden("OPERAZIONE","CANCELLA_FIGLI");
	formbottoneinvia("uccidi figli di ".Form("ID_MSG"));
	formEnd();

	}
	bona();
	}
if ((Form("OPERAZIONE")) == "CANCELLA_LOGIN") // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	{
		// devo solo cancellare un login...
	autoCancellaTabella("loginz",Form("id_login"));
	scrivi("utente num. ".Form("id_login")." cancellato, mio caro amministratore...");

	bona();

	}

if ((Form("OPERAZIONE")) == "CANCELLA_FIGLI") // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	{
		// devo solo cancellare un login...
	// 21-8-03 errore
	// autoCancellaTabella("messaggi",Form("id_figliodi_msg"));
	autoCancellaTabella("messaggi","id_figliodi_msg","pag_tutti_messaggi.php");
	scrivi("messaggi figli di  ".Form("id_figliodi_msg")." cancellati, mio caro amministratore...");
	ridirigerai("pag_tutti_messaggi.php");
	bona();

	}

if ((Form("OPERAZIONE")) == "RENDIUSER") // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	{
		// devo solo cancellare un login...
	//autoAggiornaTabella("loginz","id_login");
	mysql_query("uPdAtE loginz SET m_bguest=0 WHERE id_login=".Form("id_login"))
	or die("errore a userizzare l'utente numero ".Form("id_login"));
	scrivi(rosso("userizzo l'utente numero ".Form("id_login").", mio caro amministratore..."));
	bona();
	}


$auto_msg = Form("hidden_auto_msg_via_form");

$trigger=($auto_msg !="");


if ($trigger) {
	scrivid(rosso("Provo a inviare il messaggio...".$auto_msg));
	if ($DEBUG)
		scrivib("AUTO_MSG=".$auto_msg);
	invio(); 
	if ((Form("titolo"))=="")
		errore2002("Titolo mancante, non inserisco niente (form vale ".Form("titolo")."!");
	else
	if ((Form("messaggio"))=="")
		errore2002(("Messaggio mancante, non inserisco niente (titolo vale '".Form("titolo")."' !)"));
	else {	  // l'utente POSTANTE è spoofabile
	      $strIdUtentePostante = strval(Form("id_login"));
		$strIdUtenteEffettivo= strval(Session("SESS_id_utente"));
		if ($DEBUG)
			scrivi(rossone("SPOOFING! ATTENTO! ($strIdUtenteEffettivo vs $strIdUtentePostante)"));

		if ($strIdUtentePostante != $strIdUtenteEffettivo)
			log2("HACK: messaggio dal titolo '".Form("titolo")."' postato da utente effettivo ".Session("nickname")
				." ($strIdUtenteEffettivo), spoofando il povero utente numero $strIdUtentePostante...");

		autoInserisci("messaggi","Messaggio buttato su con successo!","index.php");

		ridirigi("pag_tutti_messaggi.php");
	}
	bona();
	} else { 
	$str=strval(QueryString("ID_MSG")); 
	if ($str != "") {		
		$sql =  "SELECT * FROM messaggi m,loginz l"
		 	. " WHERE m.id_login = l.id_login"
	 	 	. " AND m.ID_MSG=".$str; 
		$res =  mysql_query($sql);	
		$rs = mysql_fetch_array($res);

		$n=intval($rs["id_figliodi_msg"]);
		if (! $n>0) 
				$n=0; // se è un NaN lo metto a 0 !!!
		$isProgenitore=($n==0); 
		$dummyvar=$rs["titolo"]; // cosi' dà eccezione qua e non alla prox f(x) a metà...
		FANCYBEGIN($rs["titolo"]);
		$MSGVUOTO=FALSE; // se scrive BEGIN, deve scrivere x forza l'END
		scriviReport_Messaggio($rs,TRUE,TRUE); 
		}
	}
$nuovoMsg=($str==""); // in tal caso, non esiste un msg letto, solo il nuovo da scrivere... s
if (! $nuovoMsg) { 
$sql="SELECT * FROM messaggi"; 
$sqlRES=mysql_query("select * from messaggi  m,loginz l WHERE m.id_login = l.id_login AND id_figliodi_msg=".$str); 
#scrivi("<table>");
$i=0; 
while ($sqlRE=mysql_fetch_array($sqlRES)) {
	$i++;
  	#scrivi("<tr><td>");
	 FANCYMIDDLE();
   	scriviReport_Messaggio($sqlRE,TRUE,TRUE); // condizione di stampaggio lungo
	#scrivi("</td></tr>");
	}
#tableEnd();
}

if (! $MSGVUOTO )
		FANCYEND();

	///////////////////////////////// 
	// form di modifica

scrivi("<center><table><tr><td>");

if (anonimo())
	{scrivi(rossone("Ma che vuoi fare, anonimo di sti cazzi? Me ne esco...</table>"));
	 bona();
	}

if (! $nuovoMsg && !$isProgenitore)
 scrivid(rossone("non progenitore: n vale ".$n));

if (! $nuovoMsg && ! isGuest())
{
scrivi(("<center><h3>Rispondi a questo messaggio!</h3>"));

scrivi("<table border=1 ".$COLORE_RISPONDI_MSG.">");

formBegin($AUTOPAGINA);
trtd();
scrivi("<center>");

scrivi("<table >");
formtextConCheckbox("titolo","","pubblico","true","pubblico");
scrivi("</table>");

if ($isProgenitore)
	formhidden("id_figliodi_msg",$str);
else // devo rispondere non a lui ma al padre!!!
	formhidden("id_figliodi_msg",$n);
formtextarea("messaggio","",10,50);

formhidden("data_creazione",dammiDataByJavaDate(time()));
formhidden("id_tipo",0);

$sql="select id_login  from loginz where m_snome='".getUtente()."'";
$res=mysql_query($sql);
$rs=mysql_fetch_array($res);
$idutente=$rs["id_login"];
formhidden("id_login",$idutente);
formhidden("hidden_auto_msg_via_form","stato 1");
invio();
scrivi("<center>");
scrivi("<input type=submit value='invia messaggio'>");
scrivi("</center>");
scrivi("</form>");
scrivi("</center>");
scrivi("</td></tr>");
scrivi("</table>");
scrivid(rossone("num msg: ".$str));
scrivi("</td><td>");

}


if(! isGuest())
{
scrivi("<center><h3>Inserisci un nuovo messaggio!</h3>");
scrivi("<table border=1 $COLORE_INSERISCI_MSG>");
formBegin($AUTOPAGINA);
scrivi("<tr><td>");
scrivi("<center>");
scrivi("<table >");
formtextConCheckbox("titolo","","pubblico","true","pubblico");
scrivi("</table>");
formtextarea("messaggio","",10,50);
formhidden("data_creazione",dammiDataByJavaDate(time()));
formhidden("hidden_tornaindietroapagina","pag_tutti_messaggi.php");
formhidden("id_tipo",0);
$sql="select id_login  from loginz where m_snome='".getUtente()."'";
$res=mysql_query($sql);
$rs=mysql_fetch_array($res);
$idutente=$rs["id_login"];
formhidden("id_login",$idutente);
formhidden("id_figliodi_msg",0);
formhidden("hidden_auto_msg_via_form","stato 1");
invio();
scrivi("<center>");
scrivi("<input type=submit value='invia messaggio'>");
scrivi("</center>");
scrivi("</form>");
scrivi("</center>");
scrivi("</td></tr>");
scrivi("</table>");
}



scrivi("</table>");

include "footer.php";

?>



