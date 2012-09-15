<?php 

include "conf/setup.php";
#include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$numpag=intval(QueryString("numPag"));
//if (isNaN($numpag) || numpag<1)
if ($numpag<1)
	$numpag=1;
	
$numPagina=$numpag;



$VISUALIZZA_MSG_A_SINISTRA	= 1;
$nMessaggiASinistra		= 15;
$dimPagina			 	= 8;


function getRSPaginato($sql,$numPagina,$dimPagina) {
$limite1 = $dimPagina * ($numPagina-1);
$limite2 = $dimPagina;
return mysql_query("$sql LIMIT  $limite1,$limite2");
}


function linkaPaginazioni($rs,$pagina) {
global $AUTOPAGINA; 
echo "<center><table border=0><tr><td>"; 
$hfoto=13; 
scrivi("<center><font size='+1'>");
$tot= 100; //rs.PageCount; // numero di pagine totale direi.
$start=$pagina-5;
$stop=$pagina+5; 
if ($start < 1) 
	$stop += (-$start)+1;
if ($stop > $tot) 
	$start -= ($stop - $tot);
if ($start < 1) 
	$start=1;
if ($stop > $tot) 
	$stop=$tot;
if ($start > 1) 
	scrivi (" <a href='" .$AUTOPAGINA ."?numPag=1'>"
		.getImg("freccia-bb.gif",$hfoto)
		."</a> &nbsp;");
else
	echo getImg('freccia-bb.gif',$hfoto)."&nbsp;"; 
if ($pagina > $start) 
		echo "<a href='$AUTOPAGINA?numPag="
			.($pagina-1)
			."'>".getImg("freccia-b.gif",$hfoto)
			."</a> ";
	else
		echo getImg("freccia-b.gif",$hfoto);



for ($i=$start;$i<=$stop;$i++)
	{
	if ($i != $pagina)
		{
	?>
		<b>
		<a href='<?php  echo $AUTOPAGINA?>?numPag=<?php  echo $i?>' alt='vai a pagina <?php  echo $i?>'><?php  echo $i?></a>
		</b>
	<?php 
		}
	else
		{
	?>
		<b><?php  echo $i?></b>
	<?php 
		}
	}


		// TASTO AVANTI
		
if ($pagina<$tot)
{ //avanti.gif
	?>
	  <a href='<?php  echo $AUTOPAGINA?>?numPag=<?php  echo $pagina+1?>'><?php  echo getImg('freccia-f.gif',$hfoto)?></a>
	<?php 


}

		// TASTO BEYOND

if ($pagina+10<$tot)
	{ //beyond.gif
	?>
	  <a href='<?php  echo $AUTOPAGINA?>?numPag=<?php  echo $pagina+10?>' border='0'><?php  echo getImg('freccia-ff.gif',$hfoto)?></a>
	<?php 
	}
		// FINE

trtdEnd();
tableEnd();
}		// FINE






function visualizzaInteri($result,$rowSqlLast10Messaggi) {
 global $quantiNeVisualizzoINTERAMENTE ; 
 for ($j=0; $j < $quantiNeVisualizzoINTERAMENTE ; $j++) {
	FANCYBEGIN($rowSqlLast10Messaggi["titolo"]);
	scriviReport_Messaggio($rowSqlLast10Messaggi,TRUE,TRUE);
	$IDMSG= $rowSqlLast10Messaggi["id_msg"];
	$sqlbis="select * from messaggi  m,loginz l WHERE m.id_login = l.id_login AND id_figliodi_msg=".$IDMSG;
	$sqlRES=mysql_query($sqlbis);
	$i=0;
	while ($sqlRE=mysql_fetch_array($sqlRES))
		{$i++;
	  	#echo "<tr><td>";
		FANCYMIDDLE($sqlRE["titolo"]);
	   	scriviReport_Messaggio($sqlRE,TRUE,TRUE); // condizione di stampaggio lungo
		#scrivi("</td></tr>");
		}
	#tableEnd();
	FANCYEND();
	$rowSqlLast10Messaggi = mysql_fetch_array($result);
	} // end for
} // fine funzione


echo "</font></center>";
scrivi("<center><h3><a href='pag_messaggi.php'>Aggiungi un messaggio...</a></h3></center>");
$quantiNeVisualizzoINTERAMENTE = $dimPagina; // x forza...  
?>
<table >
 <?php  if ($VISUALIZZA_MSG_A_SINISTRA) { 
 ?>
 <td width="30%" valign=top>
	<h3>Ultimi <i><?php  echo $nMessaggiASinistra?></i> messaggi</h3>
<?php 
stampaMessaggi($nMessaggiASinistra,8,FALSE) // ultimi N msg con char alto 8, INSICURO
?>
	</td>
	<?php  } // (FINE IF VISUALIZZA_MSG_A_SINISTRA) 
	?>
	<td valign=top>
		<h3>Ultimi <i><?php  echo $quantiNeVisualizzoINTERAMENTE?></i> messaggi...</h3>
<?php 

/*
	$sqlLast10Messaggi=getRecordSetByQuery("select * from messaggi m,loginz l where 	id_figliodi_msg=0 AND m.id_login = l.id_login order by data_creazione DESC");
*/

$sql="select * from messaggi m,loginz l where id_figliodi_msg=0 AND m.id_login = l.id_login order by data_creazione DESC";

$sqlLast10Messaggi = getRSPaginato($sql,$numPagina,$dimPagina);

$rowSqlLast10Messaggi = mysql_fetch_array($sqlLast10Messaggi);

linkaPaginazioni($rowSqlLast10Messaggi ,$numPagina);

visualizzaInteri($sqlLast10Messaggi,$rowSqlLast10Messaggi);

linkaPaginazioni($rowSqlLast10Messaggi ,$numPagina);


?>

</td></tr></table>

</td></tr></table>


<?php 
include "footer.php";
?>
