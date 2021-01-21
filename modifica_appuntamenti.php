<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$UTENTESEGNALANTE="nusacciu";

function validCellulare($str) {return (!empty($str));}

/* scrive i dati in modo riservato... e + fico */ 

$ID=(QueryString("id"));

function popolaComboGoliardiMieiConNull($ID,$stringaOpzioni,$iddflt="") {
global $GETUTENTE ;
$ut=$GETUTENTE ;

$idGolDflt= ($iddflt=="" ? 0 : $iddflt );

$sql = "select distinct g.id_gol,g.Nomegoliardico,o.nome_veloce from goliardi g,ordini o,loginz l,ulteriori_gestioni_goliardiche u"
	." WHERE o.id_ord=g.id_ordine "
	." AND l.m_sNome='".$ut."' AND (l.id_login=g.id_login "
	." OR ( l.id_login = u.id_login "
	." AND u.id_gol=g.id_gol ))"
	 ." ORDER BY g.Nomegoliardico";
if ($stringaOpzioni != "gestiscenull") // no opzioni
	popolaComboBySqlDoppia_Key_Valore($ID,$sql,$idGolDflt);
else
{	// copio il codice di popolacombokeydoppia e lo adatto al goliarda NESSUNO.
 $LABEL = $ID;
 $sql3=$sql;
 $DFLT_SELECTED = 0;
 scrivi("\n<select name='".$LABEL."'>\n");
 echo "<option selected value='0'>NESSUNO</option>";
 $recSetResult3 = mysql_query($sql3);
 $i=0;
 while ($recSet3=mysql_fetch_array($recSetResult3))
	{
	scrivi(" <option ");
	if ($recSet3[0] == $idGolDflt )
		echo " SELECTED ";
	scrivi(" value=\"".$recSet3[0]."\">".$recSet3[1]);
	if (mysql_num_fields($recSetResult3)>2) // almeno 3 campi
		echo" (".$recSet3[2].")"; // se va, bene, se no amen!
	echo("</option>\n");
	}
scrivi("</select>\n");
}
}



function popolaComboGoliardiUtenti($ID,$stringaOpzioni,$iddflt="")
{
global $GETUTENTE,$DEBUG;
//	$sql = "select g.id_gol,g.Nomegoliardico,o.nome_veloce from goliardi g,ordini o WHERE o.id_ord=g.id_ordine "
//	     . " AND g.id_gol in (select id_goliarda_default FROM loginz) ORDER BY g.Nomegoliardico";

	// poichè mysql 3.2.3 non supporta le nested query, la riscrivo non innestata, secondo i consigli scemi del
	// sito di mysql : http://www.mysql.com/doc/en/Rewriting_subqueries.html

 $sql = "select g.id_gol,g.Nomegoliardico,o.nome_veloce from goliardi g,ordini o,loginz l "
	." WHERE o.id_ord=g.id_ordine AND g.id_gol =l.id_goliarda_default ORDER BY g.Nomegoliardico";

$idGolDflt= ($iddflt=="" ? 0 : $iddflt );

if (isdevelop())
	echo rosso("ric, errore: qua davanti passo un utente di dflt ma mi sa che dovrei passare un "
		."goliarda (o il suo id?) di dflt: c'è u'incoerenza, guardaci meglio fuori dal treno....");

if ($stringaOpzioni != "gestiscenull") // no opzioni
  popolaComboBySqlDoppia_Key_Valore($ID,$sql,$idGolDflt);
else
{	// copio il codice di popolacombokeydoppia e lo adatto al goliarda NESSUNO.
 $LABEL = $ID;
 $sql3=$sql;
 $DFLT_SELECTED = 0;
 scrivi("\n<select name='".$LABEL."'>\n");
	// qwerty ric 19.15 30/01/2004: qua c'era un selected quassotto, tolto x realizzare la defaultation!...
 echo "<option value=\"0\">NIUNO</option>";
 $recSetResult3 = mysql_query($sql3);
 $i=0;
 if (isdevelop()) 
	echo rosso("Attenzione,sta funz va ottimizzata (a meno che..): fa tante chiamate a mysql_num_fields...");
 while ($recSet3=mysql_fetch_array($recSetResult3))
	{
	scrivi(" <option ");
	if ($recSet3[0] == $idGolDflt )
		echo " SELECTED ";
	scrivi(" VALUE=\"".$recSet3[0]."\">".$recSet3[1]);
	if (mysql_num_fields($recSetResult3)>2) // almeno 3 campi
		echo" (".$recSet3[2].")"; // se va, bene, se no amen!
	scrivi("</option>\n");
	}
scrivi("</select>\n");
}
}



function visualizzaPresenze($res)
{
 global $GETUTENTE ,$ISPAL,$AUTOPAGINA,$UTENTESEGNALANTE;
 $MIN=0;
 $AVG=0;
 $MAX=0;

?>
<table border="0" cellpadding="3">
<tr bgcolor="#FFEEEE">
<u>
 <td>canc</td>
 <td>Prov.</td>
 <td>foto</td>
 <td>commento</td>
 <td>prob</td>
 <td>quanti</td>
</u>
</tr>
<?php 

 
 while ($rs=mysql_fetch_array($res))
	{
	 ?>
	   <tr bgcolor="#EEFFEE">
	   <td>
	 <?php 
	 //echo rosso("L'0utente segnalante è: $UTENTESEGNALANTE,mtente io sono $GETUTENTE..");
	 if ($rs["m_snome"] == $GETUTENTE || $ISPAL || $UTENTESEGNALANTE==$GETUTENTE)
	 {



	 formBegin($AUTOPAGINA."?id=".$rs["id_appuntamento"]); 
	// no! deve solo cancellare, va a pagina FARLOCCA; POI e dico POI ririge di nuovo qua a id=XXX
	// e invece si', così con il GET(ID) sa come tornare indietro...
 	// formBegin();
	 formhidden("hidden_operazione","cancella_presenza");
	 formhidden("id_presenza",$rs["id_presenza"]);
	 formbottoneinvia("canc");
	 formEnd();
	}
	  $totale=intval($rs["m_nquantitotale"]);
	  $prob=  intval($rs["probabilita"]);
	 if ($prob > 0)
	 {
	 if ($prob == 100) 
		$MIN += $totale; 
	 $MAX += $totale;
	 $AVG += $prob*$totale;
	 }

	 tdtd();
		scrivi($rs["provincia"]);
	 tdtd();
	  scrivi(getFotoUtenteDimensionataRight($rs["m_snome"],30)	);
	 tdtd();
	  scrivi("<b>".$rs["commento"]."</b> <i>(".$rs["m_snome"].")</i>");
	 tdtd();
	 	 scrivi($prob."%");
	 tdtd();
		  scrivib($totale);
	 trtdEnd();
	}
 tableEnd();
	// conclusione:
	scrivi("Presenze: (min/avg/max): ");
	scrivib("(".$MIN."/".($AVG/100)."/".$MAX.")");
	invio();
	scrivi("<b>Legenda</b><br/><u>Min</u>: numero di persone al 100%;<br><u>Avg</u> (average): media pesata con la probabilità; <br><u>Max</u>: persone almeno al 5%");
	scrivi("\n<br/>La legge empirica carlessiana (ispirata alla Bistromatica della guida galattica) dice che il numero di persone che verrà sarà esattamente l'80% della media FRATTO il fattore d'informazione (se tutti quelli che possono venire alla cena vengono sul sito, dividete x uno, se il 10% dividete per 0.1, e così via. Prendete il numero senza virgola (chiamiamolo A), prendete la prima e la seconda cifra decimale (chiamiamolo B), la terza e la quarta (chiamiamolo C) e giocate al lotto. La probabilità di vittoria sarà ben maggiore di quella che io ci abbia preso.");
}




if ((Form("hidden_operazione")) == "DaiAdesione")
	{
		// devo solo cancellare un msg...
	$ok=autoInserisciTabella("eventipresenze","Ciuccio ok. Perchè tornare indietro quando puio vedere da te i cambiamenti scorrendo giù?!?");
	if ($ok)
		scrivi("Sei stato aggiunto, caro amico...");
	else
		scrivi("Problemi werywi con l'aggiunta, caro amico...");
//	scrivib("osserva i <a href='".$AUTOPAGINA."?id=".Form("id_appuntamento")."'>cambiamenti</a>.");	
//	ridirigi($AUTOPAGINA."?id=".Form("id_appuntamento"));
//	bona();
	}



if ((Form("hidden_operazione")) == "cancella_presenza")
	{
		// devo solo cancellare un msg...
	$ok=mysql_query("delete from eventipresenze where id_presenza=".Form("id_presenza"))
		or die("non son riuscito a cancellare la presenza. Mah, strano!!! Magari hai cliccato due volte, sobenmè!");
	scrivib(rosso("La tua presenza è stata tolta correttamente, direi! Ma chi sono!?!?"));
	invio();
//	scrivib("osserva i <a href='".$AUTOPAGINA."?id=".QueryString("id")."'>cambiamenti</a>.");	
//	ridirigerai($AUTOPAGINA."?id=".QueryString("id"));
	}





function scriviReport_AppuntamentoFancy($rs)
{
 global $ID,$ISGUEST,$UTENTESEGNALANTE,$AUTOPAGINA,$GETUTENTE;

//	echo "qwerty ric rs[\"id_login\"] vale ".$rs["id_login"];

 	$RSRVD=rosso("<i>riservato</i>");
 	FANCYBEGIN($rs["Nome"]); // dà eccezione se il RS è vuoto (i.e. l'id 1285 è fasullo)
	scrivi("<table  border='0' width='300'><center>\n");
	$rsPresenze=mysql_query("select sum(m_nquantitotale) AS TOTALE from eventipresenze where id_appuntamento=".$ID);
	scrivi(getCoppiaTabella("Presenze:","<b>".$rsPresenze["TOTALE"]."</b>"));
	scrivi(getCoppiaTabella("Tipo:",$rs["tipodiappuntamento"]));
	if (empty($rs["data_fine"]))
		scrivi(getCoppiaTabella("Data:",tohumandate(phpdata($rs["data_inizio"]))));
	else 
		scrivi(getCoppiaTabella("Data:",tohumandate(phpdata($rs["data_inizio"]))." <i>(fino al "
			.toHumanDate(phpdata($rs["data_fine"])).")</i>"));


	scrivi(getCoppiaTabella("Cittadina:",$rs["città"]));
	scrivi(getCoppiaTabella("Loco:",stripslashes($rs["luogo"])));

	$abdic=String($rs["Abdicabilita"]);
	if (empty($abdic)) 
		$abdic="<i>boh</i>";
	else
		$abdic .= " %";
	scrivi(getCoppiaTabella("Probabilità di abdicazione:",$abdic));

		// login  NUM->NOME
	$sqlOrdine="select m_snome  from loginz where id_login=".$rs["id_login"];
	$rsOrd=query1($sqlOrdine);
	$UTENTESEGNALANTE=$rsOrd["m_snome"];

	$frasedx= "<b><a href='utente.php?nomeutente=".$rsOrd["m_snome"]."'>".$rsOrd["m_snome"]."</a></b>"
		."(in data ".toHumanDate(phpdata($rs["data_invio"])).")";

	if ($rsOrd["m_snome"]==$GETUTENTE || isadminvip())
		 $frasedx .= "<BR>solo xchè sei tu....<br><a href='$AUTOPAGINA?modificaid="
				.$rs["ID_appuntamento"]."'><b>modifica evento</b></a>";

//	$frasedx .= getFotoUtenteDimensionataRight($rsOrd["m_snome"],60);	
	echo getCoppiaTabella("Utente segnalante:",$frasedx);
	scrivi(getCoppiaTabella("Note:",nl2br(stripslashes($rs["note"]))));
   scrivi("</tr></center></table>");
   FANCYMIDDLE("recapiti");
	scrivi("<table  border='0' ><center>\n");
		// recapiti
	$sql="SELECT * from goliardi WHERE id_gol=".$rs["recapitogoliarda1"].
		" OR id_gol=".$rs["recapitogoliarda2"]." OR id_gol=".$rs["recapitogoliarda3"];
	$gol3vuoto=FALSE;
	$rsRecRes=mysql_query($sql)
		or $gol3vuoto=TRUE; //die("non ci son goliardi qui---");
	$strRecapiti="";
	$TEL=getImg("telefono.jpg");
	$MAIL=getImg("email.jpg");

	if ($gol3vuoto) // o righe? bah speriamo!
		{$strRecapiti="<i>nessuno</i>";}
	else
	{$strRecapiti = "<table border='0' width='300' cellpadding='3' valign='center' align='center'>";

	while ($rsRec=mysql_fetch_array($rsRecRes))
	{$strRecapiti .= "<tr  ><td >"; 
#	 $strRecapiti .= getFotoUtenteDimensionataRight($rsRec["foto"],70,TRUE);
	 $strRecapiti .="<a href='pag_goliarda.php?idgol=".$rsRec["ID_GOL"]
			  ."'><b>".$rsRec["Nomegoliardico"]."</b></a><br><br>";
	if ($rsRec["privacy_cell"])
	 	$strRecapiti .= $TEL." <i>privato</i><br>";
	else
		if (validCellulare($rsRec["numcellulare"]))
#		 if (! empty($rsRec["numcellulare"]))
	 		$strRecapiti .= $TEL. $rsRec["numcellulare"]."<br>";

	if (($rsRec["privacy_mail"]))
		 	$strRecapiti .= $MAIL." <i>privata</i><br>";
	else
		{$mail=($rsRec["email"]);
		 if (isvalidmail($mail))			 //contiene($mail,"@"))		
			$mail=$MAIL." <a href=mailto:".$mail.">".$mail."</a>";
		 if (! empty($mail));
		 	$strRecapiti .= "".$mail."<br>";
		}

	 $strRecapiti .= "</td><td><a href='pag_goliarda.php?idgol=".$rsRec["ID_GOL"]
		."'>".getImg("persone/".$rsRec["foto"],70)."</a>";
	$strRecapiti .="</td></tr>\n";
	 //	if (!rsRec.EOF) strRecapiti+="<hr width='".$80."%' size='2' align='center'>"
	}

	$strRecapiti .= "</table>";
	}


	if ("<i>nessuno</i>" != $strRecapiti)
		scrivi(getCoppiaTabella("Recapiti:",$strRecapiti));


   scrivi("</tr></center></table>");


  FANCYMIDDLE("Adesioni");

	scrivi("<table  border='0' ><center>\n");
	scrivi("<h3>Presenze finora</h3>");

	$rsp=mysql_query (
			 "select l.m_snome, id_appuntamento ,id_presenza,m_nquantitotale"
			.",commento,probabilita,l.provincia from eventipresenze e,loginz l where id_appuntamento="
			.$ID." AND l.id_login=e.id_utente ORDER BY l.provincia,l.m_snome"
				);

	visualizzaPresenze($rsp);
	

	
	// controllo se IO sono presente...
//	rs=query("select * from eventipresenze where id_appuntamento=".$ID." AND id_utente=".$getIdLogin());
//	if (! rs.EOF)
//	{scrivi("Vedo che tu sei iscritto qui. Vuoi disiscriverti? Se sì, clicca giù");
//	}


   scrivi("</tr></center></table>");


FANCYEND();

scrivi("<center> <table  border='0' width='200'><center>\n");
	
openTable2();

scrivi("<center><h2>Dai adesione</h2>");

if ($ISGUEST)
{scrivi(rosso("mi spiace, sei guest. Registrati!"));
}
else // USER
{
formBegin("$AUTOPAGINA?id=$ID");
formhidden("hidden_operazione","DaiAdesione");
formhidden("id_utente",getIdLogin());
formhidden("id_appuntamento",$ID);

formhidden("datacreazione",dammiDatamysql());
formtext("commento","I love Pal");
invio();
scrivi("probabilità: ");
 popolaComboNumerilliPercentuale("probabilita"); //,0,100,95) 
invio();
scrivi("Quanti siete in totale: ");
popolaComboNumerilli("m_nQuantiTotale",1,15,1,1);
invio();
formbottoneinvia("ok");
formEnd();
}
closeTable2();
scrivi("</tr></center></table>");
}


if ($ISANONIMO)
	{scrivi(rossone("cacchio vuoi?!? Pussa via!"));
	 bona();
	}

if ((Form("OPERAZIONE")) == "CANCELLA")
	{// devo solo cancellare un msg...
	echo "guardo prima se ci sono presenze all'evento, in tal caso non te lo fo cancellare...";
	$sql="select count(*) from eventipresenze where id_appuntamento=".Form("id_appuntamento");
	$res=mysql_query($sql);
	$row=mysql_fetch_row($res);


/*
			 "select l.m_snome, id_appuntamento ,id_presenza,m_nquantitotale"
			.",commento,probabilita,l.provincia from eventipresenze e,loginz l where id_appuntamento="
			.$ID." AND l.id_login=e.id_utente ORDER BY l.provincia,l.m_snome"
*/

	//echo rosso("sql[$sql]; quanti record: ".$row[0]);
	if ($row[0] == 0)
		{
		autoCancellaTabella("appuntamenti",Form("id_appuntamento"));
		scrivi("Appuntamento cancellato, mio caro amministratore...");
		ridirigiBack();
		}
		else 
		{spapla("Eh no caro! Ci sono persone iscritte al tuo evento; prima cancellale! O vorresti creare garbage?!? Maledetto appesantirore di DB!!!!!");
		 tornaindietro("Guarda mo' qua, schiocchino...".Form("id_appuntamento"),"modifica_appuntamenti.php?id=".Form("id_appuntamento"));
		}
	bona();
	}

$ID=String(QueryString("id"));

$operazione=(Form("hidden_operazione"));
if (!empty($operazione ))
	{ 
	 if ($operazione=="inserisciappuntamento")
		{
		 scrivi(rossone("gestisco salvataggio nuovo:<br>"));
		 autoInserisciTabella("appuntamenti");
		 tornaindietro("Guarda mo' il calendario aggiornato col tuo belizzimo evento nuovo","calendario.php");
		 bona();
		}
	 if ($operazione=="modificaappuntamento")
		{
		 scrivi(rossone("gestisco salvataggio dell'appuntamento da te poc'anzi modificato:<br>"));
		 $tornaindietro= "modifica_appuntamenti.php?id=".form("my_hidden_id");
		 autoAggiornaTabella("appuntamenti","id_appuntamento",$tornaindietro);
		 tornaindietro("Guarda mo' il calendario aggiornato col tuo belizzimo evento neomodificato",$tornaindietro);
		 bona();
		}
	}
//if ($ISPAL) {scrivi(rossone("prova ric"));}

if (empty($ID))
	{
$MODIF_ID= intval(querystring("modificaid"));
//echo "il valore di intval è:  $MODIF_ID...";
$azione = $MODIF_ID==0 ? "inserisci" : "modifica";
scrivi("<h1>$azione appuntamento</h1>");
if (isguest())
	{	
	 echo "... stocazzo!";
	 bona();
	}


$nome = "";
$citta= "argenta";
$note="";
$luogo="";
$recapitogoliarda1="";
$recapitogoliarda2="";
$recapitogoliarda3="";
$abdicabilita="";


if ($azione=="modifica")
	{
	$res=mq("select * from appuntamenti where id_appuntamento=$MODIF_ID");
	$rs=mysql_fetch_array($res);

	$nome=stripslashes($rs["Nome"]);
	$citta=$rs["città"];
	$abdicabilita=$rs["Abdicabilita"];
	$recapitogoliarda1 = $rs["recapitogoliarda1"];
	 //echo "rs['recapitogoliarda1']:".$rs["recapitogoliarda1"];
	$recapitogoliarda2 = $rs["recapitogoliarda2"];
	$recapitogoliarda3 = $rs["recapitogoliarda3"];
	$note=stripslashes($rs["note"]);
	$luogo=stripslashes($rs["luogo"]);
	$datainiz=($rs["data_inizio"]);
	$datafin=($rs["data_fine"]);
	}
	

	 formBegin();
	 scrivi("<center>\n");
	 formhidden("id_login",Session("SESS_id_utente"));	// anche in modifica cambio padrone, scelta stilistica
	 if (isdevelop())
		echo rosso("attento, nell'inserisci non c'era un formhidden (op=inserisci): devi farlo ora dato che il modifica va gestito in maniera diversa!!! metti hiden op= $operazione...");
	 formhidden("data_invio",dammiDatamysql(time()));	// cambio data modifica anche in modifica
	 scrivi("<br><b>NB</b>. '<i>nome</i>' sta x nome dell'evento, non per TUO nome!<br><b>NB2</b> Ricorda: quando avrai salvato st'evento, se non ti piacerà, potrai sempre cancellarlo: nella home gli eventi registrati da te hanno una X. Cliccaci e l'evento sarà rimosso. Ciò non funziona se vi sono iscritti, ma in tal caso hai ppotere di rimuoverli a tuo piacimento.<br>");
	 formtext("nome",$nome);
	scrivi(" tipo: ");
	popolaComboTipoAppuntamento("tipodiappuntamento");
	invio();
	scrivib("Attenzione! La data va scritta nel formato che vedete gia scritto, ovvero AAAA-MM-GG all'americana e non all'italiana. Se lo postate al contrario rischiate di postare un evento assurdo (tipo 10-5-05 non è il 10 maggio 05 ma il 5 maggio 2010!!!). Tranquilli, ore/minuti/secondi potete ometterli.<br/>");
	 formtext("data_inizio",dammiDatamysql(time()));
	 formtext("data_fine" ,dammiDatamysql(time()));
	 #formtext("data_inizio",($datainiz));
	 #formtext("data_fine" ,($datafin));
	hline(80);
	 scrivib("città: ");
	 popolaComboCitta("città",$citta);
	 scrivib("probabilità di abdicazzone: ");
	 popolaComboNumerilliPercentuale("abdicabilita",$abdicabilita);
	 scrivi(" (%uale)\n");
	invio();
	hline(80);
	 scrivii("goliardi da contattare per saperne di più:<br>Il primo è uno qualunque, <br> nel 2o vengon presi da utenti "
		."registrati e <br> nel 3o invece tra goliardi TUOI.<br> Sapendo che 3 volte tutti incasina la pagina, ditemi voi cosa preferite...<br>");
	 popolaComboGoliardi("recapitogoliarda1","gestiscenull",$recapitogoliarda1);
	 invio();
	 popolaComboGoliardiUtenti("recapitogoliarda2","gestiscenull",$recapitogoliarda2);
	 invio();
	 popolaComboGoliardiMieiConNull("recapitogoliarda3","gestiscenull",$recapitogoliarda3);
	 hline(80);
	 scrivib(big("Segue ora il luogo in cui si terrà l'evento."));
	 invio();
	 formtextarea("luogo",$luogo,10,30);
	 invio();
	 hline(50);
 	 scrivib(big("Qualunque informazione supplementare va qui.<br>"));	
	 formtextarea("note",$note,10,30);
	 invio();
	 formbottoneinvia("salvalo");
	 formhidden("hidden_operazione",$azione."appuntamento"); // o "modificaappuntamento" o "inserisciappuntamento"
	 if ($azione=="modifica")
		formhidden("my_hidden_id",$MODIF_ID);
	 formEnd();	
	 bona();
	}



// ho l'id giusto, lo visualizzo alla vecchia

$res=mysql_query("SELECT * FROM appuntamenti where id_appuntamento=".$ID);
$rs = mysql_fetch_array($res);
tornaindietro("Se vuoi vedere tutt gli eventi clicca qui","calendario.php");
scriviReport_AppuntamentoFancy($rs);

include "footer.php";
?>
