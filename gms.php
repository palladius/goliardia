<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

?>
<center>
<h5>In questa pagina potete mandare piccoli messaggi ad altri utenti registrati nel sito. Solo gli utenti registrati possono mandare/ricevere messaggi di tipo GMS. Per favore non fate accumulare i messaggi. Per obbligarvi a farlo, il malefico Webmaster li cancella ogni 2 3 mesi.</h5>
<h1>Goliardic Messaging System&trade; (GMS)</h1>
<?php 

$LUNG_MSG = 255;
$perchi = querystring("per");
if ( $perchi  != "")
	{echo rosso("Mandiamo mo' un gms a $perchi ...<br/>");
	}


$myProv=$_SESSION["_SESS_provincia"];

/*
	 figata! un array dinamico!!! e l'id sar� una funzione univoca (mica oneway, la sicurezza non c'entra!) 
	in funzione del nome del gruppo in modo che io vedo @admin,@buhgs,@prov_BO e un altro vede @admin,@buhgs,@prov_FE.
	e dato che vanno come idutente devo pregare che non capitino nei numeri dei VERI login!!!

	socmel che progetto ambizioso! potrei anche aggiungerci un MAXNUMMSG dipendente dal gruppo.
	PS la scadenza sar� di tipo UNIFORME; ovviamente. dipende dal tempo min. o giorni o secondi,
	forse � meglio secondi.

	x la cancellazione o la faccio automatica, o NON FACCIO VEDERE i vecchi (se non a... me!)
	o faccio un demone CRON, questo lo vedremo insomma.
*/

function getHashFromName($nome) { // e qua mi diverto!
	return abs(hexdec(substr(md5($nome),1,9)) % 2147483647); // 2 giga (32 bit)
}

function popolaComboGruppiGms($label,$dflt) {
global $arrUtenti;
	// devo mettere ID e nome gruppo.
scrivi("\n<select name='".$label."'>\n");
while (list($gruppo,$grupropr)=each ($arrUtenti)) {
	scrivi(" <option ");
	if ($gruppo==$dflt) echo " SELECTED ";
	scrivi(" value='@".getHashFromName($gruppo)."'>".$gruppo);
	scrivi("</option>\n");
}
scrivi("\n</select>\n");
}



function listaUtentiVirtuali($arrUtenti)
{
//opentable();
//echo "<pre>";
while (list($gruppo,$grupropr)=each ($arrUtenti))
	{
	$hash=getHashFromName($gruppo);
	scrivi(h3($gruppo." (hash: ".$hash.")"));
	while (list($k,$v)=each ($grupropr))
		{
		echo "<b>$k</b>: \t$v\n<br/>";
		}
	$sqlgruppo = "select * from gms where idutentericevente=$hash";
	$res=mysql_query($sqlgruppo);
	while ($rs=mysql_fetch_array($res))
		echo ("un messaggio<br/>");
	
	//scriviReport_gms($rs);
	}
//echo "</pre>";
//closetable();
}
function toglichiocciola($str)
{
if ($str[0] != '@') die("gruppo malformato, aiuto! segnala bug");
return substr($str,1);
}


function listaUtentiVirtualiPerTutti($arrUtenti) {
	global $IMMAGINI;
	echo "<table border='0'>";

while (list($gruppo,$grupropr)=each ($arrUtenti))
	{
	$hash=getHashFromName($gruppo);
	$permesso=$grupropr["accesso"];
	if (! $permesso)		
		continue;
			//scrivi(h3($gruppo." (".$grupropr["descr"].")"));
	$titolo = $permesso ?
			h3($gruppo) :
			h3(rosso("$gruppo (nisba) :("));
	echo "<tr><td width='20%'>";
		scrivi($titolo); //." (".$grupropr["descr"].")"));
	tdtd();
	scrivii("(".$grupropr["descr"].")");
	if ($permesso)
	{
	$sqlgruppo = "select g.*,l.m_snome from gms g,loginz l where "
		."idutentericevente=$hash AND g.idutentescrivente=l.id_login order by l.m_snome desc";
	$res=mysql_query($sqlgruppo);
	if (mysql_num_rows($res)==0)
		; //echo "VUOTOOOO";
	else
	{
	tttt();

	  $nomefoto= iniziaper($gruppo,"@citt")
		? "$IMMAGINI/../citta/".Session("provincia").".gif"
		: "$IMMAGINI/../gruppi/".toglichiocciola($gruppo).".jpg";
	 img($nomefoto,50);
	tdtd();
	   tabled();
	   while ($rs=mysql_fetch_array($res)) 	
		scriviReport_gms($rs,$rs["m_snome"]);
 	   tableEnd();
	}
	}
	trtdEnd();
	
	
	}
tableEnd();
}




$arrUtenti = array (
	"@admin"  => array ( 
				"descr" => "Tutti gli Amministratori del sito",
				"scadenza" => 3*86400,
				"accesso" => isadmin()
				 ),
	"@adminvip" => array ( 
				"descr" => "Gli Amministratori + fichi del sito (paused ci boni)",
				"scadenza" => 7*86400,
				"accesso" => isadminvip()
				 ),
	"@bugs" => array ( 
				"descr" => "Segnalazioni su bug, anche l'ultima fetente matricola pu� contribuire",
				"scadenza" => 30*86400,
				"accesso" => isdevelop()
				 ),
	"@help" => array ( 
				"descr" => "Tutti quelli che vogliono aiutare (mo' vedremo come fare, x ora sono tutti gli amminitratori 'simplex')",
				"scadenza" => 3*86400,
				"accesso" => (isadmin() && ! isadminvip())
				 ),
	"@develop" => array ( 
				"descr" => "msg che ci mandiamo da soli io e venerdi' e pochi altri colti su come far cose nuove",
				"scadenza" => 60*86400,
				"accesso" => isdevelop()
				 ),
	"@newbie" => array ( 
				"descr" => "lo leggeranno automaticamente i poveri di GP: consigli da parte dei sapienti",
				"scadenza" => 3*86400,
				"accesso" => isguest()
				 ),
	"@immediato" => array ( 
				"descr" => "Messaggi immediati, tipo entrate tutti in chat o USCITE E RINETRATE o cose simili",
				"scadenza" => 600,  // dis minot
				"accesso" => TRUE // se lo vedi sei li' :-))) poi sta a me farlo morire in fretta
				 ),
	"@all" => array ( 
				"descr" => "TUTTI, miiiiiiiii!",
				"scadenza" => 600, // dis minot
				"accesso" => TRUE
				 ),
	"@citta_".$myProv => array ( 
				"descr" => "Tutti gli utenti della mia citt� ($myProv), in realt� sono N gruppi...",
				"scadenza" => 3*86400,
				"accesso" => TRUE // il chk sulla citt� lo fai gi� TU che ne determini il nome ;-)))
				 )
	);






$myidlogin = getIdLogin();

$sqlsinistra=  "select * from gms where idutentericevente="
		.$myidlogin . " order by data_invio desc";
$sqldestraOLD= 	  "SELECT g.*,lr.m_snome as NOMERIC,ls.m_snome as nomeinv "
		. " FROM  gms g,loginz ls,loginz lr where idutentericevente=lr.id_login"
		. " AND   ls.id_login=g.idutentescrivente"
		. " ORDER BY data_invio DESC";

$sqldestra= 	  "SELECT g.*,lr.m_snome as NOMERIC,ls.m_snome as nomeinv "
		. " FROM  gms g,loginz ls,loginz lr where idutentericevente=lr.id_login"
		. " AND   ls.id_login=g.idutentescrivente"
		. " AND   ".$myidlogin."=g.idutentericevente"
		. " ORDER BY data_invio DESC";

/*
$sqlgruppo=	  	"SELECT g.*  "
		. " FROM  gms g where g.idutentericevente=lr.id_login"
		. " AND   ls.id_login=g.idutentescrivente"
		. " AND   ".$myidlogin."=g.idutentericevente"
		. " ORDER BY data_invio DESC";
*/


//if (isGuest())
//	{scrivi(" niente gms x te, manda una foto prima ;-)");
//	 bona();
//	}


/*
function replace(str1,str2,str3) {
  while (str1.indexOf(str2)!=-1) str1 = str1.replace(str2,str3);
  return str1;
}
*/




function scriviReport_gms($rs,$nome="",$confoto=TRUE)
{
global $AUTOPAGINA,$ISGUEST;
if ($nome=="")
	$nome=$rs["nomeinv"]; // comportaemento di dflt non vorrebbe il nome, quindi lo assegno!!!
trtd();

if (! $ISGUEST)
	{
		?>
			<a href='<?php  echo $AUTOPAGINA?>?cancid=<?php  echo $rs["id_gms"]?>'>DEL</a>
		<?php 
	tdtd();
	}
if ($confoto)
	scrivi(getFotoUtenteDimensionata($nome,40));
tdtd();
	$nuovo= ($rs["m_bNuovo"]==1);
	$msg= stripslashes($rs["messaggio"]); // trasforma c\'� in c'�
	if ($nuovo)
		scrivi("<b>$msg</b>");
	else
		scrivi(($msg));
	scrivi(" <i>(".$nome.")</i>");
tdtd();
//	scrivi(toHumanDateConMinuti(time($rs["data_invio"])));
	scrivi((($rs["data_invio"])));
trtdEnd();
}



function palleggiaForm($nome)
	{   formhiddenApici($nome,replace((Form($nome)),"\"","''")); }






$iddacancellareeventualmente = (QueryString("cancellaid"));
if  (! empty($iddacancellareeventualmente))
{
if (! isAdminVip()) 
	scrivi("cazzo fai? hai violato le prime difese del dibb�... complimenti...");
else
	{
	 mysql_query("delete * from gms where id_gms=".$iddacancellareeventualmente)
		or die("non son riuscito a cancellare il GMS1... :( ".mysql_error());
	 scrivi("<h1>fatto! <a href='gms.php'>Torna indietro</a></h1>");
	 bona();
	}

}



$iddacancellareeventualmente = (QueryString("cancellaidprofano"));

if  (!empty($iddacancellareeventualmente ))
{
 mysql_query("delete * from gms where idutentericevente=".$myidlogin." AND id_gms=".$iddacancellareeventualmente)
			or die("non son riuscito a cancellare il GMS2... :( ".mysql_error());
 scrivi("<h1>fatto! <a href='gms.php'>Torna indietro</a></h1>");
 bona();

}





if(QueryString("cancid") != "")
{
 $sql = "DELETE FROM `gms` where id_gms=".QueryString("cancid");

echo "QUERY: [$sql]<br/>";

 mysql_query ($sql)
		or die("non son riuscito a cancellare il GMS3... :( ".mysql_error());
 ridirigi($AUTOPAGINA);
}


if (Form("hidden_operazione")=="inseriscigms_preliminare") // chiede inserimento x un certo tipo...
	{
	$nome=Form("nome_utente");

//	if (getUtente()=="palladius")		visualizzaFormz();


		// controllo che l'utente esista...
	$sql2="select id_login,m_snome from loginz WHERE m_bguest=0 AND m_snome like '".$nome."%' order by m_snome";
	if (isAdminVip()) {	# adminvip mandano GMS anche a guestz!
		$sql2="select id_login,m_snome from loginz WHERE  m_snome like '".$nome."%' order by m_snome";
	}
		
	$res2=mysql_query($sql2)
		or die("errore nella query '$sql2':".mysql_error());
	
	
	if (!($rsutente2=mysql_fetch_array($res2)))
		{		  // gestisciEventualitaGruppo($nome); se inizia x chiocciola � mio!!!
		 if ($nome[0] == '@')
			{//echo "� x un gruppo! nome vale [$nome].<br>";
			 $depuro=substr($nome,1); // depurato!!!
			 //echo "avanza '$depuro'.";
			 // non mi interessa il $nome !!!
			$idutentericevente=$depuro;
			$resquantigia=mysql_query("select count(*) as QUANTI from gms where idutentericevente=".$idutentericevente);
			$quantigia=mysql_fetch_row($resquantigia);
			scrivi("Egli ha ricevuto finora <b>".rosso($quantigia[0])."</b> messaggi (su <b>?!?</b>)... ");
			if (intval($quantigia[0]) >= 30 ) // x ora, poi far� un controllo precipuo...
				{scrivib(rosso("troppi!!!")); bona();
				 scrivi("<big><a href='".$AUTOPAGINA."'>torna indietro</a></big>");
				}
			  else
				{
				 scrivib(" OK.");
				 invio();
				 $msgTagliato=(Form("messaggio"));
				 $lung=strlen($msgTagliato);
				 if ($lung > $LUNG_MSG )	
					{
					scrivi(rosso("Attenzione, l'ho tagliato a $LUNG_MSG da ".strlen($msgTagliato)." qual era lungo"));
					$msgTagliato = substr($msgTagliato,0,$LUNG_MSG); 
					}
				 scrivi("Il messaggio che stai x inviare (lungo $lung) �: '");
				 scrivib($msgTagliato."'");
				 invio();
				 formBegin($AUTOPAGINA);
				 palleggiaForm("messaggio");
				 palleggiaForm("id_gms");
				 palleggiaForm("idutentescrivente");
				 formhidden("idutentericevente",$depuro);
				 palleggiaForm("data_invio");
				 palleggiaForm("m_bNuovo");
				 formhidden("hidden_tornaindietroapagina","gms.php"); // bypassa il indietro di default e torna a gms
				 formhidden("hidden_operazione","inseriscigms_finale");
				 formbottoneinvia("invia GMS");
				formEnd();

				formbegin();
				 formhidden("nome_utente",Form("nome_utente"));
				 formhidden("messaggio",Form("messaggio"));
				 formbottoneinvia("erore, tornaindietro (x zia Margi)");
				formend();

				scrivi(h3("Clicca mo'! Cos� mandi il msg al gruppo che hai scelto!"));
				bona();
				}
		

			}
		 scrivi(rosso("attenzione, l'utente '".$nome."' non esiste tra gli sbur-userz!")); 
		 bona();
		}	

	$nome = $rsutente2["m_snome"]; // non necessariamente nome E' intero...
	$idutentericevente=$rsutente2["id_login"];

		// controllo non abbia gi� ricevuto OTTO messaggi
	$resquantigia=mysql_query("select count(*) as QUANTI from gms where idutentericevente=".$idutentericevente);
	$quantigia=mysql_fetch_row($resquantigia);
	
	tabled();
	trtd();
			scrivi(getFotoUtenteDimensionata($nome,70));
	tdtd();
	scrivi("<b>".$nome."</b> ha ricevuto finora <b>".rosso($quantigia[0])."</b> messaggi (su <b>".$MAX_GMS_AMMISSIBILI. "</b>)... ");
	if (intval($quantigia[0]) >= $MAX_GMS_AMMISSIBILI )
		{scrivib(rosso("troppi!!!")); bona();
		 scrivi("<big><a href='".$AUTOPAGINA."'>torna indietro</a></big>");
		}
	else 
	{
	 scrivib(" OK.");
	 invio();
	 scrivi("il messaggio (troncato a ".$LUNG_MSG." caratteri) che invierai  �: '");
	 $msgTagliato=(Form("messaggio"));
	 if (strlen($msgTagliato)> $LUNG_MSG )	
		$msgTagliato = substr($msgTagliato,0,$LUNG_MSG); 
	 scrivib(stripslashes($msgTagliato)."'");
	 invio();
	 formBegin($AUTOPAGINA);
	 palleggiaForm("messaggio");
	 palleggiaForm("id_gms");
	 palleggiaForm("idutentescrivente");
	 formhidden("idutentericevente",$idutentericevente);
	 palleggiaForm("data_invio");
	 palleggiaForm("m_bNuovo");
	 formhidden("hidden_tornaindietroapagina","gms.php"); // bypassa il indietro di default e torna a gms
	 formhidden("hidden_operazione","inseriscigms_finale");
	 formbottoneinvia("invia GMS");
	formEnd();

				formbegin();
				 formhidden("nome_utente",Form("nome_utente"));
				 formhidden("messaggio",Form("messaggio"));
				 formbottoneinvia("erore, tornaindietro (x zia Margi)");
				formend();

	}
	trtdEnd();
	tableEnd();
	bona();
	}

									// ho i dati tutti, ora inserisco...

	else if (Form("hidden_operazione")=="inseriscigms_finale") 
	{
	scrivi(rosso("Ok ora inserisco..."));
	if (getUtente()=="palladius")
		visualizzaFormz();
	autoInserisciTabella("gms");
	ridirigi($AUTOPAGINA);
	bona();
	}



if ($ISPAL)
{
	$res=mysql_query("select count(*) from gms");
	$rs=mysql_fetch_array($res);
	scrivi(h3("Pal: ".$rs[0]." gms nel dibb�"));
}

?>
<center>
<table width="<?php  echo $CONSTLARGEZZA600?>" border=3>
<?php 

if ($perchi == ""
	||
    $perchi[0]!='@'		// non gruppo
	)	
	reportGMSpersonali();

function reportGMSpersonali()
{
global $AUTOPAGINA,$sqldestra,$perchi;

echo "<tr><td valign=top width='70%'><h3>I tuoi GMS personali...</h3>";

{	// caso senza querystring (de che? vecchio da asp, boh!)
$quantiNeVisualizzoINTERAMENTE=50;
$res=mysql_query($sqldestra);
tabled();
for ($j=0;$j< $quantiNeVisualizzoINTERAMENTE  ; $j++)
  if($row=mysql_fetch_array($res))
	scriviReport_gms($row);
tableEnd();

} // fine caso SENZA querystring (pagina caricata vergine, senza "?ID=..."
	// MA DE CHE? togliamo il comm spora? � obsoleto mi sa

tdtdtop();
echo "<h2>Spedisci un GMS a 1 persona</h2><center>";

if (isGuest())
	{
	spapla("Mi spiace, sei guest e non puoi mandare msg a mezzo mondo. Manda una foto prima");
	}
else
	{
formBegin($AUTOPAGINA);
formtextarea("messaggio",Form("messaggio"),3,15);  
	// se � appena tornato indietro vale il valore del msg passato in avanti....
$IDRANDOM=rand(1,2000000000); // long...
formhidden("id_gms",$IDRANDOM);
formhidden("idutentescrivente",Session("SESS_id_utente"));
invio();
formtext("nome_utente",$perchi);
formhidden("data_invio",dammiDatamySqL());
formhidden("m_bNuovo",1);
formhidden("hidden_operazione","inseriscigms_preliminare");
invio();
formbottoneinvia("clicca qui e segui ulteriori istruzioni");
formEnd();
	}
echo "</center></td></tr>";
}



if (
	$perchi == "" 
		||
	$perchi[0]=="@"
	)
	scrivireportGMSgruppo();


function scrivireportGMSgruppo()
{global $arrUtenti,$AUTOPAGINA,$perchi;
echo "<tr><td valign=top width='70%'><h3>GMS di gruppo...</h3>";


listaUtentiVirtualiPerTutti($arrUtenti);


/*
	if (FALSE)
	{
	$quantiNeVisualizzoINTERAMENTE=50;
	$res=mysql_query($sqldestra);
	tabled();
	for ($j=0;$j< $quantiNeVisualizzoINTERAMENTE  ; $j++)
	  if($row=mysql_fetch_array($res))
		scriviReport_gms($row);
	tableEnd();
	} 
*/
tdtdtop();
echo "<h2>Spedisci un GMS a 1 gruppo</h2><center>";

formBegin($AUTOPAGINA);
formtextarea("messaggio","",3,15);
$IDRANDOM=rand(1,2000000000); // long...
formhidden("id_gms",$IDRANDOM);
formhidden("idutentescrivente",Session("SESS_id_utente"));
invio();
popolaComboGruppiGms("nome_utente",$perchi); // hahah che OOrientedness :-) natalino sarebbe proud o'me
formhidden("data_invio",dammiDatamySqL());
formhidden("m_bNuovo",1);
formhidden("hidden_operazione","inseriscigms_preliminare");
invio();
formbottoneinvia("clicca qui e segui ulteriori istruzioni");
formEnd();


echo "</center></td></tr>";

}
?>



</table>








Grosse novit�, verranno implementati dei gruppi (@admin, @newbie, @bugs, @admin, @develop, @adminvip e cos� via. 
Queste supporteranno nativamente (non vuol dire un cazzo, ma suonava bene!) i GMS. Inoltre gli ospiti potranno 
mandare GMS a certi gruppi (@admin, @bugs, ...) e cos� potranno ricevere msg da pochi (da @admin in su). Keep in touch.
</center> 

<?php 
if (isGuest())
	bona();



include "footer.php";
?>
