<?php  

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php"; // er al quarto posto


// rilascio il vincolo della datadinascita!!!
// e sicuramente non ripeto la merda di provare le due date: 3-1-76 e 1-3-76!!! ARGH!

$vincolodatanascita = FALSE;
$newdata = "FOO-FAITERZ";


if ((Form("OPERAZIONE")) == "SPEDISCI_MAIL") // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	{
	scrivi("operazione speditura mail...<br>");
	if (Form("numeromagico") != '69') {
		scrivi("Mi spiace, hai sbagliato il numero magico (mi hai dato " . Form("numeromagico") . "), non ti mando nessuna email");
		bona();
	}
	
	if ($vincolodatanascita) {
	 $newdata= getAutoDataByForm("nuovadatanascita");
	}

	$sql="select m_spwd,m_snome,m_hemail,datanascita from loginz where m_snome='"
		.Form("nomeutente")."'";
	if ($vincolodatanascita)
		$sql .= " AND datanascita='$newdata'";
	if ($ISPAL) scrivi("query: $sql<br>data: '<b>$newdata</b>'");
	invio();
	$res=mq($sql);
	$rs=mysql_fetch_array($res);
	log2("[mandamail][debug] stop per mandare un email a ". Form("nomeutente") );
	scrivi("sto inviando la mail al tuo indirizzo... (questo lo dico anche se non ci hai preso)<br/>");
	$ciucciook=(! empty($rs));
	if ($ISPAL)
		scrivi("<br>x pal: ciuccio ok?!??!? <b>$ciucciook</b>");
	$from= "\"php-mnemo-Webmaster di www.goliardia.it\" <$WEBMASTERMAIL>";
	$body= "Un msg per te... :(";

	if ($ciucciook) {// scrivid("CIUCCIO OK! ;)");
		echo("klatu, verata nikto...<br>");
		$body= "La password da te richiesta è: '<i><b>".$rs["m_spwd"]."</b></i>', caro/a <b>".$rs["m_snome"]."</b>."
			." Se fai così fatica a ricordartela, puoi cambiarla nella sezione UTENTE.";
		mandaMail($rs["m_hemail"],$from,"OK! La password smarrita di ".$rs["m_snome"],$body);
		mandaMail($WEBMASTERMAIL ,$from,"JFYI: la password di ".$rs["m_snome"],$body);	
		log2("[mandamail][notice] Mandata mail a Webmaster e a ". Form("nomeutente") );
		}
	else
	{	//scrivid("NESSUNA MAIL, hai cannato");
		scrivi("klatu, verata nikh..<br>");
		$nomedato=Form("nomeutente");
		$msgmsg =  "HUHU id utente: <b>".Session("SESS_id_utente")."\n</b><br>"
			. "nome utente: <b>$nomedato<b>\n<br>"
			. "IP: <b>".$_SERVER["REMOTE_ADDR"]."</b>\n<br>"
			. "sql: $sql\n<br>"
			. "vuota: ".intval(empty($rs))."\n<br>"
			. "segue body:\n<br><br>";
		mandaMail($WEBMASTERMAIL ,$from,"ERRORE pwd x $nomedato",$msgmsg);	
		log2("[mandamail][notice] NON Mandata mail a ". Form("nomeutente") );
	}
	}
else
{
if ($vincolodatanascita)
	scrivib(rosso("<center>Attenzione, la tua data di nascita devi averla inserita: se il tuo account è VECCHIO è possibile che sia messo al valore di default, ovvero Primo di Gennaio 1970. Prova anche quello se il primo non va, ok?!?\b<br>"));

scrivi("sei proprio un picio! altresi' pirla, mona, scemo, imbelle... et ci'!<br>detto questo... compila la forma seguente:");
openTable2();
formBegin($AUTOPAGINA);
	formhidden("OPERAZIONE","SPEDISCI_MAIL");
	tabled();
	trtd();
	formtexttdtd("nomeutente","");
	tttt();
//	formtexttdtd("messaggio","sei un picio");
	formtexttdtd("numeromagico","quanto fa 23*3?!?");
//	tttt();
	if ($vincolodatanascita)
	{
	scrivi("data di nascita:");
	tdtd();
	popolaComboGGMMYYcondata("nuovadatanascita",1,1,1970);
	}
	trtdEnd();
	tableEnd();
	formbottoneinvia("spediscimela alla mia mail che tu sai");
	scrivi(rosso("<br/>E ricorda che se metti l'utente PIPPO verra' spedito all'email con cui PIPPO si iscrisse la prima volta. Per privacy non te la posso dire (la tentazione giuro è forte, ma non posso se no chiunque potrebbe sapere la mail di chiunque!)... Se hai problemi scrivi al Webmaster dicendo UTENTE e MAIL a cui vorresti che fosse mandato!"));
formEnd();
closeTable2();
scrivi(h1("ric qnd puoi cntrl anche che il nome non sia vuoto, ricordi quante mail con nome vuoto?!?"));
}
include "footer.php";
?>
