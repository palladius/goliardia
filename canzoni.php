<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";


$pf = QueryString("printfriendly");

if (!empty($pf ))
	{
	// visualizzo la canzone senza ghirigori vari...
	$res=mq("select distinct * from canzoni c,loginz l where l.id_login=c.id_login AND ID_canzone=".$pf);	
	$rs=mysql_fetch_array($res);
	scriviReport_Canzone_pf($rs);
	exit();
	}


include "header.php";

function accludiIndice($link)
{
echo "[ ";
for ($i='A';$i<'Z';$i++)
	{
	 $lnk=ereg_replace("_X_",$i,$link);
	 echo "<a href='$lnk'>$i</a>";
	 echo " | ";
	}
$i='Z'; 
$lnk=ereg_replace("_X_",$i,$link);
echo "<a href='$lnk'>$i</a>";
echo " ]";
}


echo "<h1> Canzoni </h1>";

accludiIndice("$AUTOPAGINA?iniziale=_X_");
invio();
if (querystring("op") != "")
	{
	 echo "<a href='$AUTOPAGINA'>Torna a canzoni</a><br>";
	 aggiungiModificaCanzone();
	 bona();
	}
else
	echo "<a href='$AUTOPAGINA?op=aggiungicanzone'>Aggiungi una canzone</a><br>";



function trasformaAccordi($str)
{
$tmp = replace($str,"{","<b><font color='#660066' size='-1' class='accordo'>");
$tmp = replace($tmp,"}","</font></b>");
return $tmp;
}

function aggiungiModificaCanzone($ID="")
{
$azione =($ID == "" ? "inserisci" :  "modifica");
	
$titolo = "";
$autore = "";
$IDCANZONE=random(2000000000); // long...
$idutente= Session("SESS_id_utente");
$datacreazione = dammiDatamysql();
$note  = "";
$corpo = "";
$seria = TRUE;


?>
<table>
 <tr><td><center>
	<h1>'<?php  echo $azione?>' canzone</h1>
<center>
Ho aggiunto la possibilità di dire se la canzone è 'seria'.
Ovviamente difficilmente si troveranno canti goliardici seri. 
X serio intendo qualcosa di strettamente attinente alla goliardia x cui 
se la vede un clerico di 70 anni non storca <i>troppo</i> il naso... :-)
Punirò chi usa male questo flag. <b>Mettete gli accordi tra parentesi graffe pliz!!! Vedrete che figata!</b>
<br>
<table><tr><td bgcolor="#EEEEEE">
<i>Esempio (per Manino):</i><br>
Fateci largo che passiamo noi {DO FA}<br>
I giovanotti de sta Romabbella {SOL DO}<br>
</td></tr></table>
<?php 
formBegin();

if ($azione == "modifica")
	{
	$res=mq("select distinct * from canzoni where ID_canzone=$ID");
	$rs=mysql_fetch_array($res);
	$titolo = $rs["titolo"];
	$autore = $rs["Autore"];
	$note  = stripslashes($rs["Note"]);
	$corpo = stripslashes($rs["Corpo"]); // 
	$seria = $rs["m_bSeria"];
	$datacreazione = $rs["Data_creazione"];
	formhidden("my_hidden_id",$ID);
	}

formtext("titolo",$titolo);
formtext("Autore",$autore);
formhidden("id_canzone",$IDCANZONE);
formhidden("id_login",$idutente);
formhidden("data_creazione",$datacreazione);
formhidden("hidden_operazione",$azione."canzone");
scrivi("<table valign=top>");
scrivi("<tr><td valign=top>");
scrivi("Metti qui il testo vero e proprio della canzone<br>");
formtextarea("Corpo",$corpo,30,50);
scrivi("</td><td valign=top>");
scrivi("Metti qui eventuali note (coefficiente di cantabilità patavino,...)<br>");
formtextarea("Note",$note,30,50);
trtdEnd();
tableEnd();
formSceltaTrueFalse("m_bSeria","La Canzone è seria?",$seria);
formbottoneinvia("invia");
formEnd();
?>
</center>
</td></tr></table>
<?php 
}



if (Form("hidden_operazione")=="inseriscicanzone")
	{
	scrivi(rosso("Sto inserendo una canzone..."));
	autoInserisciTabella("canzoni");
	bona();
	}

if (Form("hidden_operazione")=="modificacanzone")
	{
//	scrivi(rosso("Sto modificando una canzone... TBDS"));
	autoAggiornaTabella("canzoni","id_canzone");
	bona();
	}


$pf = QueryString("printfriendly");
/*
	if (!empty($pf ))
	{
	scrivi(rosso("Sto mettendo la canzone printer-friendly..."));
	$res=query("select distinct * from canzoni c,loginz l where l.id_login=c.id_login AND ID_canzone=".$pf);	
	$rs=mysql_fetch_array($res);
	scriviReport_Canzone_pf($rs);
	bona();
	}
*/

if (Form("OPERAZIONE")=="CANCELLA")
	{
	scrivi(rosso("Sto cancellando la canzone numero ".Form("ID_canzone")."...<br>"));
	autoCancellaTabella("canzoni",Form("ID_canzone"));
	bona();
	}

if (Form("OPERAZIONE")=="MODIFICA")
	{
	aggiungiModificaCanzone(Form("ID_canzone"));
	bona();
	}


function scriviTitoletto($rs)
{
global $ISSERIO;
if (($rs["m_bSeria"])==FALSE && $ISSERIO) // da non visualizzare
	 scrivi("<a href='canzoni.php?id=".$rs["ID_canzone"]."'><i>".$rs["titolo"]."</I></a><br>");
else // OK
	 scrivi("<a href='canzoni.php?id=".$rs["ID_canzone"]."'>".$rs["titolo"]."</a><br>");
}






function scriviReport_Canzone($sqlLast10Messaggi)
{
global $ISSERIO,$AUTOPAGINA,$GETUTENTE;

if (! $ISSERIO)
	scrivi(getFotoUtenteDimensionataRight($sqlLast10Messaggi["m_sNome"],100));

?>
<center>
 <big>
  <b class='inizialemaiuscola'>
   <?php  echo $sqlLast10Messaggi["titolo"]?>
  </b>
 </big>
 <a href="<?php  echo $AUTOPAGINA?>?printfriendly=<?php  echo $sqlLast10Messaggi["ID_canzone"]?>">
  <img src="immagini/stampante.jpg" height="30" border="0">
 </a></center>
 <div align=right>(di <b class='inizialemaiuscola'><?php  echo $sqlLast10Messaggi["Autore"]?></b>,
  buttata su da <i class='inizialemaiuscola'><?php  echo $sqlLast10Messaggi["m_sNome"]?>)</i>
 </div>
<?php 
scrivi(trasformaAccordi(stripslashes(ripulisciMessaggio($sqlLast10Messaggi["Corpo"],TRUE,"<i><b><table><tr><td>"))));
#scrivi(trasformaAccordi(ripulisciMessaggio(stripslashes($sqlLast10Messaggi["Corpo"]),TRUE)));
scrivi("<center><b> Note </b><br><i>".ripulisciMessaggio(stripslashes($sqlLast10Messaggi["Note"]),TRUE)."</i>");
invio();
img("linearossa.jpg",28);
invio();
scrivi("</center>");

if ($sqlLast10Messaggi["m_sNome"] == $GETUTENTE || isAdminVip())  // 
   {tabled();
	trtd();

	formBegin();
	formhidden("my_hidden_id","ID_canzone");
	formhidden("ID_canzone",$sqlLast10Messaggi["ID_canzone"]);
	formhidden("OPERAZIONE","CANCELLA");
	formbottoneinvia("Cancella canzone");
	formEnd();

	tdtd();

	formBegin();
	formhidden("my_hidden_id","ID_canzone");
	formhidden("ID_canzone",$sqlLast10Messaggi["ID_canzone"]);
	formhidden("OPERAZIONE","MODIFICA");
	formbottoneinvia("Modifica canzone");
	formEnd();

	trtdend();
	tableend();
   }
}







function scriviReport_Canzone_pf($sqlLast10Messaggi)
{
?>
<center>
 <h1>
  <b class='inizialemaiuscola'>
   <?php  echo $sqlLast10Messaggi["titolo"]?>
  </b>
 </h1>
	 (di <b class='inizialemaiuscola'><?php  echo $sqlLast10Messaggi["Autore"]?></b>)
 </center>
 <?php 
echo trasformaAccordi(ripulisciMessaggio(($sqlLast10Messaggi["Corpo"]),TRUE));
scrivi("<center><b> Note </b><br><i>".ripulisciMessaggio($sqlLast10Messaggi["Note"],TRUE)."</i>");
invio();
img("linearossa.jpg",28);
invio();
scrivi("</center>");
}




?>
<center>
<table border="0" width="<?php  echo CONSTLARGEZZA600?>">
<tr>
 <td width="30%" valign="top" class="colonninadisinistra">
	<h3>Canti disponibili</h3>
<?php 
$sql="select distinct titolo,m_sNome,ID_canzone,m_bSeria from canzoni c,loginz l where l.id_login=c.id_login ";

if ((QueryString("iniziale"))!="")
	$sql .= " and titolo like '".QueryString("iniziale")."%'";
$sql .= " order by titolo";


$res=mq($sql);
while ($rs=mysql_fetch_array($res))
					scriviTitoletto($rs);

$quantiNeVisualizzoINTERAMENTE=7;

if ((QueryString("iniziale"))!="")
	{$iniziale=strtolower(QueryString("iniziale"));
   	 ?>
	 </td>
	 <td valign=top width="70%" class="colonnonadidestra">
		<h3>Le prime <?php  echo $quantiNeVisualizzoINTERAMENTE?> canzoni in '<?php  echo $iniziale?>'</h3>
       <?php 
	 $seqlLast10Messaggi=mq("select distinct * from canzoni c,loginz l where c.id_login = "
			."l.id_login AND titolo LIKE '$iniziale%' ORDER BY titolo");
	 for ($j=0;$j< $quantiNeVisualizzoINTERAMENTE ; $j++)
		if($sqlLast10Messaggi=mysql_fetch_array($seqlLast10Messaggi))
			{
			scriviReport_Canzone($sqlLast10Messaggi);
			} // end for
	} // fine caso CON INIZIALE
else
if(((QueryString("id"))!=""))
	{//echo rosso("id vale: ".querystring("id"));
	 $res=mq("select distinct * from canzoni c,loginz l where ID_canzone="
			.QueryString("id")." AND l.id_login=c.id_login");
	 $rs=mysql_fetch_array($res);	
  ?>
 	</td>
	<td valign=top width="70%" border="10" class="colonnonadidestra">
		<h3>Canzone richiesta</h3>
   <?php 
	if (! (($rs["m_bSeria"])=="FALSE" && $ISSERIO) )
			scriviReport_Canzone($rs);
	} // fine caso gestente canzone singola via querystring (id=...)
else
	{
   	 ?>
	 </td>
	 <td valign=top width="70%" class="colonnonadidestra">
		<h3>Ultime <?php  echo $quantiNeVisualizzoINTERAMENTE?> canzoni...</h3>
       <?php 

	 $seqlLast10Messaggi=mq("select distinct * from canzoni c,loginz l where c.id_login = "
			."l.id_login order by data_creazione DESC");
	 for ($j=0;$j< $quantiNeVisualizzoINTERAMENTE ; $j++)
		if($sqlLast10Messaggi=mysql_fetch_array($seqlLast10Messaggi))
			{
			scriviReport_Canzone($sqlLast10Messaggi);
			} // end for
	} // fine caso SENZA querystring (pagina caricata vergine, senza "?ID=..."
?>
	</td></tr></table></center>
<?php 
include "footer.php";
?>

