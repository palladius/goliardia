<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

//MA DE CHE? tabellona che contiene a sx gli ordini e a dx i goliardi 

$dataBirth="pippo";
$sniffaip = intval(QueryString("sniffaip")=="ok");

$HADIRITTOACANCELLARE = isAdminVip() && Querystring("pulsanticancellazione") != "";


if (QueryString("idutente") != "")
	formGiocoCoppiePersonale(TRUE,QueryString("idutente"));
else if (QueryString("nomeutente") != "")
	{
	$res=mq("select id_login from loginz where m_snome='".QueryString("nomeutente")."'");
	formGiocoCoppiePersonale(TRUE,mysql_result($res,0,0));
	}

	





function toDataSburaConMinuti($d)
{
global $weekkina,$mesini;
if ($d == -1)
	return "1-1-1970 <small><i>(cercate di cambiare sta data, se possibile. se no "
		."segnalate il BUG mandando un gms a @BUGS x favore dicendo a cosa è riferita)</i></small>";
$mese=$mesini[date("n",$d)-1]; // mese senza zeri
$giorno = $weekkina[date("w",$d)];
$format = date("\%\s\ j \%\s y, H:m",$d); // j è come d ma 1..31 non 01..31
return sprintf($format,$giorno,$mese);
}

function scriviCoppia01($titolo,$frase,$frase1,$frase2)
{
if ($frase=="")
        return "<b><i>?!?</i></b>";
if ($frase=="true" || $frase==1)
        $frase= $frase1; //"<img src='$IMMAGINI/".$img1."' height='".$altezza."'>";
else
if ($frase=="false"  || $frase==0)
        $frase= $frase2; //"<img src='$IMMAGINI/".$img2."' height='".$altezza."'>";
if ($titolo=="")
        scrivi("<b>".$frase."</b><br>");
else
        scrivi($titolo.": <b>".$frase."</b><br>");
}




function scriviCoppiaImgTrueFalse($titolo,$frase,$img1,$img2)
{$altezza=18;
 global $IMMAGINI;
if ($frase=="") 
	return "<b><i>?!?</i></b>";
if ($frase=="true" || $frase==1)
	$frase= "<img src='$IMMAGINI/".$img1."' height='".$altezza."'>";
else
if ($frase=="false"  || $frase==0)
	$frase= "<img src='$IMMAGINI/".$img2."' height='".$altezza."'>";
if ($titolo=="")
	scrivi("<b>".$frase."</b><br>");
else
	scrivi($titolo.": <b>".$frase."</b><br>");
}


		// report della pagina dell'utente...
function scriviReportUtente($idutent,$infoIP="")
{
global $ISPAL,$ISANONIMO,$HADIRITTOACANCELLARE,$sniffaip,$AUTOPAGINA,$GETUTENTE ;

openTable();
//echo "idutent VALE $idutent";
if (String($idutent) == "me")	
	$idutent = Session("SESS_id_utente");
$sql="select * from loginz where id_login=".$idutent;
$res = mysql_query($sql);
$rs = mysql_fetch_array($res);
$MYNOME  = $rs["m_sNome"];
$MYLOGIN = $idutent;
scrivi("<center><h2>Informazioni su <i class='utente'>".$MYNOME."</i>:</h2>");
if ($ISPAL)
{
if ($infoIP)
	{
	scrivi("<h2>sniffa ip:</h2>");
	trovaSimiliViaIp($MYNOME);
	}

}
tabled();
//trtd();
echo "<tr><td valign='top'>";

$nomecognome=$rs["m_thumbnail"];
scrivi(getFotoUtenteDimensionata($rs["m_sNome"],80));
tdtd();


scriviCoppia("Nome Utente","<b class='utente'>".$rs["m_sNome"]."</b>");
if (! $ISANONIMO)
	scriviCoppia("al secolo",$nomecognome,TRUE);
if (isAdmin()) {
        scriviCoppia(rosso("ID utente (solo Admin)"),$rs["ID_LOGIN"]." ");
	scriviCoppia(rosso("Livello goliardico (che ne pensate di st'idea?)"),$rs["m_nLivello"]);
	$str= "boh";
	switch($rs["m_nLivello"]) {
		case -1: 
			$str="ignoto"; break;
		case 0: 
			$str="filisteo"; break;
		case 1: 
			$str="cacchetta"; break;
		case 100: 
			$str="matricola"; break;
		case 200: 
			$str="popolano"; break;
		case 300: 
			$str="nobile"; break;
		case 400: 
			$str="capoordine"; break;
		case 500: 
			$str="capocitta"; break;
		}
	scriviCoppia(rosso("Livello goliardico (formato stringa)"),$str." <img height='30' src='immagini/livelli/liv-".$str."128x128.gif'>");
}
if ($ISPAL)
	scriviCoppia(rosso("NoteAdmin (solo pal)"),$rs["m_snoteadmin"]." <i>(edit tbds)</i>"); 
scriviCoppia(rosso("Mail pubblica (1=yes,0=no: cambiatevi sto valore se volete!)"),$rs["m_bmailpubblica"]); 
if ($rs["m_bmailpubblica"])
	scriviCoppia(("Email (poiché è consenziente)"),"<a href='mailto:".$rs["m_hEmail"]."'>".$rs["m_hEmail"]."</a>"); 
else // se no, la faccio vedere agli admin vip...
#if (isAdminVip())
if ($ISPAL)
	scriviCoppia(rosso("Email (solo Pal)"),"<a href='mailto:".$rs["m_hEmail"]."'>".$rs["m_hEmail"]."</a>"); 
		// solo x noi...
#if (! isguest()  )
//	scriviCoppia("Nato il",toDataSbura((phpdata($rs["datanascita"]))));    //     ." (<i>Ariete</i>)");
	scriviCoppia("Data di nascita",((($rs["datanascita"]))));    //     ." (<i>Ariete</i>)");
$dataBirth=$rs["datanascita"];
scriviCoppia("Data di iscrizione", toDataSbura(phpdata(($rs["m_dataIscrizione"]))));
//scriviCoppia("Last collegato",  toDataSburaConMinuti(phpdata($rs["m_dataLastCollegato"])));    //."(<i>Ariete</i>)");
$dataLastCollegato=$rs["m_dataLastCollegato"];
if (empty($dataLastCollegato))
	scriviCoppia("Last collegato",  rosso("MAI"));    
else
	scriviCoppia("Last collegato",  toDataSburaConMinuti(phpdata($rs["m_dataLastCollegato"])));    
scriviCoppia("Note",$rs["m_sNote"]);

if (! $ISANONIMO)
{	scriviCoppia("MSN",$rs["msn"]);
	scriviCoppia("Skype",$rs["icq"]);
}
scriviCoppia("Gusti sessuali",$rs["gustisessuali"]);
scriviCoppia("interessi",$rs["interessi"],TRUE);
#scriviCoppia("città",$rs["provincia"],TRUE);
scriviCoppia("città","<a href='citta.php?citta=".$rs["provincia"]
	."'>".$rs["provincia"]."</a> (new)",TRUE);
#http://www.goliardia.it/citta.php?citta=Macerata

scriviCoppia01("Sesso",				$rs["m_bIsMaschio"],"maschio","femmina");
scriviCoppia01("Account attivo",		$rs["m_bAttivo"],"attivo","in punizione");
scriviCoppia01("Account da ospite",		$rs["m_bGuest"],"ospite","sbur-user");
scriviCoppia01("Sei un goliarda?!?",		$rs["m_bIsGoliard"],"goliarda","filisteo");
scriviCoppia01("Serietà",				$rs["m_bSerio"],"serio","faceto");
scriviCoppia01("Single",				$rs["m_bSingle"],"single","accoppiato");
scriviCoppia01("Ha la erre moscia?!?",	$rs["m_bErreMoscia"],"erre moscia!!!","niep");
#scriviCoppiaImgTrueFalse("Sesso",				$rs["m_bIsMaschio"],"maschio.gif","femmina.gif");
#scriviCoppiaImgTrueFalse("Account attivo",		$rs["m_bAttivo"],"ok.gif","no.gif");
#scriviCoppiaImgTrueFalse("Account da ospite",		$rs["m_bGuest"],"userombrososembraguest.gif","user.gif");
#scriviCoppiaImgTrueFalse("Sei un goliarda?!?",		$rs["m_bIsGoliard"],"feluca100.gif","no.gif");
#scriviCoppiaImgTrueFalse("serio",				$rs["m_bSerio"],"serio.gif","faceto.gif");
#scriviCoppiaImgTrueFalse("Single",				$rs["m_bSingle"],"mini-single.gif","mini-accoppiato.gif");
#scriviCoppiaImgTrueFalse("Ha la erre moscia?!?",	$rs["m_bErreMoscia"],"erremoscia.gif","errenormale.gif");


scriviCoppia("goliard pointz®",$rs["m_nPX"]);

tdtdtop();
//echo "<div align='right'>";
if ($GETUTENTE !=$rs["m_sNome"]) // NON IO
	echo rosso("Manda <a href='gms.php?per=".$rs["m_sNome"]."'>GMS</a>");
//echo "</div>";


trtdEnd();
trtd();
trtdEnd();
trtd();

	scrivib("varie");
tdtd();
	$res=mysql_query("select count(*) from messaggi where id_login=".$MYLOGIN);
	if ($rs=mysql_fetch_row($res))
		scriviCoppia("Messaggi scritti",$rs[0]);

      $res2=mysql_query("select count(*) from goliardi where id_login=".$MYLOGIN);
	if ($rs2=mysql_fetch_row($res2))
		{
		scriviCoppia("goliardi posseduti",$rs2[0]);
		if ($HADIRITTOACANCELLARE ) 
			formquery("REGALA A PAL ".$rs2[0]." goliardi"
				,"UPDATE goliardi SET ID_LOGIN=3 where ID_LOGIN=".$MYLOGIN);		
		}
      $res2=mysql_query("select count(*) from nomine where id_utente_postante=".$MYLOGIN);
	if ($rs2=mysql_fetch_row($res2))
		{
		scriviCoppia("nomine immesse",$rs2[0]);
		if ($HADIRITTOACANCELLARE ) 
			formquery("REGALA A PAL ".$rs2[0]." nomine","UPDATE nomine SET id_utente_postante=3 where id_utente_postante=".$MYLOGIN);		
		}

      $res2=mysql_query("select count(*) from ulteriori_gestioni_goliardiche WHERE id_login=".$MYLOGIN);
	if ($rs2=mysql_fetch_row($res2))
		{
		scriviCoppia("Ulteriori Gestioni Gol.",$rs2[0]);
		if ($HADIRITTOACANCELLARE ) 
			formquery("CANC ".$rs2[0]." UGG",
				"delete  from ulteriori_gestioni_goliardiche WHERE id_login=".$MYLOGIN);
		}
	$res=mysql_query("select count(*) from canzoni where id_login=".$MYLOGIN);
	$rs=mysql_fetch_row($res);
	scriviCoppia("Canzoni scritte",$rs[0]);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." canzoni","delete  from canzoni where id_login=".$MYLOGIN);

	$rs=query1("select count(*) from linkz where id_login=".$MYLOGIN);
	scriviCoppia("linkz messi",$rs[0]);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." LINKz","delete  from linkz where id_login=".$MYLOGIN);


	$rs=query1("select count(*) from polls_voti where id_utente=".$MYLOGIN);
	scriviCoppia("voti dati nei sondaggi",$rs[0]);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." voti dati","delete  from polls_voti where id_utente=".$MYLOGIN);






	$rs=query1("select count(*) from polls_titoli where id_utente_creatore=".$MYLOGIN);
	scriviCoppia("Sondaggi creati",$rs[0]);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." sondaggi (non andrà mai)"
			,"delete  from polls_titoli where id_utente_creatore=".$MYLOGIN);

	$rs=query1("select count(*) from appuntamenti where id_login=".$MYLOGIN);
	scriviCoppia("eventi postati",$rs[0]);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." eventi","delete  from appuntamenti where id_login=".$MYLOGIN);


	$rs=query1("select count(*) from eventipresenze where id_utente=".$MYLOGIN);
	scriviCoppia("presenze ad eventi",$rs[0]);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." presenze","delete  from eventipresenze where id_utente=".$MYLOGIN);



trtdEnd();

trtd();
	scrivib("Ordini in gestione");
tdtd();

	$sqlGestori=mysql_query("select città from gestione_citta where id_login=".$MYLOGIN);
	scriviCoppia("Città",getRecordSetConVirgole($sqlGestori));
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$sqlGestori[0]." gest. città","delete  from gestione_citta  where id_login=".$MYLOGIN);


	invio();
	    $sqlGestori=mysql_query("select nome_veloce from gestione_ordini g,ordini o where o.id_ord=g.id_ordine AND id_login=".$MYLOGIN);
	scriviCoppia("Singoli",getRecordSetConVirgole($sqlGestori));
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$sqlGestori[0]." gest. ord.","delete  from gestione_ordini where id_login=".$MYLOGIN);

trtdEnd();
trtd();
	scrivib("Linkz correlati");
tdtd();
	$res=mysql_query("select * from linkz where tipo like 'UTENTI' AND id_oggettopuntato=".$MYLOGIN);
	while ($rs=mysql_fetch_array($res))
		scriviReport_LinkMini($rs);
trtdEnd();
trtd();



trtdEnd();
trtd();
	scrivib("Coppie");
tdtd();
	$rs=query1("select avg(m_nvoto)/10 from giococoppie where idutentevotato=".$MYLOGIN);
	scriviCoppia("voto medio avuto",approssima2($rs[0]),TRUE);
	$rs=query1("select avg(m_nvoto)/10 from giococoppie where idutentevotante=".$MYLOGIN);
	scriviCoppia("voto medio dato",approssima2($rs[0]),TRUE);
	$rs=query1("select count(*) from giococoppie where idutentevotante=".$MYLOGIN);
	scriviCoppia("votate",$rs[0],TRUE);
	$rs2=query1("select  count(*) from giococoppie where idutentevotato=".$MYLOGIN);
	scriviCoppia("Been voted from",$rs2[0],TRUE);

	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs[0]." VOTATE","delete  from giococoppie where idutentevotante=".$MYLOGIN);
	if ($HADIRITTOACANCELLARE ) 
		formquery("CANC ".$rs2[0]." VOTANTI","delete  from giococoppie where idutentevotato=".$MYLOGIN);

trtdEnd();
if ($ISPAL)
{ // inizio roba segreta
trtd();
	scrivib("SOLO PAL:");
tdtd();
	if ($sniffaip)
	{
	$rs=mysql_query("select nomehost,m_ncontaaccessi from indirizzi where m_tdescrizione='di "
		.$MYNOME."' order by m_ncontaaccessi desc");
	scriviCoppia("IP da cui si collega",getRecordSetConVirgoleParentesi($rs));
	}
	else scrivi("<a href='".$AUTOPAGINA."?nomeutente=".QueryString("nomeutente")."&sniffaip=ok'>sniffa ip</a>");

	
trtdEnd();
 // fine roba segreta
}
if (isadminvip())
	{trtd();
	 scrivib("SOLO ADMINVIP:");
	 tdtd();
	 scrivi("<a href='".$AUTOPAGINA."?nomeutente=".QueryString("nomeutente")
		."&pulsanticancellazione=19365693675'>Attiva Pulsanti x Eliminazione soggetto</a>");
	}

trtd();

trtdEnd();
tableEnd();


scriviReportGoliardaDefault($MYNOME,$MYLOGIN);
closeTable();
}





function trovaSimiliViaIp($nomeutente)
{
global $ISPAL;
if (! $ISPAL) return;
$res=mysql_query("select nomehost,m_ncontaaccessi from indirizzi where m_tdescrizione='di "
	.$nomeutente."' order by m_ncontaaccessi desc");
$nonvuoto = ($rs=mysql_fetch_array($res));
// ottengo: |  Ip1   | occorrenze1 |
//          |  Ip2   | occorrenze2 |
//          |  Ip3   | occorrenze3 |
// PS le occorrenze van sommate a 1: 0 sta x 1, 3 per 4 e cosi' via
//	scriviCoppia("IP da cui si collega",getRecordSetConVirgoleParentesi(rs));

$MAXCICLO = 12;


scrivi(".+++++++++++++++<br>");

$arr = array();
tabled();
for ($i=0;$i<$MAXCICLO;$i++)
 if ($rs=mysql_fetch_array($res))
{
trtd();
$ip = String(rs("nomehost"));
$ip1 = substr($ip,0,ip.indexOf('.'));
$ip3 = substr($ip,0,ip.lastIndexOf('.'));
$ip2 = substr($ip,0,ip3.lastIndexOf('.'));
// devo estrarre dall'ip il primo, il secodo e il terzo numero in dot notation (es 1.2.3.4)
formquery(ip1."*","select m_tdescrizione from indirizzi where iphost like '".ip1."%'");
formquery(ip2."*","select m_tdescrizione from indirizzi where iphost like '".ip2."%'");
tdtd();
formquery(ip3."*","select m_tdescrizione from indirizzi where iphost like '".ip3."%'");
formquery(ip,"select m_tdescrizione from indirizzi where iphost like '".ip."'");
tdtd();
scrivib($rs[0]." (".($rs[1]+1).")");
tdtd();

$resinner=mq("select m_tdescrizione,m_ncontaaccessi from indirizzi where nomehost='"
		.$rs[0]."' order by m_ncontaaccessi desc");

while ($rsinner=mysql_fetch_array($resinner))
	{
	 $cont=0;
	 $utente= String(sustr($rsinner[0],3));
	 $arr[$utente]=42;
	 scrivi("<a href='utente.php?nomeutente=".utente."'>".utente."</a> ".getFotoUtenteDimensionata(utente,30)
		." (".(rsinner(1)+1).") "); 
	}
trtdEnd();
}
tableEnd();

?>
metti una cosa che conti x ogni utente la somma (o la somma dei prodotti a mo di prodotto scalare) 
delle occorrenze in modo da
fare il match x utente. x farlo devi popolare un array x chiave, fallo se riesci, tipo: arr("palladius") += VAL....
<?php 
scrivi(".+++++++++++++++<br>");
}


$iddeassoc=String(QueryString("deassocia_id"));
if (! empty($iddeassoc))
	{
	$ok=mysql_query("update loginz set id_goliarda_default=0 where id_login=".$iddeassoc)
		or die("update a puttane");
	scrivi("deassociato l'utente numero ".$iddeassoc."...<br>");
	}


if (String(Form("operazione")) == "SPEDISCI_MAIL") // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	{
		// devo solo cancellare un login...
	$rs=query1("select m_spwd,m_snome from loginz where id_login=".Session("SESS_id_utente"));
	scrivi("sto inviando la mail al tuo indirizzo...");
	provaMail("La password da te richiesta è: '<i>".rs("m_spwd")."</i>', caro <b>".rs("m_snome")."</b>");
	bona();
	}


if (String(Form("operazione")) == "SPEDISCI_CHANGE_PWD")
	{
	$sql="select count(*) from loginz where M_SNOME='".getUtente()."' AND M_SPWD='".Form("vecchiapwd")."'";
	$rs=query1($sql);
	if ($ISPAL) echo "sql: $sql.<br>";
	if ($rs[0] != 1)		// (".$rs[0]." pwd matchano) 
		{tornaindietro("password vecchia non matchante, mi spiace...");}
	else
		{
		 scrivi(rossone("password vecchia OK (".$rs[0]."), modifico la pwd..."));
		 $rs=tentaquery("UPDATE loginz SET m_spwd='".Form("nuovapwd")."' where ID_login=".Session("SESS_id_utente")."");
		 tornaindietro("Password aggiornata al valore <u>bTy75uX3*9^1e</u>. Ah! Non ti avevo detto che non t"
			."e la faccio scegliere a te x motivi di sicurezza? Eddai che scherzo! :)");
		}	
	bona();
	}
if (String(Form("operazione")) == "CAMBIA_MAIL")
	{
	$sql="select count(*) from loginz where M_SNOME='".getUtente()."' AND M_HEMAIL='".Form("vecchiamail")."'";
	$rs=query1($sql);
	if ($ISPAL) echo "sql: $sql.<br>";
	if ($rs[0] != 1)		// (".$rs[0]." pwd matchano) 
		{tornaindietro("mail vecchia non matchante, mi spiace...");}
	else
		{$nuovamail=Form("nuovamail");
		 if ($ISPAL) echo rosso("pal: nuova mail: $nuovamail.<br>");
		 scrivi(rossone("mail vecchia OK (".$rs[0]."), verifico ora la mail nuova"));
		 $ok=isValidMail($nuovamail);
		 if (!$ok) // vediamos e esiste già...
			{
			 $res=mq("select count(*) from loginz where m_hemail like '$nuovamail'");
			 $rs=mysql_fetch_row($res);
			 $ok= (intval($rs[0]) == 0); // ve3rifico che la mail none sista già
			}
		 if (! $ok)
			{tornaindietro("mail nuova ($nuovamail) non corretta (o xchè è malformata "
					."o xchè è già in uso), mi spiace...");
			}
		 else
			{
			 $nuovapwd=creaPassword();
			 $sql="UPDATE loginz SET m_spwd='$nuovapwd', m_hemail='$nuovamail' WHERE ID_login="
					.Session("SESS_id_utente")."";
			 if ($ISPAL) echo rosso("pal: nuova pwd ($nuovapwd), la sql è: <b>$sql</b><br>");
			 $rs=tentaquery($sql)
				or die("qualcosa è andato storto nella query di modifica, uffi!");
		 	 tornaindietro("Password aggiornata, mail aggiornata. Novit' spedite via mail. "
				."Controlla la posta x sapere la mail.");
			 $body= "La password da te richiesta è: '<i><b>$nuovapwd</b></i>', caro/a <b>$GETUTENTE</b>."
				." Se fai così fatica a ricordartela, puoi cambiarla nella sezione UTENTE.";
			mandaMail($nuovamail,$WEBMASTERMAIL,"OK! La password modificata di $GETUTENTE",$body);
			}
		}	
	bona();
	}
if (String(Form("operazione")) == "CAMBIA_DATANASCITA")
	{$newdata= getAutoDataByFormmysql("nuovadatanascita");
	 scrivi(rossone("sto mettendo come tua data di nascita il valore <i>".$newdata."</i>"));
	 $rs=mysql_query("UPDATE loginz SET datanascita='".$newdata."' where ID_login=".Session("SESS_id_utente") );
	 tornaindietro("ecco fatto,caro mio",$AUTOPAGINA);
	 bona();
	}
if (String(Form("hidden_operazione")) == "CAMBIA_DATI")
	{
	autoAggiornaTabella("loginz","id_login") ;
	setSession("serio",Form("m_bSerio"));
	setSession("goliarda",Form("m_bIsGoliard"));
	setSession("single",Form("m_bSingle"));
	setSession("provincia",Form("provincia"));
	setSession("foto",Form("m_thumbnail"));
	setSession("nomecognome",Form("m_thumbnail"));
	
	if ($ISPAL)
		scrivi("serio vale ora: ".rosso(Session("serio")).", mentre single vale ".rosso(Session("single")).".");
	 bona();
	}





$datidichi = String(QueryString("idutente")); // a dflt su di me...
if ($datidichi == "") // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	$datidichi = "me";
$datidichixnome = String(QueryString("nomeutente")); // a dflt su di me...
if (empty($datidichixnome )) // ereditata dall'index, sono le X sugli ultimi 10 utenti...
	$datidichixnome = "me";
if ($datidichixnome != "me") // ho la chiamata x nome :(
{
$res=mysql_query("select id_login from loginz where m_snome='".$datidichixnome."'");
if ($rsnum = mysql_fetch_array($res))
	scriviReportUtente($rsnum[0],$sniffaip);
else
	{
	 scrivi("<h1>Utente '".$datidichixnome."' non trovato.");

	 if ($ISPAL)
		{
		openTable2();
		scrivi("<h2>sniffa ip LO STESSO:</h2>");
		closeTable2();
		}
	}

}
else // per numero

if ( $datidichi != "me")
{//openTable();
	scriviReportUtente($datidichi,1);

// closeTable();
 scrivi("<h1>e ora i TUOI dati...</h1>");
}
else // se non ho messo i dati di nessuno...
	scriviReportUtente("me");




//scriviReportGoliardaDefault();

if ($ISANONIMO) bona();

scrivi("<h2>De PassaParola Nascitae Dataque mutando ac bermudo</h2>");
tabled();
trtd();





/* UNCOMMENTA sta roba se vuoi il bottone 'spediscimi via mail la pwd'

formBegin($AUTOPAGINA);
	formhidden("operazione","SPEDISCI_MAIL");
	scrivi("se hai dimenticato la password, premendo questo bottone riceverai via mail la tua password. Attento, la mail a cui verrà mandata sarà esattamente la stessa che mi hai segnalato all'iscrizione. Speriamo sia giusta... :-)");
	invio();
	formbottoneinvia("spediscimela via mail");
formEnd();
*/

scrivi("<h3>Data di nascita</h3>");
formBegin();
	formhidden("operazione","CAMBIA_DATANASCITA");
	scrivi("se ti sei iscritto prima del 13-10-02, devi inserire la tua data di nascita (che ora a me risulta essere"
		."<b>$dataBirth</b>). Altrimenti, puoi comunque cambiarla. "
		."Attento che ti verrà chiesta questa data se e quando dimenticherai la password (forse!)."
		."<b>PS</b> <i>Nota che la data che segue non e' (probabilmente) la tua: era troppo difficile da settare"
		." e mi rugava farla bene, abbi pazienza. Quindi quissotto vedrai sempre lo stesso valore. Il valore corretto lo trovi piu' in alto sotto 'nato il'. In futuro forse...</i>");
	invio();
	popolaComboGGMMYY("nuovadatanascita");
	invio();
	formbottoneinvia("metti sta qua");
formEnd();

scrivi("<h3>Cambia Mail</h3>");
formBegin();
	formhidden("operazione","CAMBIA_MAIL");
	scrivi("Tu ti sei iscritto con mail MAIL. Se vuoi cambiarla, puoi. ma x essere sicuro che la mail che"
		."metti sia giusta, <b>ti cambierò di conseguenza la password</b> a caso. Niente paura:"

		."Sarà sufficiente uscire, e usare il form HO DIMETICATO LA PASSWORD e ti verrà spedita alla mail nuova."
		."Attento xtanto a scrivere bene la mail!!!");
	invio();
	 formtext("vecchiamail","vecchia mail");
	invio();
	 formtext("nuovamail","nuova mail");

	invio();
	formbottoneinvia("cambiala!");
formEnd();

tdtd();

scrivi("<h3>Cambia dati personali</h3>");


formBegin();
formhidden("hidden_operazione","CAMBIA_DATI");
	$res=mysql_query("select * from loginz where m_snome='".getUtente()."'");
	$rss=mysql_fetch_array($res);

	formhidden("my_hidden_id",$rss["ID_LOGIN"]);
	scrivii("(Qui metti o ICQ o Skype, come vuoi!)<br/>\n");
	formtext("Icq",$rss["icq"]);
	invio();
	scrivi("Nome Cognome: \n<input type='text' name='m_thumbnail'  value='".$rss["m_thumbnail"]."'>\n");
	//formtext("Nome Cognome",$rss["m_thumbnail"]); // NO xchè scritta è diversa da roba da CAMPO

	invio();
	scrivi("provincia: ");
	popolaComboCitta("provincia",$rss["provincia"]);
	invio();
	formtext("msn",$rss["msn"]);
	invio();
	formtextarea("interessi",$rss["interessi"],3,40);
	invio();
	formtextarea("gustisessuali",$rss["gustisessuali"],3,40);
	invio();

	formtextarea("m_sNote",$rss["m_sNote"],3,40);
	invio();
	formSceltaTrueFalse("m_bserio","Sei serio?",intval($rss["m_bSerio"]));
	invio();
	formSceltaTrueFalse("m_bisgoliard","Sei goliarda?",intval($rss["m_bIsGoliard"]));
	invio();
	formSceltaTrueFalse("m_bSingle","Sei single?",intval($rss["m_bSingle"]));
	invio();
	formSceltaTrueFalse("m_bmailpubblica","Vuoi che la tua mail sia resa pubblica agli utenti del sito?"
		,intval($rss["m_bmailpubblica"]));
	invio();
	formbottoneinvia("aggiorna dati");

formEnd();


tdtd();

scrivi("<h3>Cambia password</h3>");


formBegin();
	formhidden("operazione","SPEDISCI_CHANGE_PWD");
	scrivi("Se invece vuoi cambiuarla perchè non ti piace, basta inserire la vecchia (x conferma, se no un tuo compagno di laboratorio può farti la bastardata) e la nuova voluta. Attento, non ti do la doppia scelta come nei siti seri xchè evito un controllo in +, vuoi mettere? Quindi sii prudente.");
	invio();
	formtext("vecchiapwd","<vecchiapwd>");
	invio();
	formtext("nuovapwd","pippo");
	invio();
	formbottoneinvia("cambia pwd");
formEnd();

trtdEnd();
tableEnd();


include"footer.php";

?>



