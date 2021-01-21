<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$myLivello=getMyLivello();
?>
		<h1> Contenuti </h1>
	(il tuo livello è: <?php  echo $myLivello?>)


<?php 

	
$res = mq("select * from contenuti c,loginz l where m_nLivelloSegretezza>=".$myLivello
	." AND m_binattesa=0 AND c.m_bAttivo=1 AND c.idlogin=l.id_login order by tipo, datacreazione DESC");

$seqlLast10MessaggiDaAttivare = mq("select * from contenuti c,loginz l where m_binattesa=1 AND c.idlogin "
	."= l.id_login order by datacreazione DESC");

$tipoquerystring = QueryString("tipo");

$seqlLast10MessaggiAttivi=mq(
	(!empty($tipoquerystring)) ? // tipo è definito
			"select * from contenuti c,loginz l where m_nLivelloSegretezza>=".$myLivello
			." AND m_binattesa=0 AND c.m_bAttivo=1 AND tipo='".$tipoquerystring
			."' AND c.idlogin = l.id_login order by tipo, datacreazione DESC"
	: // se no, generico
			"select * from contenuti c,loginz l where m_nLivelloSegretezza>=".$myLivello
			. " AND m_binattesa=0 AND c.m_bAttivo=1 AND c.idlogin = l.id_login or"
			. "der by tipo, datacreazione DESC"
	);

$seqlLast10MessaggiDisattivati = mq("select * from contenuti c,loginz l where m_binattesa=0  AND "
		. "c.m_bAttivo=0  AND c.idlogin = l.id_login order by datacreazione DESC");

	// creo qua una tabella che dev'essere SEMPRE COERENTE
$arrTipi = Array(
	"altro",
	"statuti",
	"cazzate",
	"storie",
	"inviti",
	"giornalini",
	"barzellette",
	"aiuto",
	"sito",
	"attualita",
	"goliardia",
	"scienza"  // lui è il dodicesimo, arr[11]
	); 
if ($ISPAL)
	$arrTipi[12]="PALNEWS";



// LIVELLI DI SEGRETEZZA
$arrLivSegretezza = Array(
			"PAL ONLY","ADMIN VIP ONLY","ADMIN ONLY","SBUR USER.",
			"GUEST.", "TUTTI"
			);

function getMyLivello()
{
global $ISPAL;
if ($ISPAL) return 0;
if(isAdminVip()) return 1;
if(isAdmin()) return 2;
if(isGuest()) return 4;
if (anonimo()) return 5;
return 3; // dflt: user
}


/* a II del mio livello e di quello del recordset.target, decide seposso amministrare quel contenuto...
	è necessario che CANADMIN >= CANSEE, x ora la tabella è:
	NUM	VEDERE	ADMIN
	0	PAL		PAL
	1	VIP		VIP
	2	ADM		ADM
	3	USER		ADM	
	4 	GUEST		ADM
	5 	ANY		ADM
*/
function puoAmministrare($rs)
{
global $ISPAL;
	//scrivi(rosso("(mio livello: ".$myLivello."; liv.msg: ".$rs["m_nLivelloSegretezza").")"));
	//if (myLivello >= 2) return isAdmin(); // x amministrare da admin in giù + nec.suff. essere admin
	//return String(rs("m_nLivelloSegretezza")) == String(myLivello);

if (! isAdmin()) return FALSE;
if($ISPAL) return TRUE; // 0 in su
if (isAdminVip()) return ($rs["m_nLivelloSegretezza"] >= 1); // 1 in su
return ($rs["m_nLivelloSegretezza"] >= 2); // 2 in su
}


$myidlogin = getIdLogin();

function scriviReport_contenuto($rs,$visualizz)
{
 global $arrLivSegretezza;

 // vi sono 3 tipi di visualizzazione:
	// 10: scarna, solo titolo e autore
	// 20: media, titolo e molti dati e un pezzo di storia
	// 30: completo.

 $CANADMIN = puoAmministrare($rs);

// x ora modifico 10 e 20 insieme... in futuro rimetterò il "if (... < 10) do {GESTISCI10}"

if ($visualizz<=20)
	{if ($CANADMIN)
		scrivi("<a href=contenuti.php?gestisci_id=".$rs["idcontenuto"].">ADM</a> ");
	 scrivi("<a href=contenuti.php?id=".$rs["idcontenuto"].">");
 	  scrivib($rs["titolo"]);			
	 scrivi("</a>");
	 scrivi(" (<b>".$rs["tipo"]."</b>, by <i>".$rs["m_sNome"]."</i>)<br>");
	 return;
	}
openTable();
	$nomeadmin="UNDEFD ERORE"; // se è 0, metti CSM se no calcola nome e mettilo...
	if ($rs["idloginpubblicante"] == 0)
		$nomeadmin = "nessuno";
	else {$resAdmin=mq("select m_sNome from loginz where id_login=".$rs["idloginpubblicante"]);
		$rsAdmin=mysql_fetch_row($resAdmin);
		$nomeadmin = $rsAdmin[0];
		}

	FANCYBEGIN($rs["titolo"]);
	 tabled(); 
	  trtd();
		scriviCoppia("in attesa",$rs["m_bInAttesa"]);
		scriviCoppia("attivo",$rs["m_battivo"]);
		scriviCoppia("serio",$rs["m_bSerio"]);
		scriviCoppia("livello di segretezza",$arrLivSegretezza[$rs["m_nLivelloSegretezza"]]);
	  tdtd();
		img("contenuti/".$rs["tipo"].".jpg",70);
	  tdtd();
	  	scrivi(getFotoUtenteDimensionataRight($rs["m_sNome"],80));
	if ($nomeadmin != "nessuno")
		{
		 tdtd();
	  	 scrivi(getFotoUtenteDimensionataRight($nomeadmin,70));
		}
	tttt();
		scriviCoppia("data creazione",$rs["datacreazione"]);
		scriviCoppia("data pubbli<b>cazzone</b>",$rs["datacreazione"]);
	tdtd();
		scriviCoppia("tipo",$rs["tipo"]);
	tdtd();
		scriviCoppia("postato da",$rs["m_sNome"]);
	if ($nomeadmin != "nessuno")
		{
		 tdtd();
		 scriviCoppia("accertato da",$nomeadmin);
		}
	trtdEnd(); 
	tableEnd();
	FANCYMIDDLE();
	 $contenuto = stripslashes(nl2br($rs["contenuto"]));
	  echo $contenuto;
	FANCYEND();
 closeTable();
}

function popolaComboTipoContenuto($ID)
{
 scrivi("\n<select name='".$ID."'>\n");
 $i=0;
 for($i=0;$i<sizeof($arrTipi);$i++)
 	{
	scrivi(" <option ");
	scrivi(" value='".$arrTipi[$i]."'>".$arrTipi[$i]);
	scrivi("</option>\n");
	}
 scrivi("</select>");
}


function popolaComboByArr($ID,$Arr,$tipoindice)
{
 scrivi("\n<select name='".$ID."'>\n");
 $i=0;
 for($i=0;$i<sizeof($Arr);$i++)
	{
	 scrivi(" <option ");
	 scrivi(" value='".
		($tipoindice=="numero" 
			? $i
			: $Arr[$i]
		)
		."'>".$Arr[$i]);
	 scrivi("</option>\n");
	}
scrivi("</select>");
}




$iddagestire = QueryString("gestisci_id");
if  (!empty($iddagestire ))
{
if (! isAdmin()) 
	scrivi("cazzo fai? hai violato altre difese del dibbì... complimenti... scrivimi x "
		."favore su quanto è successo... sempre che tu appartenga al lato buono...");
	else
	{echo(h1("Pagina di gestione del contenuto numero ".$iddagestire.".."));
 	 $res= mq("select * from contenuti c,loginz l where c.idcontenuto="
			.$iddagestire." AND c.idlogin = l.id_login");
	 $rs=mysql_fetch_array($res);
 	 scriviReport_contenuto($rs,30);
	 scrivi("<b>ATTENZIONE</b> Se non voglio nè censurare l'articolo nè pubblicarlo, basta "
		."non far nulla. Saranno altri a farsi carico della scelta...");
	formBegin();
	 formhidden("my_hidden_id",$iddagestire);	
	 formhidden("idloginpubblicante",Session("SESS_id_utente"));	// lo sto pubblicando io!
	 formhidden("datapubblicazione",dammiDatamysql());
	 formhidden("m_binattesa",FALSE);
	 formhidden("m_bAttivo",TRUE);
	 formhidden("hidden_operazione","pubblicaomenoilcontenuto");
	 formbottoneinvia("PUBBLICO il CONTENUTO");
	formEnd();
	formBegin();
	 formhidden("my_hidden_id",$iddagestire);	
	 formhidden("idloginpubblicante",Session("SESS_id_utente"));	// lo sto pubblicando io!
	 formhidden("datapubblicazione",dammiDatamysql());
	 formhidden("m_binattesa",FALSE);
	 formhidden("m_bAttivo",FALSE);
	 formhidden("hidden_operazione","pubblicaomenoilcontenuto");
	 formbottoneinvia("CENSURO il CONTENUTO");
	formEnd();

if ($ISPAL)
	{
	formBegin();
	 formhidden("my_hidden_id",$iddagestire);	
	 formhidden("hidden_operazione","cancellailcontenuto");
	 formbottoneinvia("CANCELLO il CONTENUTO");
	formEnd();
	}
bona();
}
}


function palleggiaForm($nome)
	{  formhiddenApici($nome,replace(Form($nome),"\"","''")); }






	//		PROGRAMMA VERO E PROPRIO

$iddacancellareeventualmente = QueryString("cancellaid");

if  (!empty($iddacancellareeventualmente ))
	{
	if (! isAdminVip()) 
		scrivi("cazzo fai? hai violato le prime difese del dibbì... complimenti...");
	  else
		{
		 $res=mq("delete * from contenuti where id=".$iddacancellareeventualmente);
		 tornaindietro($AUTOPAGINA,"fatto! Torna indietro");
		 bona();
		}
}

$iddacancellareeventualmente = QueryString("cancellaidprofano");

if  (!empty($iddacancellareeventualmente ))
	{
	 $res=mq("delete * from contenuti where idlogin=".$myidlogin
		." AND idcontenuto=".$iddacancellareeventualmente);
	 scrivi("<h1>fatto! <a href='contenuti.php'>Torna indietro (ric cambialo)</a></h1>");
	 bona();
	}

if (Form("hidden_operazione")=="cancellailcontenuto") // ho i dati tutti, ora inserisco...
	{
	scrivi(rosso("Ok ora CANCELLO il contenuto..."));
	if ($ISPAL) visualizzaFormz();
	autoCancellaTabella("contenuti","idcontenuto");
	bona();
	}

if (Form("hidden_operazione")=="pubblicaomenoilcontenuto") // ho i dati tutti, ora inserisco...
	{
	 scrivi(rosso("Ok ora modifico lo status del contenuto..."));
	 if ($ISPAL) visualizzaFormz();
	 autoAggiornaTabella("contenuti","idcontenuto");
	 bona();
	}

if (Form("hidden_operazione")=="inseriscicontenuto_finale") // ho i dati tutti, ora inserisco...
	{
	scrivi(rosso("Ok ora inserisco..."));
	if ($ISPAL) visualizzaFormz();
	autoInserisciTabella("contenuti");
	bona();
	}
?>
	<center>
		<table width="<?php  echo $CONSTLARGEZZA600?>" border=0><tr><td width="30%" valign=top>
				<h3>Contenuti disponibili</h3>
<?php 
$oldTipo = "NIUN_CH_ESISTA";
$MAXPERTIPO = 5 ;
$ii=1;



openTable();
trtd();
while ($rs=mysql_fetch_array($res))
	{$m_bNuovoTipo = ($oldTipo != ($rs["tipo"]));
	 if ($m_bNuovoTipo)
		$CARDPERTIPO = 0;	
	 $CARDPERTIPO ++;
	 $oldTipo = $rs["tipo"];
	 if ($CARDPERTIPO < $MAXPERTIPO+1) 
		{ // se più di N di un tipo non li stampo +... 
		 if ($m_bNuovoTipo)
			{
			 trtdEnd();
			 tri(2);
			 scrivi("<td >");
			 scrivi(getFotoUtenteDimensionataRight("../contenuti/".$rs["tipo"],40));
			 scrivi(" <big><a href='".$AUTOPAGINA."?tipo=".$rs["tipo"]."'> ");
			 scrivib($rs["tipo"]);
			 scrivi("</a></big> ");
			 $ii=1-$ii;
		  	}
		 scrivi("<a href='".$AUTOPAGINA."?id=".$rs["idcontenuto"]."'>");
		 scrivi($rs["titolo"]);
		 scrivi("</a>, ")	;
		}
	   else  
		if ($CARDPERTIPO == $MAXPERTIPO+1) // cioè, solo la prima volta...
			 {scrivi("... ");}
	}
trtdEnd();
closeTable();
if((QueryString("id")!= ""))
	{
	 $res=mq("select c.*,l.* from contenuti c,loginz l where idcontenuto=".QueryString("id")
			." AND l.id_login=c.idlogin");
	 $rs=mysql_fetch_array($res);
?>
	</td>
	<td valign=top width="70%">
		<h3>contenuto richiesto</h3>
<?php  if (isAdmin()) {    ?>
				<h5>(<a href="contenuti.php?gestisci_id=<?php  echo QueryString("id")?>">AMMINISTRALO</a>)</h5>
<?php 			}
	scriviReport_contenuto($rs,30);

	} // fine caso gestente canzone singola via querystring (id=...)
else
{
?>
	</td>
	<td valign=top width="70%">
<?php 

$LASTDISATTIVIMAX=20;
$LASTATTTIVANDIMAX=20;
$quantiNeVisualizzoINTERAMENTE=20;

if (isAdmin()) // necessario x vedere gli articoli in attesa...
{
?>
		<h2>Admin Only</h2>
<?php 
openTable();
scrivi(h3("In attesa di essere attivati:"));
for ($j=0; $j<$LASTATTTIVANDIMAX ; $j++)
   if($sqlLast10MessaggiDaAttivare=mysql_fetch_array($seqlLast10MessaggiDaAttivare))
	{
	 scrivi(($j+1).") ");
	 scriviReport_contenuto($sqlLast10MessaggiDaAttivare,10);
	} 
?>
	<h3>Disattivati:</h3>
<?php 

for ($j=0; $j<$LASTDISATTIVIMAX ; $j++)
   if($sqlLast10MessaggiDisattivati=mysql_fetch_array($seqlLast10MessaggiDisattivati))
	{
	 scrivi(($j+1).") ");
	 scriviReport_contenuto($sqlLast10MessaggiDisattivati,10);
	} 
closeTable();
} // fine ISADMIN
?>
		<h3>Ultimi <?php  echo $quantiNeVisualizzoINTERAMENTE?> contenuti 
			<?php  if (!empty($tipoquerystring ))
				 scrivi("di tipo <u>".$tipoquerystring ."</u>");
			?>...
		</h3>
<?php 
for ($j=0;$j< $quantiNeVisualizzoINTERAMENTE ; $j++)
  if($sqlLast10MessaggiAttivi=mysql_fetch_array($seqlLast10MessaggiAttivi))
	{
	 scriviReport_contenuto($sqlLast10MessaggiAttivi,20);
	} 
} // fine caso SENZA querystring (pagina caricata vergine, senza "?ID=..."

?>
</td></tr></table></center>
<?php 
if (isGuest())
	bona();
hline(100);

if(!isGuest()) // col bona di prima sto if mi sembra inutile, bah!
{ 	// solo USER possono inserire contenuti...
?>
<table>
<tr><td>
	<h1>Aggiungi Contenuto</h1>
<center>
<?php 
formBegin();
formtext("titolo","");
#$IDRANDOM=random(3,2000000000); // long...
$IDRANDOM=random(2000000000); // long...
#echo "DEBUG: RANDOM VALE $IDRANDOM<br><br>";
formhidden("idcontenuto",$IDRANDOM);
formhidden("idlogin",Session("SESS_id_utente"));
formhidden("idloginpubblicante",0);	// ancora nessuno l'ha pubblicato...
formhidden("datacreazione",dammiDatamysql());
invio();
scrivi("Tipo");
popolaComboByArr("tipo",$arrTipi,"nome");
invio();

scrivi("Leggibile da:");
popolaComboByArr("m_nLivelloSegretezza",$arrLivSegretezza,"numero");
formhidden("m_battivo",FALSE);
formhidden("m_binattesa",TRUE);
formhidden("hidden_operazione","inseriscicontenuto_finale");
//formhidden("hidden_operazione","inseriscicontenuto_preliminare");
invio();
formtextarea("contenuto","",15,70);
formbottoneinvia("invia");
formEnd();
?>
</center>
</td></tr></table>
<?php 
	} // fine IF SBURUSER

include "footer.php";
?>
