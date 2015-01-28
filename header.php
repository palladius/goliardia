<?php 
	# versione 1.1
	ob_start(); 
	session_start(); 
?><?php 
	// non e' ottimizzato, così tiene + pagine in memoria. conviene che chi usa la ridirigi includa un file tipo need_redirect.php
	// e nel file definisci SOLO la funzione e OBSTART, così se la usi in una pag x sbaglio dà errore, e da quel momento in poi SOLO
	// le pagine che dan redirect son bufferizzate, e le altre vivon meglio. ok? è un'idea?

$SVNID=" $Id: header.php 53 2009-09-27 07:31:02Z riccardo $ ";
$SVN_REV=" $Rev: 53 $ ";
$CONFSITO="sito06";
$ABILITAJS = 0;  // in tal caso, disabilito il menu VECCHIO e metto il nuovo SOTTO a flash!!!
$ANONIMO = "anonimo";
$IMMAGINI="immagini"; // che POI va tabbato...
$GODNAME = "palladius"; // se cambi questo nome, viene un atro superuser...
$MAX_GMS_AMMISSIBILI = 8;
$ISANONIMO = true;
$APERTOATUTTI = 0;
$indexAndAnonomo=0; //vale true se vogliamo rispettare Titanicus e far sì' che tutti possano vedere tutto senza login.
$TIME=time();
$VISUALIZZA_MSG_OCCASIONALE_NELLHEADER = FALSE;
$QGFDP="il corretto Palladius";
$VISUALIZZA_ORDINIPACCO=0;	# così li nascondo a TUTTI
$tInizioPagina=getmicrotime();

	$DEBUG_ON = 0;

$DEBUG=$DEBUG_ON || Session("conf_debug");
$VERBOSE=TRUE;
$nomecognome="nomecognome";
#$CONSTLARGEZZA600=730;
$CONSTLARGEZZA600='95%';
$AUTOPAGINA= $_SERVER["PHP_SELF"]; //ATTENZIONE! $PHP_SELF va in locale ma non in remoto!!!; 
$SKIN	  = true;
$DFLTSKIN = "default"; 	
$DFLTSKIN_SERIA = "default"; 	
$NOMESKIN = 	Session("skin");
$ISGUEST = isguest();
$ISSERIO = Session('serio');
if ($ISSERIO ) {
	$NOMESKIN =$DFLTSKIN_SERIA;
}
if ($NOMESKIN=="") 
	$NOMESKIN =$DFLTSKIN;
$NOMESFONDO =  "skin/$NOMESKIN/sfondopagina.jpg";  
$VISUALIZZASKIN= TRUE; 
$WEBMASTERMAIL = "palladius.bon.ton+goliardia@gmail.com"; 
$TAG_MIO_AIUTANTE = "<a href='mailto:viperottapisa@hotmail.com'>Vipera</a> o <a href='mailto:manuelb.ernardi.ni+goliardia@gmail.com'>Palo</a>";
$SITENAME = "www.goliardia.it";
$MAILNONVA = FALSE; // finchè è vero che le mail non partono, scrivo cose x gli utenti.
$UPLOADVA = FALSE;  
$GETUTENTE = getUtente();
$ISANONIMO = anonimo();
$ISSERIO = Session('serio');
$ISSINGLE = Session('single');
$ISPAL = ($GETUTENTE == $GODNAME) && Session("powermode");
$ISGOLIARD = Session("isgoliard");
$SERIOSTRING= ($ISSERIO ? " and m_bSerio=1 " : "");
$PAGEVER = "7.1"; # versione delle pagine
$DEBUGVENERDI = 1;
setSession("sessprovaric","boh - ".time());

function listaAuguri() {
	$res=mysql_query(
		    "select m_sNome as m_snome,year(current_date())-year(datanascita) as quanti, m_bguest from loginz where ".
			"date_format(current_date(),\"%m-%d\") = ".
			"date_format(datanascita,\"%m-%d\") "
			);
	scriviListaCompleanno($res,"auguri oggi: ");
	$res2=mysql_query(
		      "select m_sNome as m_snome,year(current_date())-year(datanascita) as quanti,m_bguest from loginz where ".
			"date_format(adddate(current_date(),interval 1 day),\"%m-%d\") = ".
			"date_format(datanascita,\"%m-%d\") "
			);
	echo "<br/>";
	scriviListaCompleanno($res2,"auguri domani: "); 
	invio();
}


function linkaViolaTarget($lnk,$frase,$target) {
	global $ISSERIO,$AUTOPAGINA; 
	$altezza = 30;
	$tagFoto = "";
	$lnk=strtolower($lnk); 
	if (! $ISSERIO)
		$tagFoto= getImg( "icone/$frase.gif",$altezza)."<br>"; 
	if (contiene($AUTOPAGINA,$lnk))
		return "<td align=\"center\" class=\"BGbianco\">$tagFoto<a href='$lnk' target='$target'><font face=\"verdana,arial,".
			"geneva,sans-serif\" size=\"1\" class=\"fgviola\"><b>$frase</b></font></a></td>";
	else 
		return "<td align=\"center\" class=\"BGviola\">$tagFoto<a href='$lnk' target='$target'><font fa".
			 "ce=\"verdana,arial,geneva,sans-serif\" size=\"1\" class=\"FGbianco\">$frase</font></a></td>";
}

function richiediRegistrazione() {
	 global $ISANONIMO;
	 if (! $ISANONIMO) {
		 scrivib("non sei anonimo (ISAN vale $ISANONIMO), quindi puoi presgeuire x sto sito... (sta frase non dovrebbe comparire, cacchio!)<br>");
		 return;
	} // se no...
	scriviErroreSpapla(rosso
		(
		"<div align='left'>Mi spiace, questa pagina richiede che tu fai il log".
		"in (x sapere chi sei e presentarti la pagina di conseguenza!).<br/>Sei registrato?<br>".
		"Se <b>NO</b>, clicca su <a href='nuovo_utente.php'>NUOVO UTENTE</a><br/>".
		"Se <b>SI</b>, fai il <a href='login.php'><b><BIG>login</BIG></B></a>.<br/>".
		"Se <b>NI</b>, (ovvero lo 6 ma non t ricordi + la pwd) clicca (dopo averci indugiato".
		" qualche secondo sopra col mouse (ah! le nuove frontiere dell'html!)...) su <a href='login_dimenticatapwd.php'>".
		getdefinizioni("Ho dimenticato la password","ti dico che sei pirla xchè FORSE NON SAI che su UTENTE puoi cambiare la bruttissima password che ti ho assegnato automaticamente io e renderla mnemonicamente + accessibile. EHI! Brutta pwd a chi? ma lo sai che viene calcolata appicciacando 3 pezzi a caso da 69 parole scelte accuratamente x voi? Per rendere meno grigio il vostro login? Chi vi dà questo?!? Eh? Oh! La prox volta che offendi pensaci prima!").
		"</a>.</div>"
		),"login.php");
	bona();
}





function formlogin()
{
?>
<table height="20"><tr><td>
<form method="post" action="login.php" name="login">
 	user <input type="text" name="nickname" size="8"><br>
	<script language=javascript>
         document.login.nickname.focus();
    </script>
	pwd <input type="password" name="password" size="8" ><br>
	<center><input type="submit" value="entra"></center>

</form>
</td></tr></table>
<?php 
}
function dataGrafico($y)  { return '<IMG SRC="fancyric/drkteal.gif" WIDTH="1" HEIGHT="' . floor(y*50+51) . '">'; }
function togliEstensioneEDaUltimoSlash($nome) { $tmp=basename($nome); return $tmp; }

function scriviListaCompleanno($res,$frasepreposta)
{
$righe=mysql_num_rows($res);

if ($righe>0)
	scrivib($frasepreposta);
while ($rsx=mysql_fetch_array($res))
	{
	 $nome= ($rsx["m_snome"]);
	 if (!($rsx["m_bguest"]))
		$nome="<b>$nome</b>";
	 echo("<a href='utente.php?nomeutente=".$rsx["m_snome"]."'>$nome</a> (".$rsx["quanti"].") ");
	}
}

function scriviListaUltimiUtenti($res,$frasepreposta) {
	$righe=mysql_num_rows($res);

	if ($righe>0)
		echo("$frasepreposta: ");
	while ($rsx=mysql_fetch_array($res))
		echo("<b>".$rsx["0"]."</b> (".$rsx["1"]."' fa) ");
}



function amezzanotte() { // "chiedi a venerdi' se sa fare un CRON demone in php";
}

function h6($x) {return "<h6>$x</h6>";} 
?>
<html>
<head>
<?php  // meta http-equiv="Content-Type" content="text/html; charset=utf-8" 
?>
	<meta name="verify-v1" content="flSynBLe5vYUAQyFIHH62h+BTpm4cGkI8Ne4s2MyCBU=" />
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-15">
	<meta http-equiv="expires" content="0"> 
	<meta name="description" content="Il sito della goGliardia italiana... una community aperta a goliardi e non solo per incontrarsi, scrivere cagate e conoscere gente. Creato da Riccardo 'zio Pal' Carlesso">
	<meta name="author" content="Riccardo Carlesso" />
	<meta name="keywords" content="goliardia, forum, chat, gioco delle coppie, Montecristo, fittone, SVQFO, cene, baccanali, palladius, carlesso, riccardo, gaudeamus, feriae matricolarum, università, bologna, Università, università degli studi, gogliardia, zingarata ">
	<title><?php 
$dinizio = time();
$titolo="?!?";
if (! Session("antiprof")) {
	$titolo =  $VIRTUALHOST ;
	} else  {
		$titolo = "La Repubblica";
	} 
?><?php  echo $titolo?></title>
<?php if ($VISUALIZZASKIN) { ?>
	<link href="skin/<?php  echo $NOMESKIN?>/style/style.css" rel="stylesheet" type="text/css">
<?php 
}
else
{
?>
	<link href="provaric.css" rel="stylesheet" type="text/css">
<?php 
}
?>
</head>
<?php  if (! $SKIN) 	{ ?>
	<body class='bkg_chiaro' >
<?php  		} else {}

?>
<body background="<?php  echo $NOMESFONDO?>">
<?php  if ($ABILITAJS) {
	# ok JavaScript
?> 
<script type="text/javascript" >
	startList = function() {
		if (document.all&&document.getElementById) {
			navRoot = document.getElementById("nav");
			for (i=0; i<navRoot.childNodes.length; i++) {
				node = navRoot.childNodes[i];
				if (node.nodeName=="UL" ) {
					node.onmouseover=function() { this.className+=" over"; }
				  	node.onmouseout=function() { this.className=this.className.replace(" over", ""); }
	   			}
	  		}
	 	}
	
	}
	window.onload=startList;
</script>
<?php 
	} # end if JavaScript
?>
<center>
<?php 

//debugga("debug: siamo in <b><i>$DOVE_SONO</i></b><br>");

$arrHeader=array();
$i=0;


deltat("preMenu");

if (! $ABILITAJS) { // vecchio menu consequenziale...
	// LOGIN O LOGOUT???
if ($ISANONIMO && ! $APERTOATUTTI ) {
	$arrHeader[$i++]=linkaViola("index.php","home");
	 $arrHeader[$i++]=linkaViola("login_dimenticatapwd.php","Password Dimenticata");
	 $arrHeader[$i++]=linkaViola("login.php","login");
	 $arrHeader[$i++]=linkaViola("help.php","help");
	 $arrHeader[$i++]=linkaViola("segnalazioni.php","segnalazioni");
	 $arrHeader[$i++]=linkaViola("support.php","support");
} else {	// solo x utenti normali
	$arrHeader[$i++]=linkaViola("agendamail.php","agenda");
	$arrHeader[$i++]=linkaViola("antiprof.php","anti prof");
	if (isadminvip()) { $arrHeader[$i++]=linkaViola("bugz.php","bugz"); }
	$arrHeader[$i++]=linkaViola("canzoni.php","canti");
	if (! $ISANONIMO) $arrHeader[$i++]=linkaViolaTarget("chat2.php","chat","_new");
	$arrHeader[$i++]=linkaViola("citta.php","citta");	
	$arrHeader[$i++]=linkaViola("contenuti.php","contenuti");
	#$arrHeader[$i++]=linkaViola("download.php","download");
	if (! $ISSERIO)	
	$arrHeader[$i++]=linkaViola("giocodellecoppie.php","coppie");
	$arrHeader[$i++]=linkaViola("calendario.php","eventi");
	$arrHeader[$i++]=linkaViola("faq.php","FAQ");
	$arrHeader[$i++]=linkaViola("pag_tutti_messaggi.php","forum");
	if ($ISGOLIARD)
			$arrHeader[$i++]=linkaViola("pag_utente.php","gestioni");
	$arrHeader[$i++]=linkaViola("gms.php","GMS");
	if ((Session("PX"))<10)
		$arrHeader[$i++]=linkaViolaTarget("help.php","aiuto","_new");
	if($ISANONIMO)
		 $arrHeader[$i++]=linkaViola("help.html","help");
	$arrHeader[$i++]=linkaViola("index.php","home");
	if ($ISANONIMO) $arrHeader[$i++]=linkaViola("login.php","login");
	$arrHeader[$i++]=linkaViola("linkz.php","Linkz");
	$arrHeader[$i++]=linkaViola("mandafoto.php","mandaFoto");
	$arrHeader[$i++]=linkaViola("votazioni.php","sondaggi");
	$arrHeader[$i++]=linkaViola("statistiche.php","stats");
	$arrHeader[$i++]=linkaViola("support.php","support");
	if (! $ISPAL) 	$arrHeader[$i++]=linkaViola("utente.php","utente");
}
//if ($ISPAL) 	$arrHeader[$i++]=linkaViola("powerquerysql.php","[SQL]");
if (isadminvip()) 	$arrHeader[$i++]=linkaViola("powerquerysql.php","[SQL]");
if (Session("ADMIN"))  	$arrHeader[$i++]=linkaViola("pannello.php","[Pannello]");
} // fine menu
	# usa l'array riempito per cagare il menu iconcioso
scriviHeader($arrHeader,"663399","000000","FFFFFF"); // viola_tiscali nero bianco

deltat();

if ($ABILITAJS) { echo getMenuTop(); } 

deltat("postMenu");

scrivi("<table width=\"".$CONSTLARGEZZA600."\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"20\">");

?>






<tbody><tr>

<td width=366 align=center>
<center>
<?php 


pubblicaBanner();



?>







</center>
</td>










<td  align=center>
<table border=0>

<tr>
	<td>	<font class='piccolino'>
		<img src="<?php  echo $IMMAGINI?>/clock.jpg" align="center">
			<?php  echo getHHMM()?><br/>
		</font></td>


<td>
	<center>

	<font class='piccolino'>
<?php  
	if (! $ISANONIMO)
		echo "collegato da <b>".intval((time()-Session("collegato_alle"))/60) ."</b>'";
	else 
		echo "fa' mo' il login, da bravo..";



#$qweN=getUtentiRecenti();		  // getApplication("utentiattivi"); 
#if ($qweN==1) scrivi("<b><i>$qweN</b></i> utente recente?!?");
#	else scrivi("<b><i>$qweN</b></i> utenti recenti?!?");
?>
</font>
 </td>
</tr>
<tr>
 <td><font class='piccolino'>
	<img src="<?php  echo $IMMAGINI?>/utentemsnfeluca.gif" align="center">
	<b class="InizialeMaiuscola"><?php  echo definizioni(ucwords(getUtente()),"e ti chiami '".Session("nomecognome")."'")?></b>
    </font>
 </td><td>
	<font class='piccolino'>
<?php  if ($GETUTENTE != "anonimo" )
	{
			//		if ($ISPAL) echo "[PX:".Session("PX")."]";
?>
<b class="InizialeMaiuscola">
<?php  echo Session("livello")?>
		<?php  if (isGod()) scrivi(" Godly");?>
		<?php  if (isAdmin()) scrivi(" Admin");?>
</b>
</font>
</td></tr><tr><td>
 <?php 
	}
	else // ANONIMO
		formlogin();

if (! $ISANONIMO)
	{
?>
<table border="0">
<tr><td>
<!---
	<font class='piccolino'>
		collegato da <b><?php  echo intval((time()-Session("collegato_alle"))/60) ?></b>'
	</font>
--->
</td>
<tr><td>
<font class='piccolino'>
	<?php  formBegin("cerca.php","cerca")?>
	<input height='5' size='8' type='text' name='goliardiDaCercare' >
	<script language=javascript>
         document.cerca.goliardiDaCercare.focus();
      </script>



	<?php  formbottoneinvia("cerca") ?>	
</font>
</td></tr></table>
</td><td><center>
<a href="logout.php"><b>LOGOUT</b></a>


 
<?php  
	} 
?>
</td></tr></table>
		</center>
</td>
<td align=right>
<?php  
	// verifico se esiste la foto con quel nome
//echo "GETUTENTE vale $GETUTENTE...";
scrivi(getFotoUtenteDimensionata($GETUTENTE,90));

scrivi("</td></tr></table>");


$msg=getMessaggioPrecedente();

if ($msg)
	scrivi("MSG PRECEDENTE: [$msg]");

lineaViola($CONSTLARGEZZA600)
	or scrivi(rosso("eccezione nella linea viola (roba da matti...)")) and bona();


scrivi("<table width='$CONSTLARGEZZA600'><tr><td><center>");

	if ($ISANONIMO)
		; //scrivi(rosso("Sei <i>anonimo</i>.")); // ;
	else {
		if (isGuest()) {
			global $TAG_MIO_AIUTANTE; 
		 	definizioni(rosso("Sei <b>ospite</b>. Metti il mouse qui sopra che mo' ti spiego..."),
			"In quanto tale, avrai poteri limitati in questo sito. Se hai problemi, guardati le FAQ e se proprio non resisti scrivi al webmaster (trovi la mail in fondo in basso). Per non essere ospite, la cosa migliore e + veloce è mandare una tua foto (thumbnail: guarda nelle FAQ se non vuoi che ti venga rimandata indietro con un niente di fatto) via mail a "
			."$TAG_MIO_AIUTANTE e aspettare di essere promosso. Se la tua foto non rispecchia le esigenze descritte, <i>non</i> ti promuoverò. <br/><u>Non fare l'errore di credere che questo sia un sito goliardico, non sopravvalutarlo!</u> ;-)"
				);
		} 
	}
	#if (isAdmin()) {
	#	echo (("<font class=debug>Sei admin, complimenti! <br/><b>ATTENZIONE</b>, forse spie di Cofferati sono nel sito. Per favore, cerca di tenere buone le persone, cerchiamo di non censurare niente ma stiamo attenti ai toni... tenete d'occhio l'utente 'Trombino I'. Capite anche voi che questa cosa non dev'essere visibile alle spie, se anche x sbaglio ne avessimo userizzato uno di sicuro non sarà admin!!! Diffondete la notizia con msn e canali fidati a persone fidate.</font>"));
	#}
scrivi("</center></td></tr></table>");

$POST_DEBUG="";


deltat();
$msgHeader=strval(getMemozByChiave("header"));
deltat("getmemo di header");




scrivi("<center><table cellspacing=\"0\" cellpadding=\"0\" width=\"$CONSTLARGEZZA600$\" height=\"20\" border=\"0\"><tbody><tr><td><center>");


if ($VISUALIZZA_MSG_OCCASIONALE_NELLHEADER && strlen($msgHeader) > 24) 
{
scriviTabellaInscatolataBellaBeginVariante("Messaggio occasionale","messaggimiei");
scrivi($msgHeader);
scriviTabellaInscatolataBellaEnd();
}


formEnd(); // è una maialata: lo faccio finire fuori dalla tabella, ma funge!!!!! se vuoi saperlo è la form dio ricerca dell'header



// qua c'era l'help


deltat();


function paginaAmmessaAdAnonimi()
{
global $AUTOPAGINA;
if (ereg("support.php\$",$AUTOPAGINA)) return TRUE;
if (ereg("login",$AUTOPAGINA)) return TRUE;
if (ereg("help.php\$",$AUTOPAGINA)) return TRUE;
if (ereg("nuovo_utente.php\$",$AUTOPAGINA)) return TRUE;
if (ereg("segnalazioni.php\$",$AUTOPAGINA)) return TRUE;
return FALSE; 
}





if (! $APERTOATUTTI)
{//echo "non aperto a tutti - ";
if (! contiene($AUTOPAGINA,"index") ) // eccezione!!!!!!
{	// venerdi' in originale era un ISSET
//	if (!(issetSession("nickname")) 	&& ! contiene($AUTOPAGINA,"login")  && ! contiene($AUTOPAGINA,"nuovo_utente") ) 
//	if (!(issetSession("nickname"))) // anonimo
	if ($ISANONIMO)
	   if (! paginaAmmessaAdAnonimi())
		{
		//echo (rosso("deb: autopag, contieneindex: $AUTOPAGINA - '".contiene($AUTOPAGINA,"index") ."'.<br/>"));

		richiediRegistrazione(); // fa la spapla dicendo che ti devi registrare!!
		}
	
}
else if(! Session("nickname")) 
		$indexAndAnonomo=1;
}
else  {if ($ISANONIMO) 
			scrivib("Nonostante tu sia anonimo, benvenuto nel sito (devi ringraziare Tit)!!!<br/>");
	}


if (! contiene($AUTOPAGINA,"index")) // l'index è già troppo pesante...
	if (! $ISANONIMO && !isGuest())
{deltat("fgcB");
 if (! $ISSERIO && !(Session("antiprof")) )
	{
		//formGiocoCoppie(contiene($AUTOPAGINA,"coppie"));
	}
deltat("fgcE");
}

if ($indexAndAnonomo && 0) {
	echo "<table><tr><td><img src='immagini/palladius/pal-zoolander.jpg' height='180'> <br/> <small><b>Pal ha appena rivisto Zoolander</b></small> </td><td>" 
	. "<small> Mi spiace, ma da utente <i>NON</i> registrato ti lascio vedere <u>solo</u> 'sta pagina; se ho fatto le cose x benino, tutti i link ti dovrebbero catapultare al login!!! Ora tu penserai (lo dico perchè in siti simili l'ho pensato anch'io): perchè brutto bastardo vuoi registrarmi?!? Per vendere informazioni su di me al Grande Fratello che osserva? Per far soldi? Per inviarmi pubblicità via mail?!? Nulla di tuto questo. Ogni utente del sito ha possibilita' di scrivere, commentare e in generale <i>fare danni</i> e siccome io NON sono un indovino se non creo un utente per te e tu non lo scrivi ogni volta che entri, non so chi tu sia quando tu ti colleghi. Il bello è che se fai questa fatica (e non mi prendi per il culo inserendo una mail farlocca) avrai un sacco di servizi <i>agratis</i> e senza pubblicità alcuna, che è più di quello che offre la maggior parte dei siti. Ricorda che se fai danni io (e chi per me) ti osservo... Intelligenti pauca ;) <br />"
	. "<b>PS</b> Se avete voglia, vi invito a iscrivervi e a usare un nuovo sito meno 'casereccio' di questo (non l'ho <i>scritto</i> io, ma solo isntallato e personalizzato un po') che e' <a href='http://www.goliardia.it/joomla/'>QUI</a>. Se nei prossimi 10 anni la tecnologia cambiera' (ricordate Vanderhoff di Wayne's world?) e io avro' (come temo) poco tempo per tener dietro ad essa, probabilmente tal sito sara' il naturale approdo di questa comunita'; vi invito caldamente, dunque, a perderci 10 minuti a testa a iscrivervi, riempire i dati del vostro utente in community, e tentare di usare il forum; saro' ben lieto di fornirvi maggiori poteri e maggiori responsabilita' (come ad un certo fotografo) se me lo chiedete via <a href='mailto:$WEBMASTERMAIL'>e-maiala</a> (e non offendetevi, vi rispondo con MOOOOLTA calma, abbiate pazienza, se avete fretta leggetevi le FAQ, c'e' di solito tutto cio' di cui avete bisogno). <BR /> "
	. "<b>PPS</b> Pezzi di merda, se tra di voi c'e' un programmatore che ha voglia di dare una mano SI FACCIA VIVO, vi supplico. Possibile che nessuno dica nulla? Bah... Se non per altruismo fatelo per la gloria! E per la Chiara, Giovanna, Ilaria...</small>"
	. "</td></tr></table>";
	//));
	echo "<h3> <a href='login.php'><big>Login</big></a> - <a href='login_dimenticatapwd.php'>Hai dimenticato la Password ?!?</a> - <a href='http://www.goliardia.it/nuovo_utente.php'>Registrati</a>! </h3> ";
}

deltat("fine heder");

if ($ISPAL)
	{
			// esempio di grafico
	/*
	$output = '<TABLE CELLPADDING="1" CELLSPACING="0" BORDER="0"><TR>';
	for ($i=0; $i<20; $i+=0.1) 
		{
    		output += '<TD VALIGN="BOTTOM">' + dataGrafico(Math.sin(i*i)) + '<\/TD>';
		}
	output += '<\/TR><\/TABLE>';
	scrivi(output);
	*/
	}

#if (isAdminVip())
if ($ISPAL)
	listaAuguri();





// diamo x scontato che NON sono anonimo?



	$res=mysql_query("select count(*) as quanti from gms where idutentericevente=".getIdLogin()." AND m_bnuovo=1");
	$gmsnuovi=mysql_fetch_array($res);

	$nummsg = intval($gmsnuovi["quanti"]);
	if ($nummsg > 0)
		{
		img("casellinadiposta.gif",5+2*$nummsg);
		if ($nummsg ==1)
			scrivi(rosso(" Hai $nummsg <a href='gms.php'>messaggio</a>!!!<br/>"));
		  else	
			scrivi(rosso(" Hai $nummsg <a href='gms.php'>messaggi</a>!!!<br/>"));
		}



if ($ISSERIO) 
	scrivii("<small>Attenzione, sei <b>Serio</b>. Questo vuol dire che ti verranno nascoste certe cose (tra cui il mitico Gioco delle Coppie) nel sito e lo vedrai in maniera + sobria. Per cambiare questo stato di cose, vai sotto <a href='utente.php'>Utente</a> e mettiti faceto :-)</small><br/>");



if (!isValidNick($GETUTENTE))
	{bug("attento! il tuo nome '$GETUTENTE' non mi piace!!! Dillo al webmaster, grazie. (Sto creando regole stringenti chi inventa nuovi login, ma non posso modificare i vecchi in automatico. mi appello dunque alla vostra sensibilità)");}

?>
<? if ( $MESSAGGINO_HEADER ) { ?>
	<table class='irlanda'> <tr><td> 
		<img src='immagini/icone/trifoglio.jpg' height='30' /> 
		</td><td> <?php echo $MESSAGGINO_HEADER ?> </div> </table>
<? } ?>

<center>
