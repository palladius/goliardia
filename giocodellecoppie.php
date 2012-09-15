<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

$qualescelta=QueryString("arg");

#$tmp = (QueryString("arg"));
# if (!empty($tmp))
#	$qualescelta=$tmp;

$fortunello="feanor";

$MYID=Session("SESS_id_utente");
$MAXCOPPIEVISUALIZZATE=10;
$numVisualizzati = 7;

//if ($ISPAL) visualizzaformz();

function randomizzaGiocoCoppieUltimaEntrata()
{
global $ISPAL;
echo rosso("VOTO A CASO<br/>");
$ismaschio= intval(Session("SEX") != "M"); // è il contrario, ma devi pur votare persone di sesso OPPOSTO!!! ;)
$res=mq("select id_login from loginz where m_bismaschio=$ismaschio AND m_bguest=0 order by m_datalastcollegato desc");

if (isdevelop()) 
	echo rosso("DEV: attento versione time consuming di posizionamento cursore!!! metti anche che cerchi tra "
			."le sole NON votate... studia mysql...");
$rs=mysql_fetch_row($res);

if ($rs)
	{
	if ($ISPAL)
		echo "<br>PAL: id: ".$rs[0];
	formGiocoCoppiePersonale(TRUE,$rs[0],FALSE,FALSE);
	}
else
	bug("attenzione, baco in function randomizzaGiocoCoppie()");
}





function  intabellaIntestazioneERecordsingoli($res,$titolo="ric manca il titolo nella pag del gioco delle coppie!") {
global $numVisualizzati ;
//$rsMedia=mysql_fetch_array($res);
scrivirecordsetcontimeout($res,$numVisualizzati,$titolo );
/*
tabled();
scriviRsntestazione($rsMedia,TRUE);
for(ii=0;ii<numVisualizzati && (!rsMedia.EOF);ii++)
{
scriviRsRecordSingolo(rsMedia,true);
rsMedia.MoveNext();
}
tableEnd();
*/
}






function scriviReportCoppieGiorno()
{
global $MAXCOPPIEVISUALIZZATE,$VOTOMINIMO;

$VOTOMINIMO=1;		// deve essere sempre un decimo
$VOTOMINIMOXDIECI=10;   // deve essere sempre il decuplo
$MAXCOPPIEVISUALIZZATE=10;
tabled();
trtd(); 
scrivi(h2("Le coppie del giorno"));
?>
E dato che mi rompete su come vengono calcolate, vi dico la formula: sono le ultime <b><?php  echo $MAXCOPPIEVISUALIZZATE?>
</b> coppie la cui data di voto media (data1+data2) è massima tra le coppie che si son date voto non segreto
 entrambe con voto minimo (medio? minimo tra i 2? non ricordo) di almeno <b><?php  echo $VOTOMINIMO?></b>. Infine, 
l'icona del bacio è attiva se <i>entrambi</i> si bacerebbero, e quella dei gameti se entrambi scoperebbero 
(non mi rompete i coglioni sul condizionale: <i>è</i> corretto, fidatevi). :-) PS ditemi se vi piacciono le 
iconcine di Farina Prodaxions®.
<?php 
tdtd();
scrivi(h2("Le coppie ..."));
?>
Qua banalmente il vincolo ulteriore è che la singlehood di entrambi è richiesta. Forse anche vincoli di voto SIMILE, mo' vedremo
<?php 
tttt();

$sql=   "select l2.m_snome as nome2,l1.m_snome as nome1,g1.m_nvoto as voto1,"
	. "g2.m_nvoto as voto2,g1.m_bscoperebbe as scop1,g1.m_bbacerebbe as bac1"
	. ",g2.m_bscoperebbe as scop2,g2.m_bbacerebbe as bac2,g1.idutentevotante,g1.idutentevotato "
	. " FROM giococoppie g1,giococoppie g2,loginz l1, loginz l2 where l1.id_lo"
	. "gin=g1.idutentevotante AND l2.id_login=g1.idutentevotato AND "
	. " g1.idutentevotante=g2.idutentevotato AND g1.idutentevotato=g2.idutentevotante "
	. " AND g1.m_bprivato=0 AND g2.m_bprivato=0 " // post la flaca
	. " AND g1.sexvotante='M' AND (g1.m_nvoto>".$VOTOMINIMOXDIECI." "
	. "OR (g1.m_nvoto<=10 AND g1.m_nvoto>=".$VOTOMINIMO."))"
	. " AND (g2.m_nvoto>".$VOTOMINIMOXDIECI." OR (g2.m_nvoto<=10 AND g2.m_nvoto>=".$VOTOMINIMO."))"
	. " order by (g1.datavoto+g2.datavoto) desc";

$sql2= "select l2.m_snome as nome2,l1.m_snome as nome1,g1.m_nvoto as voto1,"
	. " g2.m_nvoto as voto2,g1.m_bscoperebbe as scop1,g1.m_bbacerebbe as bac1"
	. ",g2.m_bscoperebbe as scop2,g2.m_bbacerebbe as bac2,g1.idutentevotante,g1.idutentevotato "
	. " FROM giococoppie g1,giococoppie g2,loginz l1, loginz l2 "
	. " where l1.id_login=g1.idutentevotante AND l2.id_login=g1.idutentevotato AND "
	. " g1.idutentevotante=g2.idutentevotato AND g1.idutentevotato=g2.idutentevotante "
	. " AND g1.m_bprivato=0 AND g2.m_bprivato=0 " // post la flaca
	. " AND l1.m_bsingle=1 AND l2.m_bsingle=1 " // singlehood
	. " AND g1.sexvotante='M' AND (g1.m_nvoto>".$VOTOMINIMOXDIECI
	. " OR (g1.m_nvoto<=10 AND g1.m_nvoto>=".$VOTOMINIMO."))"
	. " AND (g2.m_nvoto>".$VOTOMINIMOXDIECI." OR (g2.m_nvoto<=10 AND g2.m_nvoto>=".$VOTOMINIMO."))"
	. " order by (g1.datavoto+g2.datavoto) desc";



// sql +=	" order by (g1.m_nvoto+g2.m_nvoto) desc" NONN VAAAAAAAAAAAAA



// PRIMA META
/*
echo rosso("chiuso x ottimizzazione query. chi ne sa a tronchi di SQL mi contatti, grazie: in sostanza la query manda "
	."in palla mysql (e non amndava un db access): devo dedurre sia un problema di join non ottimizzato sugli "
	."indici... in effetti è un join tra 4 tabelle di cui 2 han 10K elementi. con gli indici però si riduce a "
	."un join IDIOTA... qualcuno che mi spieghi i selfjoin grazier. astenersi perditempo.");
*/
#IMPALLA TUTTO! 
	scriviCouplez($sql);

//echo rosso ("prova ric cop giorn ret");return;

tdtd(); // SECONDA META!

#IMPALLA TUTTO! 
scriviCouplez($sql2);
//echo rosso("idem come sopra");
trtdEnd();
tableEnd();
}



function scrivireportcommenti($idutente)
{
scrivi("<table width='550'><tr><td>");
$cont=0; // sx o dx
$MAXXRIGA=4;

tabled();
$sqlz= "select m_snome,commento,m_bprivato from giococoppie,loginz where idutentevotato=".$idutente
	. " and id_login=idutentevotante and commento <> 'null' order by m_bprivato,datavoto desc";
$res = mysql_query($sqlz)
	or sqlerror($sqlz);

while($rs=mysql_fetch_array($res))
{ $sx= ($cont==0); // dice se è a sx, la prima volta dev'esser vero..
  $cont++;
  if ($cont==$MAXXRIGA) $cont=0;
  $dx= ($cont==0); // post incrementato...
  $TAG= ( $sx ? "<tr><td valign='top'>" : "</td><td valign='top' >");

 if ($rs["m_bprivato"])
				//	scrivi("<tr><td align='right' width='30%'><b>".$rs("commento")."</b> <i> (pvt)</i>");
	scrivi($TAG."<b>".$rs["commento"]."</b> <i> (?!?)</i>");
 else
	{
	scrivi($TAG);
	scrivi(getFotoUtenteDimensionata($rs["m_snome"],50));
	scrivi("</td><td align='right'><b>".$rs["commento"]."</b><i> (".$rs["m_snome"].")</i>");
	}
 if ($dx)
	trtdEnd();
 else
 	tdtd();
}
tableEnd();
tableEnd();
}




function scriviReginettiByQuery($titolo,$sqldonne,$sqluomini)
{
global $qualescelta,$GODNAME;

scrivi("<div align='center'><h2>".$titolo."</h2>");
$NUMREGINETTI = ($qualescelta == "reginetti") ? 10 : 3;
scrivi("<table border=0>");
$resReginette=mq($sqldonne);
$resReginetto=mq($sqluomini);

for ($i=0;$i<$NUMREGINETTI;$i++)
{
$rsReginette = mysql_fetch_array($resReginette);
$rsReginetto = mysql_fetch_array($resReginetto);

if ($rsReginette && $rsReginetto )
	{
	scrivi("<tr><td><big><b>".($i+1)."</b></big></td><td align='right'>");
	$altezzadecrescente = ($i ? 80:100)-15*$i; // 100 - 65 - 50
	if ($altezzadecrescente<40) $altezzadecrescente = 40 ;
	if ($rsReginette)
		scrivi(getFotoUtenteDimensionata($rsReginette[0],$altezzadecrescente));
	scrivi("</td><td>");
	if ($rsReginetto)
		scrivi(getFotoUtenteDimensionata($rsReginetto[0],$altezzadecrescente));
	scrivi( "</td></tr><tr><td></td><td align='right'><b class=inizialemaiuscola>".$rsReginette[0]
		. "</b></td><td><b class=inizialemaiuscola>".$rsReginetto[0]."</b></td></tr>");
	}
} // end i

//echo rosso("reginetti ric");
while ($i < 100)
	{
	$rsReginette = mysql_fetch_array($resReginette);
	$rsReginetto = mysql_fetch_array($resReginetto);
	if ($rsReginette && $rsReginetto )
		{
		$i++;
		#if ($rsReginetto[0]==$GODNAME || $rsReginetto[0]=="spanami")
		if ($rsReginetto[0]==$GODNAME || $rsReginetto[0]==$fortunello)
			{		// faccio la mia parte... fossi anche al 15mo posto...
			scrivi("<tr><td></td><td></td><td><i>...</i></td></tr><tr><td>");
			scrivi("<big><b>".$i."</b></big></td><td align=right>");
			scrivi(getFotoUtenteDimensionata($rsReginette[0],50));
			scrivi("</td><td>");
			scrivi(getFotoUtenteDimensionata($rsReginetto[0],50));
			scrivi("</td></tr><tr><td></td><td align='right'><b class=inizialemaiuscola>".$rsReginette[0]
				."</b></td><td><b class=inizialemaiuscola>".$rsReginetto[0]."</b></td></tr>");
			}
		}
	else break;
	}
scrivi("</table></div>");
}



function formReginetti()
{
global $MYID,$qualescelta;
////////////////// metto quanti hai votato tra utenti registrati...

$resqw = mq(  "select count(*) from giococoppie g, loginz l where g.idutentevotante=".$MYID
		. " and g.idutentevotato=l.id_login AND l.m_bguest=0");
$rsqw=mysql_fetch_array($resqw);
scrivi("<br/>Tu votasti <b>".$rsqw[0]."</b> (tra gli utenti ATTUALMENTE registrati)");

$resqwe=mq("select count(*) from loginz where m_bIsMaschio=".intval((getSex())=="F")." AND m_bGuest=0");
$rsqwe=mysql_fetch_array($resqwe);
scrivi(" su <b>".$rsqwe[0]."</b> utenti attualmente registrati...<br/>");

$resqw = mq(  "select count(*) from giococoppie g, loginz l where g.idutentevotante=".$MYID
		. " and g.idutentevotato=l.id_login AND l.m_bguest=1");
$rsqw=mysql_fetch_row($resqw);
scrivi( "Mentre tu votasti <b>".$rsqw[0]."</b> (tra gli utenti ATTUALMENTE ospiti,"
	. " il che a regime dovrebbe valer <b>0</b>)<br/>");


$almenovoti=15;

	// posto votomin=8...
$sqlReginette="SELECT l.m_snome as NomeNOMEEEEEEEEEEEEEEEEE,avg(m_nvoto)/10 as media_Voto,count(*) as NumVoti"
		. " FROM giococoppie g,loginz l"
		. " WHERE l.id_login=g.idutentevotato AND sexvotante='M'"
		. " GROUP BY idutentevotato,m_snome"
		. " HAVING NumVoti>$almenovoti"		
		. " ORDER BY media_Voto desc";
$sqlReginetti="select m_snome as Nome,avg(m_nvoto)/10 as media_Voto,count(*) as NumVoti from giococoppie,"
		. "loginz where id_login=idutentevotato AND sexvotante='F' group by idutentevotato,m_snome having numvoti>"
		. $almenovoti." order by media_Voto desc";
$sqlScopabili="select m_snome as _fotoutente,m_snome as Nome,100*avg(m_bscoperebbe) as media_scop,sum(m_bscoperebbe)"
		. " as quante,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante"
		. "='F' group by idutentevotato,m_snome having numvoti>".$almenovoti." order by media_scop desc";
$sqlScopabile="select m_snome as _fotoutente,m_snome as Nome,100*avg(m_bscoperebbe) as media_scop,sum(m_bscoperebbe)"
		. " as quanti,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante"
		. "='M' group by idutentevotato,m_snome HAVING numvoti>".$almenovoti." ORDER BY media_scop  desc";
$sqlBaciabili="select m_snome as _fotoutente,m_snome as Nome,100*avg(m_bbacerebbe) as media_scop,sum(m_bbacerebbe) as"
		. " quante,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante='F'"
		. " group by idutentevotato,m_snome having numvoti>".$almenovoti." ORDER BY media_scop  desc";
$sqlBaciabile="select m_snome as _fotoutente,m_snome as Nome,100*avg(m_bbacerebbe) as media_scop,sum(m_bbacerebbe) as"
		. " quanti,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante='M'"
		. " group by idutentevotato,m_snome having numvoti>".$almenovoti." ORDER BY media_scop  desc";


scrivi("<center>");

if ($qualescelta=="" || $qualescelta=="reginetti" )
{
tabled(); 
 trtd();
  scriviReginettiByQuery("I reginetti di oggi",$sqlReginette,$sqlReginetti);
 tdtd();
	//scriviReginettiByQuery("Gli sreginetti di oggi",sqlMorlocke,sqlMorlocki);
  scriviReginettiByQuery("I sex symbol di oggi",$sqlScopabile,$sqlScopabili);
 tdtd();
  scriviReginettiByQuery("Gli smack symbol di oggi",$sqlBaciabile,$sqlBaciabili);
 trtdEnd();
tableEnd();
}
else
if ($qualescelta==("diconodime"))
	{
	scrivi("<h2>Dicono di te:</h2>");
	scrivireportcommenti(getIdLogin());
	}
else
if ($qualescelta==("coppiegiorno"))
	{


	tabled();
	trtd();
	scrivi("<h1>Ultime coppie...</h1>");
	scriviReportCoppieGiorno();
	}
else
if ($qualescelta==("miecoppie"))
{ 
$VOTOMINIMO=1;
$VOTOMINIMOXDIECI=10; // deve essere sempre il decuplo
$MAXCOPPIEVISUALIZZATE=150;
?>
<h2>Le <i>tue</i> coppie </h2>
<i>(max <?php  echo $MAXCOPPIEVISUALIZZATE?> coppie)<br/>
Sono le ultime <b><?php  echo $MAXCOPPIEVISUALIZZATE?></b> coppie con te ordinate x data discendente di voto del partner tra le coppie che si son date voto non segreto entrambe con voto minimo (medio? minimo tra i 2? non ricordo) di almeno <b><?php  echo $VOTOMINIMO?></b>.
<?php 

$sql=  "select l2.m_snome as nome2,l1.m_snome as nome1,g1.m_nvoto as voto1,g2.m_nvoto as voto2,g1.m_bscoperebbe"
	. " as scop1,g1.m_bbacerebbe as bac1"
	. ",g2.m_bscoperebbe as scop2,g2.m_bbacerebbe as bac2,g1.idutentevotante,g1.idutentevotato "
	. " FROM giococoppie g1,giococoppie g2,loginz l1, loginz l2 where l1.id_login=g1.idutentevo"
	. "tante AND l2.id_login=g1.idutentevotato AND "
	. " g1.idutentevotante=g2.idutentevotato AND g1.idutentevotato=g2.idutentevotante "
	. " AND (g1.idutentevotante=".$MYID." OR g1.idutentevotato=".$MYID.")"
	. " AND g1.sexvotante='M' AND (g1.m_nvoto>".$VOTOMINIMOXDIECI." OR (g1.m_nvoto<=10 AND g1.m_nvoto>="
	. $VOTOMINIMO."))"
	. " AND (g2.m_nvoto>".$VOTOMINIMOXDIECI." OR (g2.m_nvoto<=10 AND g2.m_nvoto>=".$VOTOMINIMO."))"
		//sql +=	" order by (g1.datavoto+g2.datavoto) desc"
	. " order by (g2.datavoto) desc"; // ordinato x voto dell'altra persona



scrivicouplez($sql,$MAXCOPPIEVISUALIZZATE);

} // fine mie coppie
else
if ($qualescelta==("statistiche"))
{ // inizio statistiche
$numVisualizzati = 7;
scrivi(h1("Statistiche!"));
tabled();
echo("<tr valign=top><td>");
scrivi("<h2>I ".$numVisualizzati." più votati:</h2>");

$resMedia = mq("select m_snome as _fotoutente,m_snome as Nome,max(m_nvoto)/10 as Voto_Max,min(m_nvoto)/10 AS "
		. "Voto_Min, avg(m_nvoto)/10 as media_Voto ,count(*) AS NumVoti from giococoppie , loginz "
		. "where id_login=idutentevotato AND sexvotante='F' group by idutentevotato,m_snome order by numvoti desc ");


intabellaIntestazioneERecordsingoli($resMedia, "I ".$numVisualizzati." più votati");

tdtd();

scrivi("<h2>Le ".$numVisualizzati." più votate:</h2>");

$resMedia = mq("select m_snome as _fotoutente,m_snome as Nome,max(m_nvoto)/10 as Voto_Max,min(m_nvoto)/10 AS "
		. "Voto_Min, avg(m_nvoto)/10 as media_Voto ,count(*) AS NumVoti from giococoppie , loginz "
		. "where id_login=idutentevotato AND sexvotante='M' group by idutentevotato,m_snome order by numvoti desc ");

intabellaIntestazioneERecordsingoli($resMedia, "Le ".$numVisualizzati." più votate");

tttt();

scrivi("<h2>I ".$numVisualizzati." più amati (con almeno ".$almenovoti." voti):</h2>");

$resMedia = mq("select m_snome as _fotoutente,m_snome as Nome,avg(m_nvoto)/10 as media_Voto,count(*) as NumVoti"
		. " from giococoppie,loginz where id_login=idutentevotato AND sexvotante='F' group by idutentevo"
		. "tato,m_snome having numvoti>".$almenovoti." order by media_voto desc");

intabellaIntestazioneERecordsingoli($resMedia, "I ".$numVisualizzati." più amati");

tdtd();
 scrivi("<h2>Le ".$numVisualizzati." più amate (con almeno ".$almenovoti." voti):</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,avg(m_nvoto)/10 as media_Voto,count(*) as NumVoti "
		."from giococoppie,loginz where id_login=idutentevotato AND sexvotante='M' group by idutentev"
		."otato,m_snome having numvoti>".$almenovoti." order by media_voto desc");
 intabellaIntestazioneERecordsingoli($resMedia, "Le ".$numVisualizzati." più amate");
tttt();
 scrivi("<h2>I ".$numVisualizzati." più leccaculo (con almeno ".$almenovoti." voti):</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,avg(m_nvoto)/10 as media_Voto_DATO,count(*) as NumVoti"
		." from giococoppie,loginz where id_login=idutentevotante AND sexvotante='M' group by idutentevot"
		."ante,m_snome having numvoti>".$almenovoti." order by media_voto_dato desc");
 intabellaIntestazioneERecordsingoli($resMedia, "I ".$numVisualizzati." più leccaculo");
tdtd();
 scrivi("<h2>Le ".$numVisualizzati." più leccaculo (con almeno ".$almenovoti." voti):</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,avg(m_nvoto)/10 as media_Voto_DATO,count(*) as NumVoti"
		." from giococoppie,loginz where id_login=idutentevotante AND sexvotante='F' group by idutentevot"
		."ante,m_snome having numvoti>".$almenovoti." order by media_voto_dato desc");
 intabellaIntestazioneERecordsingoli($resMedia, "Le ".$numVisualizzati." più leccaculo");
tttt();
 scrivi("<h2>I ".$numVisualizzati." più scopabili:</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,100*avg(m_bscoperebbe) as media_scop,sum(m_bscoperebbe"
	.") as quante,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante='F'"
	." group by idutentevotato,m_snome having numvoti>".$almenovoti." ORDER BY media_scop  desc");
 intabellaIntestazioneERecordsingoli($resMedia, "I ".$numVisualizzati." più scopabili");
tdtd();
 scrivi("<h2>Le  ".$numVisualizzati." più scopabili:</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,100*avg(m_bscoperebbe) as media_scop,sum(m_bscoperebbe)"
		." as quanti,count(*) as NumVoti from giococoppie,loginz where id_login=idutentevotato AND sexvotante"
		."='M' group by idutentevotato,m_snome having numvoti>".$almenovoti." ORDER BY media_scop  desc");
 intabellaIntestazioneERecordsingoli($resMedia,"Le  ".$numVisualizzati." più scopabili");
tttt();
 scrivi("<h2>I ".$numVisualizzati." più scarsi di voto (con almeno ".$almenovoti." voti):</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,avg(m_nvoto)/10 as media_Voto_DATO,count(*) as NumVoti"
		." from giococoppie,loginz where id_login=idutentevotante AND sexvotante='M' group by idutentevotante"
		.",m_snome having numvoti>".$almenovoti." order by media_Voto_dato asc");
 intabellaIntestazioneERecordsingoli($resMedia, "I ".$numVisualizzati." più scarsi di voto");
tdtd();
 scrivi("<h2>Le ".$numVisualizzati." più scarse di voto (con almeno ".$almenovoti." voti):</h2>");
 $resMedia=mq("select m_snome as _fotoutente,m_snome as Nome,avg(m_nvoto)/10 as media_Voto_DATO,count(*) as NumVoti "
		."from giococoppie,loginz where id_login=idutentevotante AND sexvotante='F' group by idutentevotante"
		.",m_snome having numvoti>".$almenovoti." order by media_Voto_dato asc");
 intabellaIntestazioneERecordsingoli($resMedia,"Le ".$numVisualizzati." più scarse di voto");
trtd();
tableEnd();

} // end if statistiche
else
echo "mi hai dato stringa strana: '$qualescelta'..:";

} //FINE formRisultatiGiocoDelleCoppie





if (! Session("antiprof"))
{
?>
<bgsound id="scherzosuonoric" src="../suoni/sitopornoconsonoro.wav" loop="1"/>
<?php 
}


?>
<table width="<?php  echo $CONSTLARGEZZA600?>">
 <tr>
  <td>

<?php  
if (Form("hiddenOPERAZIONE")=="inserisci")
	{
	scrivi("sto tentando d'inserire il dato nel cervellone...<br>");
	$votovalido =  (Form("idUtenteVotante"))==(Session("SESS_id_utente"))
				&&
			  intval(Form("m_nvoto")) <= 100
				&&
			  intval(Form("m_nvoto")) >= 20;

	if ($votovalido )
	{ 
		$ok=autoInserisciTabella("giococoppie");
		if ($ok)
			scrivi("ZVF inserimento ok");
		else
			scrivi("ZVF Qualche errore :-(");
	}
	else
		{
		 log2("HACK ha creato una coppia finta: finto_id_votante: " .(Form("idUtenteVotante"))
		      ."; msg=" .(Form("commento")) ."; utentevotato: " .(Form("idUtenteVotato"))
			);
		}
	hline(80);
	}

if (Form("hiddenOPERAZIONE")=="svota")
	{
	scrivi("sto tentando d'inserire il dato nel cervellino...<br>");
	$ok=mq("delete from giococoppie where idutentevotante=".Form("idutentevotante")
		." and idutentevotato=".Form("idutentevotato"));
	//scrivi("DEBUG spero abbia funzionato, io non lo so sicuro (votante=".Form("idutentevotante").";votato="
	//	.Form("idutentevotato").")...<br>");
	//scrivi(rosso("DEBUG in futuro ridirigi autopagina"));
	ridirigi(post("hidden_tornaindietroapagina"));
	}
img("3.gif"); // ?!??!?



	// MENU!!!

function menugdc($frase,$link)
{
global $AUTOPAGINA,$qualescelta;

scrivi("<a href='".$AUTOPAGINA."?arg=".$link."'>- ".$frase."</a><br/>");

}

//randomizzaGiocoCoppieUltimaEntrata();
randomizzaGiocoCoppie();

 scrivib(h3("Opzioni"));
 scrivi("- Vai alla <a href='votacoppieesagerato.php'><i>Bolgia della Lussuria</i>®</a><br/>");
 menugdc("Le mie coppie (le persone che tu hai votato e che ti hanno votato)",  "miecoppie");
 menugdc("Dicono di me (voti dati a te da persone dell'altro sesso)",   "diconodime");
 menugdc("Coppie del giorno (NEW!)",   "coppiegiorno");
 menugdc("Statistiche varie", "statistiche");
 menugdc("Reginetti forever (i soliti reginetti ma arriva oltre a 3)", "reginetti");

formReginetti();

?>
  </td>
 </tr>
</table>


<?php 
include "footer.php";
?>
