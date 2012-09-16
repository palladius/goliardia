<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

?>
					<h1>Calendario</h1>

<div>
<table><tr><td>
	<img src='http://www.google.com/intl/it/options/icons/calendar.gif' height='30'>
</td><td>
	<h3><a href='calendario-gugol.php'>Dai un'occhiata al nuovo gugol Calendar</a></h3>
</td></tr>
</div>
<?php 

if (! isguest())
	echo'<h3><a href="modifica_appuntamenti.php">Aggiungi appuntamento</a></h3>';

$LARGHEVENTO = 500;


$mesi = array("gennaio","febbraio","marzo","aprile","maggio","giugno","luglio","agosto","settembre","ottobre","novembre","dicembre");


//date("Y-m-d H:i:s",$time);
// i mesi vanno da 1 a 12
function getCurrentMonth()
{return getMonthFromDate(time());
}

function getMonthFromDate($dat)
{
$tmp = date("n",strtotime($dat)) ; // (n) è il mese da 1 a 12
//scrivi(rosso("getmonth($dat), returning [$tmp]<br/>"));
return $tmp;
}

function getDayFromDate($data)
{//return intval(phpdata("j\g\i\o\r\n\o",strtotime($data)));
return intval(date("j\g\i\o\r\n\o",($data))); 
}

function scriviUltimiAppuntamentiPostati($N) {
  echo "<h2>Ultimi $N eventi postati...</h2>";
  echo "<table border=1>";
 # SELECT
  $sql  = "SELECT id_appuntamento,l.m_snome,luogo,"
        . "(month(data_inizio)-month(CURDATE())) AS DELTAMESI, "
	. "(YEAR(data_inizio)-YEAR(CURDATE())) AS DELTAANNI,"
        . "(month(data_inizio)-month(CURDATE()))+12*(YEAR(data_inizio)-YEAR(CURDATE())) AS TOT,"
        . "nome,data_inizio,data_fine,città, CURDATE() as curdate,"
        . "l.id_login,`tipodiappuntamento`,data_invio"
        . " FROM appuntamenti a,loginz l "
        #. "WHERE data_inizio >= curdate() "
        #. "AND data_inizio <= DATE_ADD(CURDATE(), INTERVAL ".$nmesiavanti." MONTH) "
	. " WHERE l.id_login=a.id_login "
	#. " AND data_invio < CURDATE() " # inutile direi...
	. " ORDER BY data_invio DESC "
	. " LIMIT $N";
        #. " AND l.id_login=a.id_login ORDER BY data_inizio";

  $res=mysql_query($sql)
                or die(rosso("erroreeeeeee ".mysql_error()));
  #scriviRecordSetConTimeout($res,$N,"Gli ultimi $N appuntamenti");

  while ($rs=mysql_fetch_array($res)) {
	trtd();
	$nome=$rs["m_snome"];
	echo "<a href=utente.php?nomeutente=$nome'><img src='immagini/persone/$nome.jpg' height='50'></a>";
	tdtd();
	echo "<a href='modifica_appuntamenti.php?id=".$rs["id_appuntamento"]."' >".$rs["nome"]."</a>";
	echo "<br/> (a ".$rs["città"].", posted by <b class='utente'>$nome</b>)";
	echo "<br/> <i>(".$rs["tipodiappuntamento"].")</i>";
	#echo "<br/> dal ".$rs["data_inizio"];
	#echo "<br/> al ".$rs["data_fine"]; 
	echo "<br/> dal <b>".toHumanDateGGMM(phpdata($rs["data_inizio"]))."</b>"; 
	echo " al <b>".toHumanDateGGMM(phpdata($rs["data_fine"]))."</b>"; 
	tdtd();
	trtdEnd();
  }





  echo "</table>";
}




function getMonthName($num)
{global $mesi;
 if ($num<1 || $num >12)
	return "mese invalido";
 return $mesi[$num-1];
}


/*
	se "mini" è super stringato
	se "medio" è mini ma con + dati
	se "maxi" c'è tutto...
*/

function scriviAppuntamentiMese_darimetterepoiinfunzioni_inc_medio($nmesiavanti)
{
global $puoCancellare,$ISPAL,$LARGHEVENTO;

$sql  = "SELECT id_appuntamento,l.m_snome,luogo,"
	. "(month(data_inizio)-month(CURDATE())) AS DELTAMESI, (YEAR(data_inizio)-YEAR(CURDATE())) AS DELTAANNI,"
	. "(month(data_inizio)-month(CURDATE()))+12*(YEAR(data_inizio)-YEAR(CURDATE())) AS TOT,"
	. "nome,data_inizio,data_fine,città, CURDATE() as curdate,"
	. "l.id_login,`tipodiappuntamento`,data_invio"
	. " FROM appuntamenti a,loginz l "
	. "WHERE data_inizio >= curdate() "
//	. "WHERE data_inizio >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) "
	. "AND data_inizio <= DATE_ADD(CURDATE(), INTERVAL ".$nmesiavanti." MONTH) "
    . " AND l.id_login=a.id_login ORDER BY data_inizio";



/* ex sql ASP che andava e qua ovviamente non va
$sql  = "SELECT id_appuntamento,l.m_sNome,luogo,month(data_inizio-now)-1 AS DELTAMESI,"
	"year(data_inizio-now)-1900 AS DELTAANNI,DELTAMESI+12*DELTAANNI AS TOT,"
	"nome,data_inizio,data_fine,città,l.id_login,tipodiappuntamento,data_invio FROM appuntamenti a,loginz l"
    . " WHERE (((data_inizio)>=now() OR (day(data_inizio)=day(now) AND month(data_inizio)=month(now) AND year(data_inizio)=year(now))) "
    . ") AND month(data_inizio-now)-1+12*(year(data_inizio-now)-1900)<".$nmesiavanti.""
    . " AND l.id_login=a.id_login ORDER BY data_inizio";
*/


scrivi("<center><table border='0' width='".$LARGHEVENTO."'>");

$meseattuale=-42; // confronto l'attuale con l'istantaneo del nuovo record: se diversi pubblico nome del mese... :-)
$nuovomese=FALSE;

$res=mysql_query($sql)
		or die(rosso("erroreeeeeee ".mysql_error()));

//ottimo x debug
//scrivirecordsetcontimeout($res,10);
//bona();

trtd();
$i=0;


while ($rs=mysql_fetch_array($res))
{
 $puoCancellareStoEvento= $puoCancellare || $rs["id_login"] == getIdLogin() ||isadminvip();
 $i=1-$i;  // 0 1 0 1 0 1 0 1 è involutiva quindi stabile cmq!

 $DATA = ($rs["data_inizio"]);
// scrivib("1- DATA evento: rs[datainizio]:[".$rs["data_inizio"]."] -- DATA[$DATA]<br/>");
 $mese_rs = getMonthFromDate($DATA);
 $nuovomese =  ($mese_rs != $meseattuale);



	if ($nuovomese)
		{
		if ($meseattuale != -42) // se non prima volta
				FANCYENDOLD();
		FANCYBEGINOLD(getMonthName($mese_rs));
		}
	   else
		FANCYMIDDLEOLD();

// scrivi(rosso("meseattuale($meseattuale) <<<<------ mese_rs($mese_rs)"));
 $meseattuale = $mese_rs;




if ($puoCancellareStoEvento)
	{
	 scrivi("<table border='0' width='".$LARGHEVENTO."'>");
	 scrivi("<tr><td width='1%'>");
	 formBegin("modifica_appuntamenti.php");	// altra pagina, outsourcing
	 formhidden("my_hidden_id","id_appuntamento");
	 formhidden("id_appuntamento",$rs["id_appuntamento"]);
	 formhidden("OPERAZIONE","CANCELLA");
	 formbottoneinvia("X");
	 formEnd();
	 tdtd();
	}
	$dettagli = "<a href='modifica_appuntamenti.php?id=".$rs["id_appuntamento"]."'>(dettagli)</a>";
	$titolo = "<br> ".$rs["nome"]."\n";
	$cit = ", ".($rs["città"]);



		// se la data di fine è valida, la uso.
	$DATAFINENONVALIDA = TRUE;
	$MOTIVO = "sembra ciuccio ok, data valida! yuppi!"; // innocente fino a prova contraria
	$DATAFINE = $rs["data_fine"];
	$DELTADAYS = 12345; // valore quasi impossibile da generare x sbaglio ;)
	$DELTASECONDI = strtotime($DATAFINE)-strtotime($DATA);
	$MAXGIORNISENSATO = 8; // max giorni(fine-inizio) x cui la cosa sia sensata
		// attento che 8 non vuol dire che al max visualizza 8 giorni, possono essere anche 9 o 10, direi. vedi funzione NON OMOGENEA

	if (empty($rs["data_fine"])) // campo vuoto: in php mi puzza, le realizza come epoch(1-1-70)
		$MOTIVO = "recordset VUOTO"; 
	else if (($DATA) == (($DATAFINE))) // se sono uguali non la visualizzo, giustamente!!!
		$MOTIVO = "date coincidenti"; 
	else if (($rs["data_fine"])==0) // se sono uguali non la visualizzo, giustamente!!!
		$MOTIVO = "data nulla (non so se sianum o data con i meni....guardaci)";
	else if ($DELTASECONDI <0) // fine prima di inizio: bug
		$MOTIVO = "fine precede inizio";
	else if ($DELTASECONDI > 86400*$MAXGIORNISENSATO) // fine prima di inizio: bug
		$MOTIVO = "fine troppo avanti";
	else
	   {
		$DATAFINENONVALIDA = FALSE; // i due casi + semplici ed eclatanti
		scrivid("comincio a ragionare sullaprossimità temporale: devo controllare che"
			. "la data d'inizio(".$DATA.") preceda ma di poco la fine(".$DATAFINE.")"		
			. ". Comnincerei calcolando DELTADAYS così fa fico e dice: dal 29 gennaio, x 3 giorni e così via...");		
		$DELTADAYS = ceil((86399+$DELTASECONDI)/86400); // non è perfetta ma quasi.
//		echo "$DATA-".time($DATA)."-".date($DATA)."-".strtotime($DATA);
//		echo "<br>$DATAFINE-".time($DATAFINE)."-".date($DATAFINE)."-".strtotime($DATAFINE);
		}

	scrivid(rosso("datafine vale: ..".($rs["data_fine"]))." e la mia scelta ha x motivo :<b>$MOTIVO</b><br/>");
	
	scrivi(getFotoUtenteDimensionataRight($rs["m_snome"],90));
	 	// $DATA vale ($rs["data_inizio"]);
	if ($DATAFINENONVALIDA)
		scrivi(h2(rosso(getDayFromDate(phpdata($DATA)).$cit).$titolo));
	else
		scrivi(h2(rosso(getDayFromDate(phpdata($DATA)) . "-". getDayFromDate(phpdata($rs["data_fine"])) .$cit) .$titolo ));

  	 $cit= ! empty ($cit); // !="undefined" && cit != "null")

	 $dat=String($rs["data_inizio"]);
	   $dat=! empty($dat);   	//(dat!="undefined" && dat!="null")


	if ($DELTADAYS != 12345)
	{
		scrivi("durata: ");
		scrivib("$DELTADAYS giorni");
		invio();
	}

	scrivi("tipo: ");
	scrivib($rs["tipodiappuntamento"]);
	invio();
	$resPresenze = mysql_query("select sum(m_nquantitotale) AS TOTALE from eventipresenze where id_appuntamento=".$rs["id_appuntamento"]);
	$rsPresenze=mysql_fetch_array($resPresenze);
	$presenti=$rsPresenze["TOTALE"];
	scrivi("presenze finora: ");
	if (empty($presenti)) 
		scrivii("0"); //presenti="0";
	else 
		scrivib(rosso($presenti));
	invio();
	scrivi("luogo: ");
	scrivib(stripslashes($rs["luogo"]));
	invio();
	scrivi("<div align='right'><i>(postata da <b>".$rs["m_snome"]."</b> il ".toHumanDate(phpdata($rs["data_invio"])).")</i></div>");
	freccizzaFrase($dettagli);


/* POSTATA DA XXX il YYY
scrivi(getCoppiaTabella("Utente segnalante:","<b>".rsOrd("m_snome")."</b>" .
		getFotoUtenteDimensionataRight(rsOrd("m_snome"),70)	))
		."(in data ".toHumanDate(new Date(rs("data_invio"))).")";

*/




/*
	 if (cit || dat)

	 {if (cit && ! dat)

		  scrivi("<div align=right><i>(".rs("città").")</i><br>\n")
	  else
	  if (!cit && dat)

		  scrivi("<div align=right><i>(".toHumanDate(DATA).")</i><br>\n")
	  else // ho tutti e due
	  scrivi("<div align=right><i>(".rs("città").", ".toHumanDate(new Date(rs("data_inizio"))).")</i><br>\n")
	 }
*/

scrivi("</div>");

if ($puoCancellareStoEvento)
	{scrivi("</td></tr></table>");}








}

FANCYENDOLD();


tableEnd();
scrivi("</center>");


scriviUltimiAppuntamentiPostati(10);
}


//deprecata("in fondo a calendario","30 mesi anzichè 7 originali");
scriviAppuntamentiMese_darimetterepoiinfunzioni_inc_medio(7);

include "footer.php";

?>



