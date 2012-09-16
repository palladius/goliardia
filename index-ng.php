<?php 

include "conf/setup.php";
#include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

global $IMMAGINI;

$FOTOPRIMAPAGINA_DFLT = "grigliata-2003.jpg";
#$ALTEZZAFOTO=450;
$ALTEZZAFOTO=270;
$QUANTI_MESSAGGI = 5; // messaggi in home, che do in pasto a "scriviTabellaInscatolataBellaBeginVarianteConIcona"

$VISUALIZZA_MESSAGGIO_OCCASIONALE 	= 0;
$VISUALIZZA_FORM_RICERCA 		= 0;
$VISUALIZZA_MESSAGGIO_DEL_GIORNO  	= 0;
$VISUALIZZA_EDITORIALE 			= 0;
$VISUALIZZA_CONTENUTI_PALNEWS 	= 1;



$n=1000;
$q=20;

	// 1 per mille che compaia menabrea...
$improbabile=random($n);

$rs=query1("select valore from xxx_memoz where chiave='fotoprimapagina'");
$FOTOPRIMAPAGINA=$rs[0];



echo h1("Index NEW (solo PAL)");
echo h2("A tendere, questo diventerà sia GRAFIUCAMENTE alla karaoke sia LOGICAMENTE alla jjumla (option=COMANDO). Per ora la seconda parte la sta facendo '<a href='index2.php'>index2</a>'");



function scriviStatisticaGoliardi($NUM,$veloce)
{

$result=mysql_query("select count(*) as N from goliardi");
$numero = -42;
if ($row = mysql_fetch_row($result))
		{
		$numero=$row[0];
		}

scriviSmall("Ultimi <b>$NUM</b> goliardi (su <b>$numero</b>)");

$result=mysql_query("select `Nomegoliardico`,id_ordine,id_gol from goliardi g order by id_gol desc");
for ($i=0;$i<$NUM;$i++)
   if ($row = mysql_fetch_row($result) )
	{
		$numero=$row[0];
		scrivib("<br><a href='pag_goliarda.php?idgol=$row[2]'>$row[0]</a> ");
	if (! $veloce)
		scrivi(getOrdineGraficoById($row[1],30));
	}

scrivi("<br>\n");
}


function formricerca() { 
scriviTabellaInscatolataBellaBeginVarianteConIcona("Cerca di Tutto","ricerca","icone/cerca.gif");
scrivi("<table height=\"20\"><tr><td>");
formBegin("cerca.php");
	scrivi("<center>");
	scrivi("<input type='text' name='goliardi da cercare'  value=''>\n"); 
	formbottoneinvia("CERCA"); 
scrivi("</center>");
formEnd();
scrivi("</td></tr></table>");
scriviTabellaInscatolataBellaEnd();
}

if ($improbabile<=1){
	if ($VERBOSE)
	echo "<bgsound id=\"scherzosuonomenabrea\" src=\"pornomena.wav\" loop=\"1\"/>";
}

if ($VERBOSE) echo "<table border=\"0\" width='100%'>";
if ($VERBOSE) echo "<tr>\n\n<td width='20%' valign=top><center>";
if (! anonimo() && $VISUALIZZA_FORM_RICERCA) {
	 formricerca();
}

formSondaggi(TRUE);
scriviTabellaInscatolataBellaBeginVarianteConIcona("Ultimi ".$QUANTI_MESSAGGI." Messaggi","messaggi","icone/messaggi.gif");

setMessaggioSuccessivo("vengo dal login");

if (! anonimo() && !isGuest())
	{
	 //freccizzaFrase("<big><a href='pag_messaggi.php'>aggiungi un messaggio</a></big>\n");
	?>
	<center>
	<a href="pag_messaggi.php">
		<img src="<?php  echo $IMMAGINI?>/scrivi.gif" alt="aggiungi un messaggio" width=22 height=22 border=0>
	</a>
	<a href="pag_tutti_messaggi.php">
		<img src="<?php  echo $IMMAGINI?>/leggi.gif" alt="leggi ultimi N messaggi" width=22 height=22 border=0>
	</a>
	</center>
	<?php 
	}


stampaMessaggi($QUANTI_MESSAGGI,20,FALSE,1); // ultimi 5 msg con char alto 8, INSICURO


scriviTabellaInscatolataBellaEnd();

//echo rosso(getapplication(""));


//scrivi("<h3>Ultimi utenti collegati:</h3>");
//scriviLogUtentiConOra();

scrivi("<p></p>");


scriviTabellaInscatolataBellaBeginVarianteConIcona("Ultimi utenti collegati","utenti","utenti.jpg",25);
scriviLogUtentiConOra();
//scrivi($msgHeader);
scriviTabellaInscatolataBellaEnd();




scrivi("</center></td>\n\n\n<td valign=top>");

if (strlen($msgHeader) > 54 && $VISUALIZZA_MESSAGGIO_OCCASIONALE); {
	scriviTabellaInscatolataBellaBeginVarianteConIcona("Messaggio occasionale","messaggimiei","icone/messaggi.gif");
	scrivi($msgHeader);
	scriviTabellaInscatolataBellaEnd();
	echo "<br>";
}




if( $VISUALIZZA_MESSAGGIO_DEL_GIORNO )
{
	scriviTabellaInscatolataBellaBeginVariante("Messaggio del Giorno (by <i><b>zio Pal</b></i>)","messaggi dei ragazzi..");
	scrivi("<table border=0 class=messaggiodelgiorno bgcolor='#FFEEEE'><tr><td>");
	#scrivi(getFotoRight("msg del gg.gif",60));
	scrivi("<i>".getMemozByChiave("benvenuto")."</i>");

	tableEnd();
	scriviTabellaInscatolataBellaEnd();
}




scrivi("<center><br>");
scrivi(getFoto2($paz_foto."primapagina/".$FOTOPRIMAPAGINA,"foto prima pagina",0,$paz_foto."serie/matrice.jpg",100));
scrivi("<br/> <b>Fig. A</b>: ");
scrivi(getMemozByChiave("didascaliahome"));


scrivi("</center>");


if ($VISUALIZZA_CONTENUTI_PALNEWS){ 
	$result=mysql_query("select * from contenuti c,loginz l WHERE tipo='PALNEWS' AND c.idlogin = l.id_login AND c.m_battivo=1 and m_binattesa=0 ORDER BY datacreazione desc"); 
	while ($row = mysql_fetch_array($result)){
			scriviContenutoPalnews($row["titolo"], ( $row["contenuto"]));
		}
}


scrivi("</center></td>\n\n\n<td width='20%' valign=top><center>");

scriviTabellaInscatolataBellaBeginVarianteConIcona("Chat","chat","icone/chez pal.gif");
	freccizzaFrase("<a href='chat2.php?nota=inizio' target='_new'>Entra in chat!</a>");
	scriviUtentiAttivi();
scriviTabellaInscatolataBellaEnd();

scrivi("<p></p>");

scriviTabellaInscatolataBellaBeginVarianteConIcona("Appuntamenti del Mese","Appuntamenti, cene, ed eventi vari","icone/eventi.gif");
if (! isGuest())
	freccizzaFrase("<a href='modifica_appuntamenti.php'>aggiungi un evento</a><br>\n");
scriviAppuntamentiMese("mini",3);

scriviTabellaInscatolataBellaEnd();

scrivi("<h3>Statistiche</h3>");

// SBUR USER
$result=mysql_query("select count(*) as N from loginz where m_bguest=0", $connessione);
while ($row = mysql_fetch_row($result)){
	scriviSmall("Utenti registrati: <br>");
	scrivib($row[0]."/");
	}

// totali
$result=mysql_query("select count(*) as N from loginz", $connessione);
while ($row = mysql_fetch_row($result))
	{scrivib($row[0]); 	}

scriviSmall("<br>Ultimi utenti inseriti");

$res= mysql_query("select m_snome,m_hemail,id_login,m_bguest  from loginz order by id_login desc");
//$rarr= mysql_fetch_array($res);

$QUANTIMAX = 8;

$puoCancellare=isAdminVip(); 

if ($ISPAL) 
	$QUANTIMAX=15;

for ($i=0;$i<$QUANTIMAX;$i++)
if ($rs= mysql_fetch_array($res))
{
	{if (isGuest()) 		// utente sfigato, non vede la posta
		scrivib("<center>".$rs[0]."</center>");
	 else
{
if ($puoCancellare)
{	if ($i==0)	tabled(); // se sono io... inizio tabella

	trtd();
	scrivi("<a href='mailto:".$rs[1]."'>");
	img("email.jpg");
	scrivi("</a> ");

	scrivi(linkautente($rs["m_snome"],"<b class=InizialeMaiuscola>".$rs["m_snome"]."</b>"));


	/*
	formquery("M","select * from loginz where m_snome='".$rs[0]."'");
	tdtd();

		con mysql non mi fido + a fare una cosa DEL GENERE

	formBegin("pag_messaggi.php");
	formhidden("my_hidden_id","id_login");
	formhidden("id_login",$rs["id_login"]);
	formhidden("OPERAZIONE","CANCELLA_LOGIN");
	$ospitechar= ($rs["m_bguest"]  ? "X" : "X (U)");
	formbottoneinvia($ospitechar);
	formEnd();
	tdtd();

	*/
	trtdEnd();
}
else		// utente notrmale, vede la posta 30-3-03: non vede + la posta :D
	 scrivi("<center>".whois($rs[0])."<b class=InizialeMaiuscola>".$rs[0]."</b></center>");





}
	// $rs=mysql_fetch_row($res);
	}

}
if ($puoCancellare) tableEnd(); // se sono io... fine tabella

deltat();

hline(50);

scriviStatisticaGoliardi(4,TRUE);

hline(50);

deltat();


$rs  = mysql_query("select count(*) as N from ordini");
$rarr= mysql_fetch_array($rs);

scriviSmall("Ordini inseriti: ");
scrivib($rarr["N"]);
scriviSmall("<br>Ultime modifiche:<br>\n");

$res= mysql_query("select id_ord,nome_veloce from ordini order by data_creazione desc");

for ($i=0;$i<3;$i++)
	if ($rs=mysql_fetch_array($res))
		{
		scrivi("<b class=inizialemaiuscola>".$rs[1]."</b> ".getOrdineGraficoById($rs[0],20)."<br>");
		}

hline(50);

scriviSmall("Ultime nomine: ");
$res   = mysql_query("select g.`Nomegoliardico`, c.`nomecarica`,c.id_ordine,g.id_gol from goliardi g, cariche c, nomine n ".
	"WHERE n.id_carica=c.id_carica AND n.id_goliarda=g.id_gol ORDER BY n.id_nomina DESC");

for ($i=0;$i<4;$i++)
{
if ($rs = mysql_fetch_array($res))
	{scriviSmall("<center><b><a href='pag_goliarda.php?idgol=".$rs[3]."'>".$rs[0]."</a></b>, ".$rs[1]);
	 scriviSmall(getOrdineGraficoById($rs[2],15)."</center>");
	}
}

hline(50);
deltat();
$almenovoti=10;

scriviSmall("I reginetti del giorno:");
$resReginette=mysql_query("select m_snome as Nome,avg(m_nvoto)/10 as media_Voto,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante='M' group by idutentevotato,m_snome having count(*)>".$almenovoti." order by media_Voto desc");
$rsReginette=mysql_fetch_row($resReginette);

scrivi("<div align='center'><table>");
$resReginetto=mysql_query("select m_snome as Nome,avg(m_nvoto)/10 as media_Voto,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante='F' group by idutentevotato,m_snome having count(*)>".$almenovoti." order by media_Voto desc");
$rsReginetto=getRiga($resReginetto);

scrivi("<tr><td align='right'>");
scrivi(getFotoUtenteDimensionata($rsReginette[0],30));
scrivi("</td><td>");
scrivi(getFotoUtenteDimensionata($rsReginetto[0],30));

scrivi("</td></tr><tr><td align='right'><small><b class=inizialemaiuscola>".$rsReginette[0]."</b></small></td><td><b class=inizialemaiuscola><small>".$rsReginetto[0]."</small></b></td></tr>");
scrivi("</table></div>");
scrivi("\n</center>\n  </td>\n</tr>\n</table>\n\n\n");

include "footer.php";

?>

