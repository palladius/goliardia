<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$PUOAGGIUNGEREFAQ = isadmin();

if (Form("hidden_operazione")=="inserisciFAQ")
	{
	scrivi(rosso("Sto inserendo una FAQ..."));
	autoInserisciTabella("faq");
	bona();
	}
else
if (Form("hidden_operazione")=="cancellafaq")
	{
	scrivi(rosso("Sto cancellando la FAQ..."));
	autoCancellaTabella("faq","idfaq");
	bona();
	}




?>
 <center><h3>Amministratori che ti possono aiutare...</h3></center>

<table>
<tr valign="top">
<td valign="top">
<?php 

$MYPROVINCIA= strtolower(Session("provincia"));

$rs2=mysql_query("SELECT m_snome as _fotoutente,m_snome as utente,provincia,m_hemail as _email " ." from loginz  where m_bAdmin=1 AND provincia='".$MYPROVINCIA."' order by m_snome"); 

if ($ISANONIMO)
	{scrivib("x ragioni di sicurezza non te li faccio vedere :-)");}
else
 	scriviRecordSetConTimeout($rs2,30,"Amministratori della tua città","Amministratori di $MYPROVINCIA: non esitare a scrier loro! Ti aiuteranno coi tuoi problemi..");
?>
</td>
<td valign="top">
Se avete problemi di qualche tipo col sito, volete vi sia dato in gestione un ordine, 
cercate X FAVORE di non scomodare me: ci son cose (tipo mettere foto eccetera) che posso 
fare solo io, ma tante che possono fare i miei prodi amministratori. Qua vi faccio vedere 
uno specchietto degli amministratori del sito x città: se siete USER mandate loro un GMS, 
se guest è cmq molto probabile che conosciate di persona almeno uno di loro... sbaglio?). 
Se dovete farvi dare in gestione un ordine o una città o un goliarda, o non sapete come 
fare qc, cercate di scomodare prima il vostro amministratore di fiducia, ok? Grazie. 
PS Cercasi amministratore (esigenze: che ne sappia abbastanza di informatica più che 
di goliardia: ho + paura che rovini il DB + che faccia una cosa politicamente scorretta, 
nel qual caso si corregge anche prima!) per ogni città (mi mancano principalmente PV, FI, MO, MI, ... 
mentre ne ho troppi per Torino e Parma...) :-)))
<br/>
<b>Se dovete mandare foto, mandatele al mio fedele attuale aiutante, <?php  echo $TAG_MIO_AIUTANTE?></b>.

</td>
</tr>
</table>


<h1> Funny Untied Chicken Knots </h1>

<table border=3 width="<?php  echo CONSTLARGEZZA600?>"><tr><td width="30%" valign=top>
	<h3>FAQ disponibili</h3>
<?php 

$res=mysql_query("select * from faq  order by data DESC");
$i=1;
openTable();
	tabled();
while ($rs=mysql_fetch_array($res))
	{$i=1-$i;
	 tri($i);
	 scrivi("<td>");
	 scriviReport_FAQ($rs,"breve");
	 trtdEnd();
	}
	tableEnd();
	closeTable();

if(((QueryString("id")!="")))
	{
	 $res=mysql_query("select * from faq  where idfaq=".QueryString("id"));
	 $rs=mysql_fetch_array($res);
?>
	</td>
	<td valign=top width="70%">
		<h3>FAQ richiesta (<b class=inizialemaiuscola><?php  echo $rs["domanda"]?></b>)...</h3>
<?php 

	openTable();
	scriviReport_FAQ($rs);
	closeTable();


	} // fine caso gestente canzone singola via querystring (id=...)
else
{

	


$quantiNeVisualizzoINTERAMENTE=30;

?>
	</td>
	<td valign=top width="70%">
		<h3>Ultime <?php  echo $quantiNeVisualizzoINTERAMENTE?> FAQ...</h3>
<?php 


$res=mysql_query("select * from faq  order by data DESC");


for ($j=0;$j< $quantiNeVisualizzoINTERAMENTE ; $j++)
if($rs=mysql_fetch_array($res))
	scriviReport_FAQ($rs);

} // fine caso SENZA querystring (pagina caricata vergine, senza "?ID=..."


?>

</td></tr></table></center>
<?php 
if ($PUOAGGIUNGEREFAQ)
{
hline(100)?>
<table>
<tr><td>
	<h1>Aggiungi FAQ</h1>
<center>
<?php 
formBegin($AUTOPAGINA);
formtext("domanda","");
formhidden("data",dammidatamysql());
formhidden("hidden_operazione","inserisciFAQ");
scrivi("<table valign=top>");
scrivi("<tr><td valign=top>");
scrivi("Metti qui la risposta vero e proprio della FAQ<br>");
formtextarea("risposta","",30,50);
trtdEnd();
tableEnd();
formbottoneinvia("invia");
formEnd();
}
?>
</center>
</td></tr></table>


<?php 
include "footer.php";
?>
