<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

global $IMMAGINI;

$quantiNeVisualizzoINTERAMENTE=10;


?>
<h1> Linkz </h1>
<h4>Il più importante (altro) sito goliardico italiano è 
<a href="http://www.goliardia.org">www.goliardia.or<i>g</i></a>. Dacci un'occhiata!</h4>
<?php 

$myidlogin = getIdLogin();


function palleggiaForm($nome)
{
  formhiddenApici($nome,replace(Form($nome),"\"","''"));
}


$iddacancellareeventualmente = QueryString("cancellaid");

if  (! empty($iddacancellareeventualmente ))
	{
	if (! isAdminVip()) 
		scrivi("cazzo fai? hai violato le prime difese del dibbì... complimenti...");
	else
		{
		 $rs=mq("delete * from linkz where id_link='$iddacancellareeventualmente'");
		 scrivi("<h1>fatto! <a href='linkz.php'>Torna indietro</a></h1>");
		 bona();
		}
	}

$iddacancellareeventualmente = QueryString("cancellaidprofano");

if  (!empty($iddacancellareeventualmente ))
	{
	 $frase="delete  from linkz where (id_login=".$myidlogin." ) AND id_link="
		.$iddacancellareeventualmente; // cancella con controllo che l'abbia creato lui
	 if (isAdminVip())
 		$frase="delete  \n from linkz \n where  \n id_link='$iddacancellareeventualmente'"; // cancella normale
	 $res=mq($frase);
	 if ($ISPAL) 
		scrivi("sql vale '".$frase."'<br>");
	 scrivi("<h1>fatto! <a href='linkz.php'>Torna indietro</a></h1>");
	 bona();
	}







if (Form("hidden_operazione")=="inseriscilink_preliminare") // chiede inserimento x un certo tipo...
	{
	$tipo=Form("tipo");
	scrivi(rosso("Dammi ulteriori dati sul link, relativi al tipo (<i>".$tipo."</i>)..."));
	if (getUtente()=="palladius")
		visualizzaFormz();

	formBegin();
	palleggiaForm("titolo");
	palleggiaForm("id_link");
	palleggiaForm("id_login");
	palleggiaForm("data_creazione");
	palleggiaForm("tipo");
	palleggiaForm("m_battiva");
	palleggiaForm("m_bFotoattiva");
	palleggiaForm("URLlink");
	palleggiaForm("URLlinkfoto");
	palleggiaForm("Descrizione");
	formhidden("hidden_tornaindietroapagina","linkz.php"); // bypassa il indietro di default e torna a link
	formhidden("hidden_operazione","inseriscilink_finale");
	if ($tipo=="NESSUNO")
		formhidden("id_oggettopuntato",-1);
	else
		popolaComboTipo($tipo,"id_oggettopuntato");
	formbottoneinvia("Spedisci finalmente dati completi");
	formEnd();
	bona();
	}
	else if (Form("hidden_operazione")=="inseriscilink_finale") // ho i dati tutti, ora inserisco...
	{
	scrivi(rosso("Ok ora inserisco..."));

	if ($GETUTENTE=="palladius")
		visualizzaFormz();
	autoInserisciTabella("linkz");
	bona();
	}

?>
<center>
<table width="<?php  echo $CONSTLARGEZZA600?>" border=0>
<tr>
 <td width="30%" valign=top class="colonninadisinistra">
	<h3>Linkz  disponibili</h3>
 </td>
	<td valign=top width="70%" class="colonnonadidestra">
		<h3>
		<?php  
		  if (QueryString("id")) 
				echo "link richiesto";
			else 
				echo "Ultimi $quantiNeVisualizzoINTERAMENTE linkz..."
		?>
		</h3>
 </td>
</tr>
<tr>
 <td valign="top" class="colonninadisinistra">
<?php 
$ii=1;
$res=mq("select *,m_snome from linkz l,loginz u where u.id_login=l.id_login order by titolo");
//openTable();
echo "<table><tr><td>";
$TABELLACOLORIALTERNI=FALSE;
while ($rs=mysql_fetch_array($res))
  if ($TABELLACOLORIALTERNI)
	{
	 tri($ii);
	 scrivi("<td width=51>");
	 $ii=1-$ii;
	 scrivi("<a href='linkz.php?id=".$rs["ID_link"]."'>");	
	?>
		<img src="$IMMAGINI/leggi.gif" alt="leggi commento su questo sito"
		 width=22 height=22 border=0></a>
	<?php 
	 scrivi("</a> ");	
 	 scrivi("<a href='".$rs["URLlink"]."'>");
	?>
		<img src="$IMMAGINI/next.gif" alt="vacci direttamente!!!" width=22 height=22 border=0></a>
	<?php 

	 tdtd();	
	 scrivi($rs["titolo"]);
	}
  else
	{
	 	 scrivi("<a href='linkz.php?id=".$rs["ID_link"]."'>");	
	 scrivi($rs["titolo"]."</a><br>");
	}
echo "</td></tr></table>";
//closeTable();

if(QueryString("id") != "")
	{
	 $res=mq("select * from linkz c,loginz l where id_link=".QueryString("id")
			." AND l.id_login=c.id_login");
	 $rs=mysql_fetch_array($res);
?>
	</td>
	<td valign=top width="70%" class="colonnonadidestra">
<?php 
	scriviReport_Link($rs);



	} // fine caso gestente canzone singola via querystring (id=...)
else
{
?>
	</td>
	<td valign="top" class="colonnonadidestra">
<?php 
$res=mq("select * from linkz c,loginz l where c.id_login = l.id_login order by data_creazione DESC");
for ($j=0;$j<$quantiNeVisualizzoINTERAMENTE ;$j++)
	if($sqlLast10Messaggi=mysql_fetch_array($res))
		{scriviReport_Link($sqlLast10Messaggi);} 
} // fine caso SENZA querystring (pagina caricata vergine, senza "?ID=..."


?>
</td></tr></table></center>
<?php 
if (isGuest())
	bona();


hline(100);
?>
<table>
<tr><td>
	<h1>Aggiungi link</h1>
<center>
<?php 
formBegin();
formtext("titolo","");
$IDRANDOM=random(2000000000);
formhidden("id_link",$IDRANDOM);
formhidden("id_login",Session("SESS_id_utente"));
formhidden("data_creazione",dammiDatamysql());
scrivi("TIPO:");
popolaComboTipoLink("tipo");
scrivi("<br>Questo menu a tendina è importantissimo: il tipo scelto verrà "
	. "in future release messo automaticamente a fianco del 'contenuto' cui è stato"
	. " associato; se x esempio scegli 'goliardi', poi ti verrà dato un menu a t"
	. "endina di scelta tra i vari goliardi in cui, x esempio sceglierai 'Ribot'."
	. " Quando qualcuno visualizzerà il goliarda Ribot (almeno in futuro) troverà"
	. " automaticamente quel link vicino a lui; lo stesso vale se "
	. " scegli ORDINI e poi DRUIDI, tanto x fare un esempio a caso... Ok?!? Se mi"
	. " ritieni un figo, sei libero di mandarmi una amil e dirmelo.<bR>");
formhidden("m_battiva",1);
formhidden("m_bfotoattiva",0);
formhidden("hidden_operazione","inseriscilink_preliminare");
formtext("URLlink","http://");
formtext("URLlinkfoto","");
scrivi("<br>URL vero e proprio del link, ed eventuale URL di una fotina che sia rappresentativa...<br>");
formtextarea("Descrizione","",7,50);
formbottoneinvia("invia");
formEnd();?>
</center>
</td></tr></table>



<?php 
	include "footer.php";
?>
